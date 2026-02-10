<x-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { background-color:#f5f5f5; font-family: Arial, sans-serif; }

        .cart-container { max-width: 1200px; margin:40px auto; padding:20px; }
        .cart-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:30px; }
        .cart-header h1 { font-size:32px; color:#333; }
        .clear-cart-btn { padding:10px 20px; background:#dc3545; color:white; border:none; border-radius:4px; cursor:pointer; font-weight:600; }
        .clear-cart-btn:hover { background:#c82333; }

        .cart-items { background:white; border-radius:8px; padding:20px; margin-bottom:20px; box-shadow:0 2px 8px rgba(0,0,0,0.1); }
        .cart-item { display:flex; gap:20px; padding:20px; border-bottom:1px solid #eee; align-items:center; flex-wrap: wrap; }
        .cart-item:last-child { border-bottom:none; }
        .item-image { width:100px; height:100px; object-fit:cover; border-radius:8px; background-color:#f5f5f5; }
        .item-info { flex:1; min-width: 200px; }
        .item-name { font-size:18px; font-weight:600; color:#333; }
        .item-category { color:#666; font-size:14px; text-transform:uppercase; }
        .item-price { font-size:20px; font-weight:700; color:#28a745; min-width:100px; text-align:right; }
        .quantity-controls { display:flex; align-items:center; gap:10px; }
        .quantity-btn { width:35px; height:35px; border:1px solid #ddd; background:white; border-radius:4px; cursor:pointer; font-size:18px; font-weight:600; color:#333; }
        .quantity-btn:hover { background:#f5f5f5; border-color:#007bff; }
        .quantity-display { min-width:40px; text-align:center; font-weight:600; font-size:16px; }
        .remove-btn { padding:8px 16px; background:#dc3545; color:white; border:none; border-radius:4px; cursor:pointer; font-size:14px; font-weight:600; }
        .remove-btn:hover { background:#c82333; }

        .cart-summary { background:white; border-radius:8px; padding:30px; box-shadow:0 2px 8px rgba(0,0,0,0.1); }
        .summary-row { display:flex; justify-content:space-between; margin-bottom:15px; font-size:18px; color:#333; }
        .summary-total { font-weight:700; font-size:24px; color:#28a745; border-top:2px solid #eee; padding-top:15px; margin-top:15px; }
        .checkout-btn { width:100%; padding:15px; background:#007bff; color:white; border:none; border-radius:4px; font-size:18px; font-weight:600; cursor:pointer; margin-top:20px; }
        .checkout-btn:hover { background:#0056b3; }

        .empty-cart { text-align:center; padding:60px 20px; background:white; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1); }
        .empty-cart h2 { color:#666; margin-bottom:20px; font-size:28px; }
        .continue-shopping { padding:12px 30px; background:#007bff; color:white; text-decoration:none; border-radius:4px; font-weight:600; display:inline-block; }
        .continue-shopping:hover { background:#0056b3; }
        .loading { text-align:center; padding:40px; color:#999; }
    </style>

    <div class="cart-container">
        <div class="cart-header">
            <h1>Shopping Cart</h1>
            <button onclick="clearAllCart()" class="clear-cart-btn">Clear Cart</button>
        </div>

        <div id="cartContent">
            <div class="loading">Loading cart...</div>
        </div>
    </div>

    <script>
        function loadCart() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const cartContent = document.getElementById('cartContent');

            if(cart.length === 0){
                cartContent.innerHTML = `
                    <div class="empty-cart">
                        <h2>🛒 Your cart is empty</h2>
                        <p style="color:#999;margin-bottom:20px;">Add some products to get started!</p>
                        <a href="{{ route('products.index') }}" class="continue-shopping">Continue Shopping</a>
                    </div>
                `;
                return;
            }

            let itemsHTML = '<div class="cart-items">';
            cart.forEach(item => {
                itemsHTML += `
                    <div class="cart-item">
                        <img src="${item.image || ''}" alt="${item.name}" class="item-image">
                        <div class="item-info">
                            <div class="item-name">${item.name}</div>
                            <div class="item-category">${item.category || 'Uncategorized'}</div>
                        </div>
                        <div class="item-price">$${parseFloat(item.tokens_required).toFixed(2)}</div>
                        <div class="quantity-controls">
                            <button class="quantity-btn" onclick="decreaseQuantity(${item.id})">−</button>
                            <span class="quantity-display">${item.quantity}</span>
                            <button class="quantity-btn" onclick="increaseQuantity(${item.id})">+</button>
                        </div>
                        <div class="item-price">$${(parseFloat(item.tokens_required) * parseInt(item.quantity)).toFixed(2)}</div>
                        <button class="remove-btn" onclick="removeItem(${item.id})">Remove</button>
                    </div>
                `;
            });
            itemsHTML += '</div>';

            const subtotal = cart.reduce((sum, item) => sum + item.quantity * item.tokens_required, 0);
            const tax = subtotal * 0.1;
            const total = subtotal + tax;

            const summaryHTML = `
                <div class="cart-summary">
                    <div class="summary-row"><span>Subtotal:</span><span>$${subtotal.toFixed(2)}</span></div>
                    <div class="summary-row"><span>Tax (10%):</span><span>$${tax.toFixed(2)}</span></div>
                    <div class="summary-row summary-total"><span>Total:</span><span>$${total.toFixed(2)}</span></div>
                    <button type="button" id="checkoutBtn" class="checkout-btn">Proceed to Checkout</button>
                </div>
            `;

            cartContent.innerHTML = itemsHTML + summaryHTML;
        }

        function increaseQuantity(productId){
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const item = cart.find(p => p.id === productId);
            if(item){ item.quantity += 1; localStorage.setItem('cart', JSON.stringify(cart)); loadCart(); }
        }

        function decreaseQuantity(productId){
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const item = cart.find(p => p.id === productId);
            if(item){
                if(item.quantity > 1){ item.quantity -= 1; }
                else { removeItem(productId); return; }
                localStorage.setItem('cart', JSON.stringify(cart)); loadCart();
            }
        }

        function removeItem(productId){
            if(confirm('Remove this item from cart?')){
                let cart = JSON.parse(localStorage.getItem('cart')) || [];
                cart = cart.filter(p => p.id !== productId);
                localStorage.setItem('cart', JSON.stringify(cart));
                loadCart();
            }
        }

        function clearAllCart(){
            if(confirm('Clear your entire cart?')){
                localStorage.removeItem('cart');
                loadCart();
            }
        }

        // AJAX checkout
        document.addEventListener('click', async function(e){
            if(e.target && e.target.id === 'checkoutBtn'){
                const cart = JSON.parse(localStorage.getItem('cart')) || [];
                if(cart.length === 0){ alert('Cart is empty'); return; }

                const products = cart.map(item => ({
                    id: item.id,
                    quantity: item.quantity,
                    tokens_required: item.tokens_required
                }));
                const total = products.reduce((sum,item)=> sum + item.quantity*item.tokens_required,0);

                try{
                    const response = await fetch("{{ route('orders.store') }}",{
                        method:'POST',
                        headers:{
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({products,total})
                    });
                    const data = await response.json();
                    if(data.success){
                        localStorage.removeItem('cart');
                        alert(data.message || 'Order placed successfully!');
                        window.location.href = "{{ route('products.index') }}";
                    }else{
                        alert(data.message || 'Something went wrong!');
                    }
                }catch(err){
                    console.error(err);
                    alert('Error sending your order');
                }
            }
        });

        document.addEventListener('DOMContentLoaded', loadCart);
    </script>
</x-layout>
