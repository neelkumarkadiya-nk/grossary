<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Fresh Grocery</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="cart.css">
    <style>
        @keyframes priceFlash {
            0%   { color: inherit; transform: scale(1); }
            30%  { color: #27ae60; transform: scale(1.18); font-weight: 700; }
            100% { color: inherit; transform: scale(1); }
        }
        .price-flash {
            animation: priceFlash 0.45s ease;
        }
        .cart-item {
            transition: opacity 0.25s ease, transform 0.25s ease;
        }
        .cart-item.removing {
            opacity: 0;
            transform: translateX(40px);
        }
        .qty-btn:active {
            transform: scale(0.88);
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="logo">
        <h1><a href="login.php">Fresh Grocery</a></h1>
    </div>
    <div class="cont">
        <h3><a href="index.php">Home</a></h3>
        <h3><a href="index.php">My Profile</a></h3>
        <h3><a href="login.php">Login</a></h3>
        <h3><a href="login.php">Contact Us</a></h3>
    </div>
    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search products...">
        <span class="icon"><ion-icon name="search-outline"></ion-icon></span>
    </div>
</nav>

<!-- PAGE HEADER -->
<div class="page-header">
    <h1>🛒 Shopping Cart</h1>
    <div class="breadcrumb">
        <a href="index.php">Home</a><span>›</span>
        Cart
    </div>
</div>

<!-- MAIN LAYOUT -->
<div class="cart-layout">

    <!-- LEFT: CART ITEMS -->
    <div class="card">
        <div class="card-header">
            <ion-icon name="cart-outline"></ion-icon>
            <h2>Cart Items</h2>
            <span class="item-count" id="itemCountBadge">0 items</span>
        </div>
        <div class="cart-items-list" id="cartContainer">
            <!-- Dynamically loaded -->
        </div>
    </div>

    <!-- RIGHT: ORDER SUMMARY -->
    <div style="position: sticky; top: 90px;">
        <div class="card">
            <div class="card-header">
                <ion-icon name="receipt-outline"></ion-icon>
                <h2>Order Summary</h2>
            </div>
            <div class="summary-body">

                <!-- Promo Code -->
                <div class="promo-row">
                    <input type="text" class="promo-input" placeholder="Promo code..." id="promoCode">
                    <button class="promo-btn" onclick="applyPromo()">Apply</button>
                </div>

                <hr class="divider">

                <!-- Price Breakdown -->
                <div class="price-row">
                    <span>Subtotal (<span id="itemCountText">0</span> items)</span>
                    <span>₹<span id="subtotalAmt">0.00</span></span>
                </div>
                <div class="price-row">
                    <span>Delivery Fee</span>
                    <span id="deliveryFeeText">₹40.00</span>
                </div>
                <div class="price-row" id="discountRow" style="display:none; color:#27ae60;">
                    <span>🎉 Promo Discount</span>
                    <span id="discountAmt">-₹0.00</span>
                </div>

                <div class="savings-badge" id="savingsBadge" style="display:none;">
                    <ion-icon name="pricetag-outline"></ion-icon>
                    <span id="savingsText">You're saving ₹0!</span>
                </div>

                <div class="price-row total-row">
                    <span>Total</span>
                    <span class="amt">₹<span id="totalAmt">0.00</span></span>
                </div>

                <button class="checkout-btn" onclick="goCheckout()">
                    <ion-icon name="checkmark-circle-outline"></ion-icon>
                    Proceed to Checkout
                </button>

                <div class="secure-note">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    100% Secure &amp; Encrypted
                </div>

                <a href="index.php" class="continue-link">
                    <ion-icon name="arrow-back-outline"></ion-icon>
                    Continue Shopping
                </a>

                <!-- Delivery Info -->
                <div class="delivery-info">
                    <div class="delivery-item">
                        <ion-icon name="bicycle-outline"></ion-icon>
                        Free delivery on orders above ₹500
                    </div>
                    <div class="delivery-item">
                        <ion-icon name="time-outline"></ion-icon>
                        Delivery in 30–60 minutes
                    </div>
                    <div class="delivery-item">
                        <ion-icon name="refresh-outline"></ion-icon>
                        Easy returns within 24 hrs
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="checkout.js"></script>
<!-- <script src="scripts.js"></script> -->
<script src="scripts (1).js"></script>

<script>
    let discount = 0;

    function renderCart() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const container = document.getElementById('cartContainer');
        const subtotalEl = document.getElementById('subtotalAmt');
        const totalEl    = document.getElementById('totalAmt');
        const itemCountText  = document.getElementById('itemCountText');
        const itemCountBadge = document.getElementById('itemCountBadge');

        const totalItems = cart.reduce((t, i) => t + i.quantity, 0);
        if (itemCountBadge) itemCountBadge.textContent = totalItems + ' item' + (totalItems !== 1 ? 's' : '');
        if (itemCountText)  itemCountText.textContent  = totalItems;

        if (!container) return;

        if (cart.length === 0) {
            container.innerHTML = `
                <div class="empty-cart">
                    <ion-icon name="cart-outline"></ion-icon>
                    <h3>Your cart is empty</h3>
                    <p>Looks like you haven't added anything yet.</p>
                    <a href="index.php" class="shop-btn">
                        <ion-icon name="storefront-outline"></ion-icon> Shop Now
                    </a>
                </div>`;
            if (subtotalEl) subtotalEl.textContent = '0.00';
            if (totalEl) totalEl.textContent = '0.00';
            updateDelivery(0);
            return;
        }

        let subtotal = 0;
        container.innerHTML = '';

        cart.forEach(item => {
            subtotal += item.price * item.quantity;
            const div = document.createElement('div');
            div.className = 'cart-item';
            div.innerHTML = `
                <div class="item-img-wrap">
                    <img src="${item.image || ''}" alt="${item.name}" onerror="this.style.display='none'">
                </div>
                <div class="item-details">
                    <h3>${item.name}</h3>
                    <div class="item-unit">${item.unit || ''}</div>
                    <div class="item-price-unit">₹${item.price.toFixed(2)} per unit</div>
                </div>
                <div class="item-right">
                    <button class="remove-btn" onclick="removeItem(${item.id})" title="Remove">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    <div class="qty-controls">
                        <button class="qty-btn" onclick="changeQty(${item.id}, ${item.quantity - 1})" ${item.quantity <= 1 ? 'disabled' : ''}>−</button>
                        <span class="qty-num">${item.quantity}</span>
                        <button class="qty-btn" onclick="changeQty(${item.id}, ${item.quantity + 1})">+</button>
                    </div>
                    <div class="item-total price-flash">₹${(item.price * item.quantity).toFixed(2)}</div>
                </div>`;
            container.appendChild(div);
        });

        if (subtotalEl) subtotalEl.textContent = subtotal.toFixed(2);
        updateDelivery(subtotal);
    }

    function updateDelivery(subtotal) {
        const delivery  = subtotal >= 500 ? 0 : 40;
        const total     = subtotal + delivery - discount;
        const totalEl   = document.getElementById('totalAmt');
        const delivText = document.getElementById('deliveryFeeText');
        const savBadge  = document.getElementById('savingsBadge');
        const savText   = document.getElementById('savingsText');

        if (delivText) delivText.textContent = delivery === 0 ? 'FREE 🎉' : '₹40.00';
        if (totalEl)   totalEl.textContent = Math.max(0, total).toFixed(2);

        if (delivery === 0 && subtotal > 0) {
            if (savBadge) savBadge.style.display = 'flex';
            if (savText)  savText.textContent = 'You saved ₹40 on delivery!';
        } else if (discount > 0) {
            if (savBadge) savBadge.style.display = 'flex';
            if (savText)  savText.textContent = `You're saving ₹${discount}!`;
        } else {
            if (savBadge) savBadge.style.display = 'none';
        }
    }

    function changeQty(id, newQty) {
        if (typeof updateQuantity === 'function') {
            updateQuantity(id, newQty);
        } else {
            let cartData = JSON.parse(localStorage.getItem('cart')) || [];
            if (newQty < 1) { removeItem(id); return; }
            const item = cartData.find(i => i.id === id);
            if (item) { item.quantity = newQty; localStorage.setItem('cart', JSON.stringify(cartData)); }
        }
        renderCart();
        flashSummary();
    }

    function removeItem(id) {
        // Animate the row out first, then remove
        const items = document.querySelectorAll('.cart-item');
        items.forEach(el => {
            const btn = el.querySelector(`.remove-btn[onclick*="removeItem(${id})"]`);
            if (btn) el.classList.add('removing');
        });
        setTimeout(() => {
            if (typeof removeFromCart === 'function') {
                removeFromCart(id);
            } else {
                let cartData = JSON.parse(localStorage.getItem('cart')) || [];
                cartData = cartData.filter(i => i.id !== id);
                localStorage.setItem('cart', JSON.stringify(cartData));
            }
            renderCart();
            flashSummary();
        }, 240);
    }

    function flashSummary() {
        const els = ['subtotalAmt', 'totalAmt', 'deliveryFeeText', 'itemCountText', 'itemCountBadge'];
        els.forEach(id => {
            const el = document.getElementById(id);
            if (!el) return;
            el.classList.remove('price-flash');
            void el.offsetWidth; // reflow to restart animation
            el.classList.add('price-flash');
        });
    }

    const PROMO_CODES = { 'FRESH10': 10, 'SAVE20': 20, 'GROCERY50': 50 };

    function applyPromo() {
        const code  = document.getElementById('promoCode').value.trim().toUpperCase();
        const row   = document.getElementById('discountRow');
        const dAmt  = document.getElementById('discountAmt');
        if (PROMO_CODES[code]) {
            discount = PROMO_CODES[code];
            if (row)  row.style.display  = 'flex';
            if (dAmt) dAmt.textContent = '-₹' + discount + '.00';
            const cart     = JSON.parse(localStorage.getItem('cart')) || [];
            const subtotal = cart.reduce((t, i) => t + i.price * i.quantity, 0);
            updateDelivery(subtotal);
            alert('✅ Promo applied! You saved ₹' + discount);
        } else {
            alert('❌ Invalid promo code. Try: FRESH10, SAVE20 or GROCERY50');
        }
    }

    function goCheckout() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        if (cart.length === 0) { alert('Your cart is empty!'); return; }
        window.location.href = 'checkout.php';
    }

    document.addEventListener('DOMContentLoaded', renderCart);
</script>

</body>
</html>