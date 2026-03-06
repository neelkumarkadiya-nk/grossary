<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}
// $username = $_SESSION['username'] ?? 'Guest';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Fresh Grocery</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="checkout.css">
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="logo">
            <h1><a href="index.php">Fresh Grocery</a></h1>
        </div>
        <div class="cont">
            <h3><a href="profile.php">My Profile</a></h3>
            <h3><a href="index.php">Home</a></h3>
            <h3><a href="index.php#Product">Products</a></h3>
            <h3><a href="cart.php">Cart</a></h3>
            <h3><a href="orders.php">Orders</a></h3>
        </div>
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search products...">
            <ion-icon name="search-outline" class="icon"></ion-icon>
        </div>
        <div class="cart-icon">
            <a href="cart.php">
                <ion-icon name="cart-outline" class="icon"></ion-icon>
                <span id="cartCount">0</span>
            </a>
        </div>
    </nav>

    <!-- PAGE HEADER -->
    <div class="page-header">
        <h1>Secure Checkout</h1>
        <div class="breadcrumb">
            <a href="index.php">Home</a>
            <span>›</span>
            <a href="cart.php">Cart</a>
            <span>›</span>
            Checkout
        </div>
    </div>
    <form id="checkoutForm" action="Process_checkout.php" method="POST">

        <!-- CHECKOUT LAYOUT -->
        <div class="checkout-wrapper">

            <!-- LEFT: FORM -->
            <div>
                <!-- Delivery Details -->
                <div class="checkout-card" style="margin-bottom:1.5rem;">
                    <div class="card-header">
                        <ion-icon name="location-outline"></ion-icon>
                        <h2>Delivery Details</h2>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" id="fullName" placeholder="Your full name" required>
                            </div>
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="tel" id="phone" placeholder="+91 98765 43210" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" id="email" placeholder="you@example.com">
                        </div>
                        <div class="form-group">
                            <label>Street Address</label>
                            <input type="text" id="address" placeholder="House no., Street, Area" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" id="city" placeholder="City" required>
                            </div>
                            <div class="form-group">
                                <label>State</label>
                                <select id="state">
                                    <option value="">Select State</option>
                                    <option>Gujarat</option>
                                    <option>Maharashtra</option>
                                    <option>Delhi</option>
                                    <option>Karnataka</option>
                                    <option>Tamil Nadu</option>
                                    <option>Rajasthan</option>
                                    <option>Uttar Pradesh</option>
                                    <option>West Bengal</option>
                                    <option>Madhya Pradesh</option>
                                    <option>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>PIN Code</label>
                                <input type="text" id="pincode" placeholder="380001" maxlength="6">
                            </div>
                            <div class="form-group">
                                <label>Delivery Slot</label>
                                <select id="slot">
                                    <option value="Morning (7AM–11AM)">Morning (7AM–11AM)</option>
                                    <option value="Afternoon (12PM–4PM)">Afternoon (12PM–4PM)</option>
                                    <option value="Evening (5PM–9PM)">Evening (5PM–9PM)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Delivery Notes (Optional)</label>
                            <textarea id="notes" placeholder="Landmark, gate instructions, etc."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="checkout-card">
                    <div class="card-header">
                        <ion-icon name="card-outline"></ion-icon>
                        <h2>Payment Method</h2>
                    </div>
                    <div class="card-body">
                        <div class="payment-options">
                            <div>
                                <input type="radio" name="payment" id="pay_cod" value="Cash on Delivery" class="payment-option" checked>
                                <label for="pay_cod" class="payment-label">
                                    <ion-icon name="cash-outline"></ion-icon> Cash on Delivery
                                </label>
                            </div>
                            <div>
                                <input type="radio" name="payment" id="pay_upi" value="UPI" class="payment-option">
                                <label for="pay_upi" class="payment-label">
                                    <ion-icon name="phone-portrait-outline"></ion-icon> UPI / QR Code
                                </label>
                            </div>
                            <div>
                                <input type="radio" name="payment" id="pay_card" value="Credit/Debit Card" class="payment-option">
                                <label for="pay_card" class="payment-label">
                                    <ion-icon name="card-outline"></ion-icon> Debit / Credit Card
                                </label>
                            </div>
                            <div>
                                <input type="radio" name="payment" id="pay_nb" value="Net Banking" class="payment-option">
                                <label for="pay_nb" class="payment-label">
                                    <ion-icon name="business-outline"></ion-icon> Net Banking
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: ORDER SUMMARY -->
            <div>
                <div class="checkout-card" style="position:sticky;top:90px;">
                    <div class="card-header">
                        <ion-icon name="receipt-outline"></ion-icon>
                        <h2>Order Summary</h2>
                    </div>
                    <div class="card-body">
                        <div class="order-items" id="orderItems">
                            <div class="empty-cart">
                                <ion-icon name="cart-outline"></ion-icon>
                                <p>Your cart is empty</p>
                            </div>
                        </div>

                        <div class="price-breakdown" id="priceBreakdown" style="display:none;">
                            <div class="price-row">
                                <span>Subtotal</span>
                                <span id="subtotalAmt">₹0.00</span>
                            </div>
                            <div class="price-row">
                                <span>Delivery Fee</span>
                                <span id="deliveryFee">₹40.00</span>
                            </div>
                            <div class="price-row">
                                <span>Discount</span>
                                <span style="color:#27ae60;" id="discountAmt">-₹0.00</span>
                            </div>
                            <div class="price-row total">
                                <span>Total</span>
                                <span class="amount" id="totalAmt">₹0.00</span>
                            </div>
                        </div>

                        <button class="place-order-btn" id="placeOrderBtn" onclick="placeOrder()">
                            <ion-icon name="checkmark-circle-outline"></ion-icon>
                            <a href="orders.php">
                                
                                Place Order
                            </a>
                        </button>
                        <div class="secure-badge">
                            <ion-icon name="lock-closed-outline"></ion-icon>
                            Secured &amp; Encrypted Checkout
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- SUCCESS MODAL -->
        <div class="modal-overlay" id="successModal">
            <div class="modal-box">
                <div class="modal-icon-wrap">
                    <ion-icon name="checkmark-circle"></ion-icon>
                </div>
                <h2>Order Placed! 🎉</h2>
                <p>Your fresh groceries are on their way. We'll send a confirmation to your contact.</p>
                <div class="order-id-badge" id="orderIdBadge">Order #0000</div>
                <br>
                <a href="index.php" class="modal-btn">Continue Shopping</a>
            </div>
        </div>
        
    </form>
    <script src="checkout.js"></script>
    <script src="scripts.js"></script>



</body>

</html>