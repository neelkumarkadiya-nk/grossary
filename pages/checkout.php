<?php
// session_start();
// // include "process_register.php";

// $host = "localhost";
// $username = "root"; // Default for XAMPP
// $password = "";     // Default for XAMPP
// $dbname = "checkout";

// $conn = new mysqli($host, $username, $password, $dbname);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // 1. Get User Details from Form
//     $name = mysqli_real_escape_string($conn, $_POST['name']);
//     $email = mysqli_real_escape_string($conn, $_POST['email']);
//     $phone = mysqli_real_escape_string($conn, $_POST['phone']);
//     $address = mysqli_real_escape_string($conn, $_POST['address']);
//     $payment = mysqli_real_escape_string($conn, $_POST['payment']);
//     $total = $_POST['total_amount']; // Pass this from your hidden input or calculate server-side

//     // 2. Insert into 'orders' table
//     $sql_order = "INSERT INTO orders (full_name, email, phone, address, payment_method, total_amount) 
//                   VALUES ('$name', '$email', '$phone', '$address', '$payment', '$total')";

//     if ($conn->query($sql_order) === TRUE) {
//         $order_id = $conn->insert_id; // Get the ID of the order just created

//         // 3. Insert items from Session Cart into 'order_items' table
//         if (!empty($_SESSION['cart'])) {
//             foreach ($_SESSION['cart'] as $item) {
//                 $p_name = $item['name'];
//                 $p_price = $item['price'];
//                 $p_qty = $item['quantity'];

//                 $sql_items = "INSERT INTO order_items (order_id, product_name, price, quantity) 
//                               VALUES ('$order_id', '$p_name', '$p_price', '$p_qty')";
//                 $conn->query($sql_items);
//             }
//         }

//         // 4. Clear Cart after successful order
//         unset($_SESSION['cart']);

//         // Return Success to Javascript
//         echo json_encode(["status" => "success", "order_id" => $order_id]);
//     } else {
//         echo json_encode(["status" => "error", "message" => $conn->error]);
//     }
// }
?>


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
            box-shadow: 0 4px 15px rgba(0,0,0,0.1); 
        }
        .form-group { 
            margin-bottom: 1.5rem;
         }
        .form-group input, .form-group textarea { 
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
            font-size: 1.1rem; }
        .modal { 
            display: none; 
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%; 
            background: rgba(0,0,0,0.7); 
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
        <div class="logo"><h1><a href="index.php">Fresh Grocery</a></h1></div>
        <div class="cont">
            <h3><a href="index.php">Home</a></h3>
            <h3><a href="cart.php">Cart (<span id="cartCount">0</span>)</a></h3>
        </div>
    </nav>

    <main class="checkout-section">
        <h2>Complete Your Order</h2>
        <div class="checkout-container">
            <form id="checkoutForm">
                <div class="form-group">
                    <h3><i class="fas fa-truck"></i> Delivery Details</h3>
                    <input type="text" id="name" placeholder="Full Name" required>
                    <input type="email" id="email" placeholder="Email Address" required>
                    <input type="tel" id="phone" placeholder="Phone Number" required>
                    <textarea id="address" placeholder="Full Delivery Address" required></textarea>
                </div>

                <div class="form-group">
                    <h3><i class="fas fa-credit-card"></i> Payment Method</h3>
                    <input type="radio" name="payment" value="cod" placeholder=" Cash on Delivery" checked> Cash on Delivery
                    <input type="radio" name="payment" value="online" placeholder="Online Payment"> Online Payment
                </div>

                <div class="order-summary">
                    <h3>Order Summary</h3>
                    <div id="orderItems">
                        </div>
                    <div class="total-row">
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