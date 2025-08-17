<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>POS Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">POS Test Page</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Products -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-semibold mb-4">Products</h2>
                <div class="space-y-2">
                    @foreach($products as $product)
                    <div class="border p-3 rounded cursor-pointer hover:bg-gray-50" 
                         onclick="addProduct('{{ $product->product_code }}', '{{ $product->name }}')">
                        <div class="font-medium">{{ $product->name }}</div>
                        <div class="text-sm text-gray-600">{{ $product->product_code }}</div>
                        <div class="text-lg font-bold text-blue-600">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Cart -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-semibold mb-4">Cart</h2>
                <div id="cart-items" class="space-y-2 mb-4">
                    <div class="text-gray-500 text-center py-4">Cart is empty</div>
                </div>
                <div class="border-t pt-4">
                    <div class="flex justify-between font-bold">
                        <span>Total:</span>
                        <span id="cart-total">Rp 0</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Debug Info -->
        <div class="mt-6 bg-white p-4 rounded-lg shadow">
            <h3 class="font-semibold mb-2">Debug Info</h3>
            <div id="debug-info" class="text-sm text-gray-600"></div>
        </div>
    </div>

    <script>
        let cart = {};
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
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
        
        function addProduct(productCode, productName) {
            console.log('Adding product:', productCode, productName);
            
            fetch('/test/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_code: productCode,
                    qty: 1
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                updateDebugInfo('Product added successfully: ' + JSON.stringify(data));
                if (data.success) {
                    showNotification(`Produk ${productName} berhasil ditambahkan ke keranjang`, 'success');
                    updateCart(data.cart);
                } else {
                    showNotification(data.error || 'Terjadi kesalahan', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error: ' + error.message, 'error');
                updateDebugInfo('Error: ' + error.message);
            });
        }
        
        function updateCart(cartData) {
            cart = cartData;
            const cartItems = document.getElementById('cart-items');
            const cartTotal = document.getElementById('cart-total');
            
            if (Object.keys(cart).length === 0) {
                cartItems.innerHTML = '<div class="text-gray-500 text-center py-4">Cart is empty</div>';
                cartTotal.textContent = 'Rp 0';
            } else {
                let html = '';
                let total = 0;
                
                Object.values(cart).forEach(item => {
                    html += `
                        <div class="border p-3 rounded">
                            <div class="flex justify-between">
                                <div>
                                    <div class="font-medium">${item.name}</div>
                                    <div class="text-sm text-gray-600">${item.qty} x Rp ${item.price.toLocaleString()}</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold">Rp ${item.subtotal.toLocaleString()}</div>
                                    <button onclick="removeProduct(${item.id})" class="text-red-500 text-sm">Remove</button>
                                </div>
                            </div>
                        </div>
                    `;
                    total += item.subtotal;
                });
                
                cartItems.innerHTML = html;
                cartTotal.textContent = `Rp ${total.toLocaleString()}`;
            }
        }
        
        function removeProduct(productId) {
            fetch('/test/cart/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Remove response:', data);
                if (data.success) {
                    showNotification('Produk berhasil dihapus dari keranjang', 'success');
                    updateCart(data.cart);
                } else {
                    showNotification(data.error || 'Terjadi kesalahan', 'error');
                }
            })
            .catch(error => {
                console.error('Remove error:', error);
                showNotification('Terjadi kesalahan saat menghapus produk', 'error');
            });
        }
        
        function updateDebugInfo(message) {
            const debugInfo = document.getElementById('debug-info');
            const timestamp = new Date().toLocaleTimeString();
            debugInfo.innerHTML += `<div>[${timestamp}] ${message}</div>`;
        }
        
        // Initialize
        updateDebugInfo('Page loaded. CSRF Token: ' + csrfToken.substring(0, 20) + '...');
    </script>
</body>
</html> 