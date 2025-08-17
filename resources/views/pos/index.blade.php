<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
            <div class="flex flex-wrap items-center justify-between">
                <div class="flex items-center">
                    <h1 class="text-2xl md:text-3xl text-slate-800 dark:text-slate-100 font-bold">Point of Sale</h1>
                </div>
                <div class="flex flex-wrap items-center space-x-2">
                    <div class="text-sm text-slate-500 dark:text-slate-400">
                        Kasir: {{ auth()->user()->name }}
                    </div>
                </div>
            </div>
        </div>

        <!-- POS Interface -->
        <div class="grid grid-cols-12 gap-6">
            <!-- Product Search & List -->
            <div class="col-span-12 lg:col-span-8">
                <div class="bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
                    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Pencarian Produk</h2>
                    </header>
                    <div class="p-6">
                        <!-- Product Search -->
                        <div class="mb-6">
                            <div class="flex gap-2">
                                <div class="flex-1">
                                    <input type="text" id="product-code" placeholder="Scan barcode atau ketik kode produk..." class="form-input w-full text-lg" />
                                </div>
                                <input type="number" id="qty" value="1" min="1" class="form-input w-24 text-center" />
                                <button type="button" id="add-to-cart" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                                    Tambah
                                </button>
                            </div>
                        </div>

                        <!-- Product Grid -->
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($products as $product)
                            <div class="bg-slate-50 dark:bg-slate-700 rounded-lg p-4 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-600 transition-colors" 
                                 onclick="addProductToCart('{{ $product->product_code }}', 1)"
                                 data-product-code="{{ $product->product_code }}"
                                 data-product-name="{{ $product->name }}">
                                <div class="text-sm font-medium text-slate-800 dark:text-slate-100">{{ $product->name }}</div>
                                <div class="text-xs text-slate-500 dark:text-slate-400 mb-2">{{ $product->product_code }}</div>
                                <div class="text-lg font-bold text-indigo-600 dark:text-indigo-400">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                <div class="text-xs text-slate-500 dark:text-slate-400">Stok: {{ $product->stock }} {{ $product->unit }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cart -->
            <div class="col-span-12 lg:col-span-4">
                <div class="bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
                    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Keranjang</h2>
                    </header>
                    <div class="p-6">
                        <!-- Cart Items -->
                        <div id="cart-items" class="space-y-3 mb-6 max-h-96 overflow-y-auto">
                            @if(empty($cart))
                                <div class="text-center text-slate-500 dark:text-slate-400 py-8">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                                    </svg>
                                    <p>Keranjang kosong</p>
                                    <p class="text-sm">Pilih produk untuk menambahkan ke keranjang</p>
                                </div>
                            @else
                                @foreach($cart as $item)
                                <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700 rounded-lg">
                                    <div class="flex-1">
                                        <div class="font-medium text-slate-800 dark:text-slate-100">{{ $item['name'] }}</div>
                                        <div class="text-sm text-slate-500 dark:text-slate-400">
                                            {{ $item['qty'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-bold text-slate-800 dark:text-slate-100">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</div>
                                        <button onclick="removeFromCart({{ $item['id'] }})" class="text-rose-500 hover:text-rose-700 text-sm">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>

                        <!-- Cart Total -->
                        <div class="border-t border-slate-200 dark:border-slate-700 pt-4">
                            <div class="flex justify-between items-center text-lg font-bold text-slate-800 dark:text-slate-100 mb-4">
                                <span>Total:</span>
                                <span id="cart-total">Rp {{ number_format(collect($cart)->sum('subtotal'), 0, ',', '.') }}</span>
                            </div>

                            @if(!empty($cart))
                            <!-- Payment Method -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2">Metode Pembayaran</label>
                                <select id="payment-method" class="form-select w-full">
                                    <option value="cash">Cash</option>
                                    <option value="qris">QRIS</option>
                                    <option value="transfer">Transfer</option>
                                </select>
                            </div>

                            <!-- Amount Paid -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2">Jumlah Bayar</label>
                                <input type="number" id="amount-paid" class="form-input w-full" placeholder="0" />
                            </div>

                            <!-- Change -->
                            <div class="mb-6">
                                <div class="flex justify-between items-center text-sm">
                                    <span>Kembalian:</span>
                                    <span id="change-amount" class="font-medium">Rp 0</span>
                                </div>
                            </div>

                            <!-- Checkout Button -->
                            <button id="checkout-btn" class="btn bg-emerald-500 hover:bg-emerald-600 text-white w-full" disabled>
                                Checkout
                            </button>
                            @else
                            <div class="text-center text-slate-500 dark:text-slate-400 py-4">
                                <p class="text-sm">Tambahkan produk untuk checkout</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Debug: Check if script is loaded
        console.log('POS Script loaded');
        
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
        console.log('CSRF Token:', csrfToken);

        // Show notification function
        function showNotification(message, type = 'success') {
            // Remove existing notifications
            const existingNotifications = document.querySelectorAll('.notification-toast');
            existingNotifications.forEach(notification => notification.remove());

            // Create notification element
            const notification = document.createElement('div');
            notification.className = `notification-toast fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full`;
            
            // Set background color based on type
            if (type === 'success') {
                notification.className += ' bg-green-500 text-white';
            } else if (type === 'error') {
                notification.className += ' bg-red-500 text-white';
            } else {
                notification.className += ' bg-blue-500 text-white';
            }
            
            notification.textContent = message;
            
            // Add to page
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }

        // Make functions global
        window.addProductToCart = function(productCode, qty) {
            console.log('Adding product:', productCode, 'qty:', qty);
            
            // Validate input
            if (!productCode || productCode.trim() === '') {
                showNotification('Kode produk tidak boleh kosong', 'error');
                return;
            }
            
            if (!qty || qty < 1) {
                showNotification('Jumlah harus lebih dari 0', 'error');
                return;
            }
            
            fetch('{{ route("pos.cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_code: productCode.trim(),
                    qty: parseInt(qty)
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    // Show success message
                    showNotification(`Produk ${data.product?.name || productCode} berhasil ditambahkan ke keranjang`, 'success');
                    // Reload page to update cart
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showNotification(data.error || 'Terjadi kesalahan', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan saat menambahkan produk: ' + error.message, 'error');
            });
        };

        window.removeFromCart = function(productId) {
            console.log('Removing product:', productId);
            
            if (!productId) {
                showNotification('ID produk tidak valid', 'error');
                return;
            }
            
            fetch('{{ route("pos.cart.remove") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: parseInt(productId)
                })
            })
            .then(response => {
                console.log('Remove response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Remove response data:', data);
                if (data.success) {
                    showNotification('Produk berhasil dihapus dari keranjang', 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showNotification(data.error || 'Terjadi kesalahan', 'error');
                }
            })
            .catch(error => {
                console.error('Remove error:', error);
                showNotification('Terjadi kesalahan saat menghapus produk: ' + error.message, 'error');
            });
        };

        // Calculate change
        document.addEventListener('DOMContentLoaded', function() {
            const amountPaidInput = document.getElementById('amount-paid');
            if (amountPaidInput) {
                amountPaidInput.addEventListener('input', function() {
                    const total = {{ collect($cart)->sum('subtotal') }};
                    const paid = parseFloat(this.value) || 0;
                    const change = paid - total;
                    
                    const changeElement = document.getElementById('change-amount');
                    if (changeElement) {
                        changeElement.textContent = `Rp ${change.toLocaleString('id-ID')}`;
                    }
                    
                    const checkoutBtn = document.getElementById('checkout-btn');
                    if (checkoutBtn) {
                        checkoutBtn.disabled = change < 0;
                    }
                });
            }

            // Checkout button
            const checkoutBtn = document.getElementById('checkout-btn');
            if (checkoutBtn) {
                checkoutBtn.addEventListener('click', function() {
                    const paymentMethod = document.getElementById('payment-method').value;
                    const amountPaid = document.getElementById('amount-paid').value;

                    if (!amountPaid || amountPaid < {{ collect($cart)->sum('subtotal') }}) {
                        showNotification('Jumlah bayar tidak mencukupi', 'error');
                        return;
                    }

                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("pos.checkout") }}';

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    const paymentMethodInput = document.createElement('input');
                    paymentMethodInput.type = 'hidden';
                    paymentMethodInput.name = 'payment_method';
                    paymentMethodInput.value = paymentMethod;
                    form.appendChild(paymentMethodInput);

                    const amountPaidInput = document.createElement('input');
                    amountPaidInput.type = 'hidden';
                    amountPaidInput.name = 'amount_paid';
                    amountPaidInput.value = amountPaid;
                    form.appendChild(amountPaidInput);

                    document.body.appendChild(form);
                    form.submit();
                });
            }

            // Product code input
            const productCodeInput = document.getElementById('product-code');
            if (productCodeInput) {
                productCodeInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        const productCode = this.value.trim();
                        const qty = parseInt(document.getElementById('qty').value) || 1;
                        
                        if (productCode) {
                            addProductToCart(productCode, qty);
                            this.value = '';
                        }
                    }
                });
            }

            // Add to cart button
            const addToCartBtn = document.getElementById('add-to-cart');
            if (addToCartBtn) {
                addToCartBtn.addEventListener('click', function() {
                    const productCode = document.getElementById('product-code').value.trim();
                    const qty = parseInt(document.getElementById('qty').value) || 1;
                    
                    if (productCode) {
                        addProductToCart(productCode, qty);
                        document.getElementById('product-code').value = '';
                    } else {
                        showNotification('Masukkan kode produk terlebih dahulu', 'error');
                    }
                });
            }

            // Focus on product code input
            if (productCodeInput) {
                productCodeInput.focus();
            }
        });
    </script>
    @endpush
</x-app-layout> 