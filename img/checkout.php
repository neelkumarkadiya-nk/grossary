<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Fresh Grocery</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .checkout-section {
            max-width: 900px;
            margin: 2rem auto;
            padding: 20px;
        }

        .checkout-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .order-summary {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            border: 1px solid #eee;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        .total-row {
            font-size: 1.2rem;
            font-weight: bold;
            color: #27ae60;
            text-align: right;
            margin-top: 10px;
        }

        .place-order-btn {
            width: 100%;
            background: #27ae60;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1rem;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            align-items: center;
            justify-content: center;
            z-index: 2000;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    
    <nav class="navbar">
        <div class="logo">
            <h1><a href="index.php">Fresh Grocery</a></h1>
        </div>
        <div class="cont">
            <h3><a href="index.php">Home</a></h3>
            <h3><a href="cart.php">Cart <span id="cartCount">0</span></a></h3>
        </div>
    </nav>

    <main class="checkout-section">
        <h2>Complete Your Order</h2>
        <div class="checkout-container">
            <form id="checkoutForm" method="POST" action="save_order.php">
                <div class="form-group">
                    <h3><i class="fas fa-truck"></i> Delivery Details</h3>
                    <input type="text" id="name" name="customerName" placeholder="Full Name" required>
                    <input type="email" id="email"name="email" placeholder="Email Address" required>
                    <input type="tel" id="phone"name="phone" placeholder="Phone Number" required>
                    <textarea id="address" name="address" placeholder="Full Delivery Address" required></textarea>
                </div>

                <div class="form-group">
                    <h3><i class="fas fa-credit-card"></i> Payment Method</h3>
                    <input type="radio" name="payment" value="cod" checked> Cash on Delivery
                    <input type="radio" name="payment" value="online"> Online Payment
                </div>

                <div class="order-summary">
                    <h3>Order Summary</h3>
                    <div id="orderItems" name="items">
                        <!-- Order items will be dynamically added here -->
                    </div>
                    <div class="total-row" name="total_amount">
                        Total Amount: ₹<span id="orderTotal">0.00</span>
                    </div>
                </div>

                <button type="submit" class="place-order-btn">Place Order Now</button>
            </form>
        </div>
    </main>

    <div id="orderSuccess" class="modal">
        <div class="modal-content">
            <i class="fas fa-check-circle" style="font-size: 3rem; color: #27ae60;"></i>
            <h2>Order Placed Successfully!</h2>
            <p>Order ID: <span id="orderId" style="font-weight: bold;"></span></p>
            <button onclick="window.location.href='index.php'" style="margin-top:20px; padding:10px 20px; background:#27ae60; color:white; border:none; border-radius:5px; cursor:pointer;">Continue Shopping</button>
        </div>
    </div>

    <script src="scripts.js"></script>
    <script src="checkout.js"></script>
</body>

</html>