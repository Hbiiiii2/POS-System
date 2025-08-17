<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    /**
     * Display POS form
     */
    public function index()
    {
        $products = Product::with('category')->get();
        $cart = session()->get('cart', []);
        
        return view('pos.index', compact('products', 'cart'));
    }

    /**
     * Display POS test page
     */
    public function test()
    {
        $products = Product::with('category')->get();
        $cart = session()->get('cart', []);
        
        return view('pos.test', compact('products', 'cart'));
    }

    /**
     * Add product to cart
     */
    public function addToCart(Request $request)
    {
        try {
            $request->validate([
                'product_code' => 'required|string',
                'qty' => 'required|integer|min:1',
            ]);

            $product = Product::where('product_code', $request->product_code)->first();
            
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'error' => 'Produk tidak ditemukan'
                ], 404);
            }

            if ($product->stock < $request->qty) {
                return response()->json([
                    'success' => false,
                    'error' => 'Stok tidak mencukupi. Stok tersedia: ' . $product->stock
                ], 400);
            }

            $cart = session()->get('cart', []);
            
            if (isset($cart[$product->id])) {
                $cart[$product->id]['qty'] += $request->qty;
            } else {
                $cart[$product->id] = [
                    'id' => $product->id,
                    'product_code' => $product->product_code,
                    'name' => $product->name,
                    'price' => $product->price,
                    'qty' => $request->qty,
                    'subtotal' => $product->price * $request->qty,
                ];
            }

            $cart[$product->id]['subtotal'] = $cart[$product->id]['price'] * $cart[$product->id]['qty'];
            
            session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan ke keranjang',
                'cart' => $cart,
                'product' => [
                    'name' => $product->name,
                    'qty' => $request->qty,
                    'price' => $product->price
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove product from cart
     */
    public function removeFromCart(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|integer',
            ]);

            $cart = session()->get('cart', []);
            
            if (isset($cart[$request->product_id])) {
                unset($cart[$request->product_id]);
                session()->put('cart', $cart);
            }

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dihapus dari keranjang',
                'cart' => $cart,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Checkout process
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,qris,transfer',
            'amount_paid' => 'required|numeric|min:0',
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang kosong');
        }

        $total_amount = collect($cart)->sum('subtotal');

        try {
            DB::beginTransaction();

            // Create transaction
            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'transaction_date' => now()->toDateString(),
                'total_amount' => $total_amount,
                'payment_method' => $request->payment_method,
            ]);

            // Create transaction details and update stock
            foreach ($cart as $item) {
                $product = Product::find($item['id']);
                
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['id'],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Update stock
                $product->decrement('stock', $item['qty']);
            }

            // Create payment record
            Payment::create([
                'transaction_id' => $transaction->id,
                'amount_paid' => $request->amount_paid,
                'change' => $request->amount_paid - $total_amount,
            ]);

            DB::commit();

            // Clear cart
            session()->forget('cart');

            // Redirect to success page instead of directly to PDF
            return redirect()->route('pos.success', $transaction->id)
                ->with('success', 'Transaksi berhasil disimpan');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show success page after checkout
     */
    public function success($id)
    {
        $transaction = Transaction::with(['user', 'transactionDetails.product', 'payment'])->findOrFail($id);
        
        return view('pos.success', compact('transaction'));
    }

    /**
     * Generate receipt PDF
     */
    public function receipt($id)
    {
        $transaction = Transaction::with(['user', 'transactionDetails.product', 'payment'])->findOrFail($id);
        
        $pdf = PDF::loadView('pos.receipt', compact('transaction'));
        
        return $pdf->stream('receipt-' . $transaction->id . '.pdf');
    }
}
