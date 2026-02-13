<x-layout>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .products-container {
            display: flex;
            gap: 30px;
            padding: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Sidebar Filters */
        .sidebar {
            width: 280px;
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .manager-link {
            display: block;
            padding: 12px 16px;
            background-color: #1e40af;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid #e5e7eb;
            transition: background-color 0.2s;
        }

        .manager-link:hover {
            background-color: #1e3a8a;
        }

        .manager-link-wrapper {
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid #eee;
        }

        .filter-section {
            margin-bottom: 30px;
        }

        .filter-section h3 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #333;
            font-weight: 600;
        }

        .filter-section label {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            cursor: pointer;
            color: #555;
            font-size: 15px;
        }

        .filter-section input[type="checkbox"] {
            margin-right: 10px;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .price-inputs {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .price-inputs input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .filter-btn {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
        }

        .filter-btn:hover {
            background-color: #0056b3;
        }

        .reset-btn {
            width: 100%;
            padding: 10px;
            background-color: #6c757d;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 10px;
        }

        .reset-btn:hover {
            background-color: #5a6268;
        }

        /* Products Grid */
        .products-grid {
            flex: 1;
        }

        .products-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .products-header h2 {
            font-size: 28px;
            color: #333;
        }

        .products-count {
            color: #666;
            font-size: 16px;
        }

        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }

        /* Product Card */
        .product-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
        }

        .product-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            background-color: #f5f5f5;
        }

        .product-info {
            padding: 20px;
        }

        .product-category {
            font-size: 12px;
            color: #007bff;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .product-name {
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
            font-weight: 600;
            line-height: 1.4;
        }

        .product-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-price {
            font-size: 24px;
            color: #28a745;
            font-weight: 700;
        }

        .add-to-cart-btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .add-to-cart-btn:hover {
            background-color: #0056b3;
        }

        .add-to-cart-btn.added {
            background-color: #28a745;
        }

        .add-to-cart-btn.added:hover {
            background-color: #218838;
        }

        /* Admin Actions */
        .admin-actions {
            display: flex;
            gap: 8px;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #eee;
        }

        .btn-edit {
            flex: 1;
            padding: 8px 12px;
            background-color: #ffc107;
            color: #333;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            display: block;
        }

        .btn-edit:hover {
            background-color: #e0a800;
        }

        .btn-delete {
            flex: 1;
            padding: 8px 12px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        /* Toast Notification */
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #28a745;
            color: white;
            padding: 15px 25px;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            z-index: 1000;
            animation: slideIn 0.3s ease-out;
            display: none;
        }

        .toast.show {
            display: block;
        }

        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Cart Badge */
        .cart-badge {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border-radius: 50px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 999;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background-color 0.3s;
        }

        .cart-badge:hover {
            background-color: #0056b3;
        }

        .cart-count {
            background-color: #dc3545;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 968px) {
            .products-container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                position: relative;
                top: 0;
            }

            .cards-container {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            }
        }
    </style>

    <!-- Toast Notification -->
    <div class="toast" id="toast"></div>

    <div class="products-container">
        <!-- Left Sidebar - Filters -->
        <aside class="sidebar">

            {{-- Manager Orders Link --}}
            @auth
                @if(auth()->user()->role_id === 2)
                    <div class="manager-link-wrapper">
                        <a href="{{ route('orders.index') }}" class="manager-link">
                            🧾 Manage Orders
                        </a>
                    </div>
                @endif
            @endauth

            <form method="GET" action="{{ route('products.index') }}">
                <!-- Category Filter -->
                <div class="filter-section">
                    <h3>Categories</h3>
                    @foreach($categories as $category)
                        <label>
                            <input 
                                type="checkbox" 
                                name="categories[]" 
                                value="{{ $category->id }}"
                                {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}
                            >
                            {{ $category->title }}
                        </label>
                    @endforeach
                </div>

                <!-- Price Filter -->
                <div class="filter-section">
                    <h3>Price Range</h3>
                    <div class="price-inputs">
                        <input 
                            type="number" 
                            name="min_price" 
                            placeholder="Min" 
                            value="{{ request('min_price') }}"
                        >
                        <span>-</span>
                        <input 
                            type="number" 
                            name="max_price" 
                            placeholder="Max" 
                            value="{{ request('max_price') }}"
                        >
                    </div>
                </div>

                <button type="submit" class="filter-btn">Apply Filters</button>
                <a href="{{ route('products.index') }}" class="reset-btn" style="display: block; text-align: center; text-decoration: none;">Reset Filters</a>
            </form>
        </aside>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Right Side - Products Grid -->
        <main class="products-grid">
            <div class="products-header">
                <h2><a href="{{ route('products.index') }}" style="color: #333; text-decoration: none;">All Products</a></h2>
            </div>

            <div class="cards-container">
                @forelse($products as $product)
                    <div class="product-card">
                        <img 
                            src="{{ 'https://pisces.bbystatic.com/image2/BestBuy_US/images/products/48617ba7-1619-42eb-b114-79bcc167ce03.jpg;maxHeight=1920;maxWidth=900?format=webp' }}" 
                            alt="{{ $product->name }}" 
                            class="product-image"
                        >
                        
                        <div class="product-info">
                            <div class="product-category">{{ $product->categorie->title ?? 'Uncategorized' }}</div>
                            <h3 class="product-name">{{ $product->name }}</h3>
                            <p class="product-description">{{ $product->description }}</p>
                            @if($product->premium)
                                <div class="premium-badge">⭐ Premium</div>
                            @endif  
                            <div class="product-footer">
                                <span class="product-price">🪙{{ number_format($product->tokens_required, 2) }}</span>
                               
                                <button 
                                    class="add-to-cart-btn" 
                                    data-id="{{ $product->id }}"
                                    data-name="{{ htmlspecialchars($product->name, ENT_QUOTES) }}"
                                    data-tokens_required="{{ $product->tokens_required }}"
                                    data-image="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/280x250' }}"
                                    data-category="{{ htmlspecialchars($product->categorie->title ?? 'Uncategorized', ENT_QUOTES) }}"
                                    onclick="addToCart(this)"
                                >
                                    @if($product->is_premium)
                                        Premium Only
                                    @else
                                        Add to Cart
                                    @endif
                                </button>
                            </div>

                            @auth
                                @if(auth()->user()->role === 'admin')
                                    <div class="admin-actions">
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn-edit">
                                            Edit
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete" style="width: 100%;">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                @empty
                    <p style="grid-column: 1/-1; text-align: center; padding: 40px; color: #999; font-size: 18px;">
                        No products found matching your criteria.
                    </p>
                @endforelse
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();
        });

        function addToCart(button) {
            const id = parseInt(button.dataset.id);
            const name = button.dataset.name;
            const tokens_required = parseFloat(button.dataset.tokens_required);
            const image = button.dataset.image;
            const category = button.dataset.category;
            
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const existingProductIndex = cart.findIndex(item => item.id === id);
            
            if (existingProductIndex !== -1) {
                cart[existingProductIndex].quantity += 1;
                showToast(`${name} quantity increased to ${cart[existingProductIndex].quantity}`);
            } else {
                const product = {
                    id: id,
                    name: name,
                    tokens_required: tokens_required,
                    image: image,
                    category: category,
                    quantity: 1,
                    addedAt: new Date().toISOString()
                };
                cart.push(product);
                showToast(`${name} added to cart!`);
            }
            
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
            
            button.textContent = '✓ Added';
            button.classList.add('added');
            
            setTimeout(() => {
                button.textContent = 'Add to Cart';
                button.classList.remove('added');
            }, 2000);
        }

        function updateCartCount() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            document.getElementById('cartCount').textContent = totalItems;
        }

        function showToast(message) {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        function viewCart() {
            window.location.href = '/cart';
        }

        function getCart() {
            return JSON.parse(localStorage.getItem('cart')) || [];
        }

        function removeFromCart(productId) {
            let cart = getCart();
            cart = cart.filter(item => item.id !== productId);
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
        }

        function updateQuantity(productId, newQuantity) {
            let cart = getCart();
            const productIndex = cart.findIndex(item => item.id === productId);
            if (productIndex !== -1) {
                if (newQuantity <= 0) {
                    removeFromCart(productId);
                } else {
                    cart[productIndex].quantity = newQuantity;
                    localStorage.setItem('cart', JSON.stringify(cart));
                    updateCartCount();
                }
            }
        }

        function clearCart() {
            localStorage.removeItem('cart');
            updateCartCount();
        }

        function getCartTotal() {
            const cart = getCart();
            return cart.reduce((total, item) => total + (item.price * item.quantity), 0);
        }

        function getCartItemsCount() {
            const cart = getCart();
            return cart.reduce((count, item) => count + item.quantity, 0);
        }
    </script>
</x-layout>