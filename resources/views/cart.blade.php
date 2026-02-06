<x-layout>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f5f5f5;
        }

        .cart-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }

        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .cart-header h1 {
            font-size: 32px;
            color: #333;
        }

        .clear-cart-btn {
            padding: 10px 20px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
        }

        .clear-cart-btn:hover {
            background: #c82333;
        }

        .cart-items {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .cart-item {
            display: flex;
            gap: 20px;
            padding: 20px;
            border-bottom: 1px solid #eee;
            align-items: center;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .item-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            background-color: #f5f5f5;
        }

        .item-info {
            flex: 1;
        }

        .item-name {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
        }

        .item-category {
            color: #666;
            font-size: 14px;
            text-transform: uppercase;
        }

        .item-price {
            font-size: 20px;
            font-weight: 700;
            color: #28a745;
            min-width: 100px;
            text-align: right;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-btn {
            width: 35px;
            height: 35px;
            border: 1px solid #ddd;
            background: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .quantity-btn:hover {
            background: #f5f5f5;
            border-color: #007bff;
        }

        .quantity-display {
            min-width: 40px;
            text-align: center;
            font-weight: 600;
            font-size: 16px;
        }

        .remove-btn {
            padding: 8px 16px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
        }

        .remove-btn:hover {
            background: #c82333;
        }

        .cart-summary {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 18px;
            color: #333;
        }

        .summary-total {
            font-weight: 700;
            font-size: 24px;
            color: #28a745;
            border-top: 2px solid #eee;
            padding-top: 15px;
            margin-top: 15px;
        }

        .checkout-btn {
            width: 100%;
            padding: 15px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 20px;
        }

        .checkout-btn:hover {
            background: #0056b3;
        }

        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .empty-cart h2 {
            color: #666;
            margin-bottom: 20px;
            font-size: 28px;
        }

        .continue-shopping {
            padding: 12px 30px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            font-weight: 600;
        }

        .continue-shopping:hover {
            background: #0056b3;
        }

        /* Loading state */
        .loading {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .cart-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .item-price {
                text-align: left;
            }
        }
    </style>

    <div class="cart-container">
        <div class="cart-header">
            <h1>Shopping Cart</h1>
            <button onclick="clearAllCart()" class="clear-cart-btn">
                Clear Cart
            </button>
        </div>

        <div id="cartContent">
            <div class="loading">Loading cart...</div>
        </div>
    </div>

    <script>
        // Debug: Check if script is running
        console.log('Cart script loaded');

        function loadCart() {
            console.log('loadCart function called');

            // Get cart from localStorage
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            console.log('Cart data:', cart);
            console.log('Cart length:', cart.length);

            const cartContent = document.getElementById('cartContent');

            if (!cartContent) {
                console.error('cartContent element not found!');
                return;
            }

            // If cart is empty
            if (cart.length === 0) {
                console.log('Cart is empty, showing empty state');
                cartContent.innerHTML = `
                    <div class="empty-cart">
                        <h2>🛒 Your cart is empty</h2>
                        <p style="color: #999; margin-bottom: 20px;">Add some products to get started!</p>
                        <a href="{{ route('products.index') }}" class="continue-shopping">Continue Shopping</a>
                    </div>
                `;
                return;
            }

            console.log('Building cart items HTML');

            // Build items HTML
            let itemsHTML = '<div class="cart-items">';

            cart.forEach((item, index) => {
                console.log(`Processing item ${index}:`, item);

                itemsHTML += `
                    <div class="cart-item">
                        <img src="${item.image || ''}" alt="${item.name || 'Product'}" class="item-image">
                        <div class="item-info">
                            <div class="item-name">${item.name || 'Unknown Product'}</div>
                            <div class="item-category">${item.category || 'Uncategorized'}</div>
                        </div>
                        <div class="item-price">$${parseFloat(item.tokens_required || 0).toFixed(2)}</div>
                        <div class="quantity-controls">
                            <button class="quantity-btn" onclick="decreaseQuantity(${item.id})">−</button>
                            <span class="quantity-display">${item.quantity || 1}</span>
                            <button class="quantity-btn" onclick="increaseQuantity(${item.id})">+</button>
                        </div>
                        <div class="item-price">$${(parseFloat(item.tokens_required || 0) * parseInt(item.quantity || 1)).toFixed(2)}</div>
                        <button class="remove-btn" onclick="removeItem(${item.id})">Remove</button>
                    </div>
                `;
            });

            itemsHTML += '</div>';

            // Calculate totals
            const subtotal = cart.reduce((sum, item) => {
                return sum + (parseFloat(item.tokens_required || 0) * parseInt(item.quantity || 1));
            }, 0);

            const tax = subtotal * 0.1; // 10% tax
            const total = subtotal + tax;

            console.log('Subtotal:', subtotal);
            console.log('Tax:', tax);
            console.log('Total:', total);

            // Build summary HTML
            const summaryHTML = `
                <div class="cart-summary">
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span>$${subtotal.toFixed(2)}</span>
                    </div>
                    <div class="summary-row">
                        <span>Tax (10%):</span>
                        <span>$${tax.toFixed(2)}</span>
                    </div>
                    <div class="summary-row summary-total">
                        <span>Total:</span>
                        <span>$${total.toFixed(2)}</span>
                    </div>
                    <form method="POST" action="{{ route('orders.store') }}" id="checkoutForm">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div id="hiddenCartInputs"></div>
                    <button type="submit" class="checkout-btn">
                        Proceed to Checkout
                    </button>
                </form>

                </div>
            `;

            // Update the DOM
            console.log('Updating cartContent innerHTML');
            cartContent.innerHTML = itemsHTML + summaryHTML;
            console.log('Cart loaded successfully');
            setTimeout(() => {
            const hiddenContainer = document.getElementById("hiddenCartInputs");
            hiddenContainer.innerHTML = "";

            cart.forEach((item, index) => {
                hiddenContainer.innerHTML += `
                    <input type="hidden" name="products[${index}][id]" value="${item.id}">
                    <input type="hidden" name="products[${index}][quantity]" value="${item.quantity}">
                    <input type="hidden" name="products[${index}][tokens_required]" value="${item.tokens_required}">
                `;
            });

            hiddenContainer.innerHTML += `
                <input type="hidden" name="total" value="${total}">
            `;
        }, 50);

        }

        function increaseQuantity(productId) {
            console.log('Increasing quantity for product:', productId);
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const product = cart.find(item => item.id === productId);

            if (product) {
                product.quantity = parseInt(product.quantity || 1) + 1;
                localStorage.setItem('cart', JSON.stringify(cart));
                console.log('Updated cart:', cart);
                loadCart();
            }
        }

        function decreaseQuantity(productId) {
            console.log('Decreasing quantity for product:', productId);
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const product = cart.find(item => item.id === productId);

            if (product && parseInt(product.quantity || 1) > 1) {
                product.quantity = parseInt(product.quantity) - 1;
                localStorage.setItem('cart', JSON.stringify(cart));
                console.log('Updated cart:', cart);
                loadCart();
            } else if (product && parseInt(product.quantity) === 1) {
                // If quantity is 1, ask if they want to remove
                removeItem(productId);
            }
        }

        function removeItem(productId) {
            console.log('Removing product:', productId);
            if (confirm('Remove this item from cart?')) {
                let cart = JSON.parse(localStorage.getItem('cart')) || [];
                const originalLength = cart.length;
                cart = cart.filter(item => item.id !== productId);
                console.log(`Removed item. Cart length: ${originalLength} -> ${cart.length}`);
                localStorage.setItem('cart', JSON.stringify(cart));
                loadCart();
            }
        }

        function clearAllCart() {
            console.log('Clearing entire cart');
            if (confirm('Are you sure you want to clear your entire cart?')) {
                localStorage.removeItem('cart');
                console.log('Cart cleared');
                loadCart();
            }
        }

        function checkout() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            console.log('Proceeding to checkout with cart:', cart);

            if (cart.length === 0) {
                alert('Your cart is empty!');
                return;
            }

            // Here you can send cart data to server
            alert(`Proceeding to checkout with ${cart.length} item(s)!\nTotal items: ${cart.reduce((sum, item) => sum + parseInt(item.quantity), 0)}`);

            // Example: Send to server
            // fetch('/checkout', {
            //     method: 'POST',
            //     headers: {
            //         'Content-Type': 'application/json',
            //         'X-CSRF-TOKEN': '{{ csrf_token() }}'
            //     },
            //     body: JSON.stringify({ cart: cart })
            // }).then(response => response.json())
            //   .then(data => {
            //       window.location.href = '/checkout/confirm';
            //   });
        }

        // Load cart when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, calling loadCart');
            loadCart();

        });

        // Also call immediately in case DOM is already loaded
        if (document.readyState === 'loading') {
            console.log('Document still loading, waiting for DOMContentLoaded');
        } else {

        }
    </script>
</x-layout>