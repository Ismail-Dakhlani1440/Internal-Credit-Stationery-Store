<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>App</title>

<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
*{margin:0;padding:0;box-sizing:border-box}

body{font-family:Arial;background:#f5f5f5}

header{
    background:#fff;
    padding:15px 30px;
    box-shadow:0 2px 5px rgba(0,0,0,0.1);
    display:flex;
    align-items:center;
    justify-content:space-between;
}

.logo{
    font-size:22px;
    font-weight:bold;
    color:#007bff;
}

/* Right area */
.nav-right{
    display:flex;
    align-items:center;
    gap:25px;
}

/* Cart */
.cart-box{
    position:relative;
    cursor:pointer;
}

.cart-box span{
    position:absolute;
    top:-6px;
    right:-10px;
    background:red;
    color:white;
    font-size:12px;
    padding:2px 6px;
    border-radius:50%;
}

/* Profile */
.user-profile{
    display:flex;
    align-items:center;
    gap:10px;
    cursor:pointer;
    position:relative;
}

.profile-image{
    width:40px;
    height:40px;
    border-radius:50%;
    object-fit:cover;
    border:2px solid #ddd;
}

.user-name{font-weight:600;color:#333}

/* Dropdown */
.dropdown{
    position:absolute;
    top:50px;
    right:0;
    background:white;
    border-radius:6px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    width:160px;
    display:none;
    overflow:hidden;
}

.dropdown a{
    display:block;
    padding:12px 15px;
    text-decoration:none;
    color:#333;
    font-size:14px;
}

.dropdown a:hover{
    background:#f1f1f1;
}
</style>
</head>

<body>

<header>
    <div class="logo">Store</div>

    <div class="nav-right">

        <!-- CART -->
         <a href="{{ route('orders.show' , 2) }}" class="nav-link" style="text-decoration: none; color :black">
        📦 My Orders
         </a>
         <div class="tokens-box">
          🪙 <span id="user-tokens">{{ auth()->user()->tokens }}</span>
         </div>
        <div class="cart-box" onclick="window.location='/cart'">
            🛒
            <span id="cart-count">0</span>
        </div>

        <!-- PROFILE -->
        <div class="user-profile" onclick="toggleDropdown()">
            <img src="{{ auth()->user()->image ?? 'https://images.icon-icons.com/1622/PNG/512/3741756-bussiness-ecommerce-marketplace-onlinestore-store-user_108907.png' }}" class="profile-image">
            <span class="user-name">{{ auth()->user()->name }}</span>

            <div class="dropdown" id="dropdown">
                <a href="{{ route('profile.edit') }}">My profile</a>
                <a href="#" onclick="logout()">Logout</a>
            </div>
        </div>

    </div>
</header>

<main>
    {{ $slot }}
</main>

<script>
function toggleDropdown(){
    const d = document.getElementById('dropdown');
    d.style.display = d.style.display === 'block' ? 'none' : 'block';
}

function logout(){
    fetch("{{ route('logout') }}",{
        method:'POST',
        headers:{
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    }).then(()=>{
        window.location = "/login";
    });
}

/* CART COUNT */
function updateCartCount(){
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let count = cart.reduce((sum,item)=> sum + (parseInt(item.quantity) || 1), 0);
    document.getElementById('cart-count').innerText = count;
}

updateCartCount();
</script>

</body>
</html>
