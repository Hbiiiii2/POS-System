<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Daily report
     */
    public function daily(Request $request)
    {
        $date = $request->get('date', now()->toDateString());
        
        $transactions = Transaction::with(['user', 'transactionDetails.product'])
            ->whereDate('transaction_date', $date)
            ->get();
            
        $total_sales = $transactions->sum('total_amount');
        $total_transactions = $transactions->count();
        
        $payment_methods = $transactions->groupBy('payment_method')
            ->map(function ($group) {
                return $group->sum('total_amount');
            });
        
        return view('reports.daily', compact('transactions', 'total_sales', 'total_transactions', 'payment_methods', 'date'));
    }

    /**
     * Weekly report
     */
    public function weekly(Request $request)
    {
        $week = $request->get('week', now()->weekOfYear);
        $year = $request->get('year', now()->year);
        
        $startOfWeek = Carbon::now()->setISODate($year, $week)->startOfWeek();
        $endOfWeek = $startOfWeek->copy()->endOfWeek();
        
        $transactions = Transaction::with(['user', 'transactionDetails.product'])
            ->whereBetween('transaction_date', [$startOfWeek, $endOfWeek])
            ->get();
            
        $total_sales = $transactions->sum('total_amount');
        $total_transactions = $transactions->count();
        
        $daily_sales = $transactions->groupBy('transaction_date')
            ->map(function ($group) {
                return $group->sum('total_amount');
            });
        
        return view('reports.weekly', compact('transactions', 'total_sales', 'total_transactions', 'daily_sales', 'startOfWeek', 'endOfWeek'));
    }

    /**
     * Monthly report
     */
    public function monthly(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);
        
        $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
        $endOfMonth = $startOfMonth->copy()->endOfMonth();
        
        $transactions = Transaction::with(['user', 'transactionDetails.product'])
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->get();
            
        $total_sales = $transactions->sum('total_amount');
        $total_transactions = $transactions->count();
        
        $daily_sales = $transactions->groupBy('transaction_date')
            ->map(function ($group) {
                return $group->sum('total_amount');
            });
            
        $top_products = TransactionDetail::with('product')
            ->whereHas('transaction', function ($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('transaction_date', [$startOfMonth, $endOfMonth]);
            })
            ->select('product_id', DB::raw('SUM(qty) as total_qty'), DB::raw('SUM(subtotal) as total_sales'))
            ->groupBy('product_id')
            ->orderBy('total_sales', 'desc')
            ->limit(10)
            ->get();
        
        return view('reports.monthly', compact('transactions', 'total_sales', 'total_transactions', 'daily_sales', 'top_products', 'startOfMonth', 'endOfMonth'));
    }

    /**
     * Export report to PDF
     */
    public function export(Request $request)
    {
        $request->validate([
            'range' => 'required|in:daily,weekly,monthly',
            'value' => 'required',
        ]);
        
        $range = $request->range;
        $value = $request->value;
        
        switch ($range) {
            case 'daily':
                $transactions = Transaction::with(['user', 'transactionDetails.product'])
                    ->whereDate('transaction_date', $value)
                    ->get();
                $title = 'Laporan Harian - ' . Carbon::parse($value)->format('d/m/Y');
                break;
                
            case 'weekly':
                $week = Carbon::parse($value)->weekOfYear;
                $year = Carbon::parse($value)->year;
                $startOfWeek = Carbon::now()->setISODate($year, $week)->startOfWeek();
                $endOfWeek = $startOfWeek->copy()->endOfWeek();
                
                $transactions = Transaction::with(['user', 'transactionDetails.product'])
                    ->whereBetween('transaction_date', [$startOfWeek, $endOfWeek])
                    ->get();
                $title = 'Laporan Mingguan - ' . $startOfWeek->format('d/m/Y') . ' - ' . $endOfWeek->format('d/m/Y');
                break;
                
            case 'monthly':
                $startOfMonth = Carbon::parse($value)->startOfMonth();
                $endOfMonth = $startOfMonth->copy()->endOfMonth();
                
                $transactions = Transaction::with(['user', 'transactionDetails.product'])
                    ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
                    ->get();
                $title = 'Laporan Bulanan - ' . $startOfMonth->format('F Y');
                break;
        }
        
        $total_sales = $transactions->sum('total_amount');
        $total_transactions = $transactions->count();
        
        $pdf = PDF::loadView('reports.export', compact('transactions', 'total_sales', 'total_transactions', 'title'));
        
        return $pdf->stream('report-' . $range . '-' . $value . '.pdf');
    }
}
