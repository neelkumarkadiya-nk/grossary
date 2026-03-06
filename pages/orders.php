<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION['username'];

$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "gross_db";
$conn = mysqli_connect($host, $db_user, $db_pass, $db_name);

// $orders = [];
if ($conn) {
    $safe_user = mysqli_real_escape_string($conn, $username);
    $res = mysqli_query($conn, "SELECT * FROM orders WHERE username='$safe_user' ORDER BY created_at DESC");
    while ($row = mysqli_fetch_assoc($res)) {
        $items_res = mysqli_query($conn, "SELECT * FROM order_items WHERE order_id='{$row['id']}'");
        // $row['items'] = [];
        while ($item = mysqli_fetch_assoc($items_res)) $row['items'][] = $item;
        $orders[] = $row;
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Orders - Fresh Grocery</title>
    <link rel="stylesheet" href="styles.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <style>
        body {
            background: #f8fdf9;
            font-family: Arial, sans-serif;
        }

        .orders-page {
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .page-title {
            font-size: 1.8rem;
            color: #2c3e50;
            margin-bottom: 1.5rem;
        }

        .order-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .07);
            margin-bottom: 1.5rem;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .order-header {
            background: linear-gradient(90deg, #2ecc71, #27ae60);
            color: white;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: .5rem;
        }

        .order-header h3 {
            font-size: 1rem;
            margin: 0;
        }

        .status-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 3px 12px;
            border-radius: 20px;
            font-size: .8rem;
            font-weight: 700;
        }

        .order-body {
            padding: 1.2rem 1.5rem;
        }

        .order-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: .6rem;
            margin-bottom: 1rem;
            font-size: .88rem;
            color: #718096;
        }

        .order-meta span b {
            color: #2d3748;
            display: block;
        }

        .items-list {
            border-top: 1px solid #e2e8f0;
            padding-top: .8rem;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            padding: .35rem 0;
            font-size: .88rem;
            border-bottom: 1px dashed #eee;
        }

        .item-row:last-child {
            border-bottom: none;
        }

        .order-total {
            text-align: right;
            font-size: 1.05rem;
            font-weight: 700;
            color: #27ae60;
            margin-top: .8rem;
        }

        .no-orders {
            text-align: center;
            padding: 4rem;
            color: #718096;
        }

        .no-orders ion-icon {
            font-size: 4rem;
            display: block;
            margin: 0 auto .8rem;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="logo">
            <h1><a href="index.php">Fresh Grocery</a></h1>
        </div>
        <div class="cont">
            <h3><a href="profile.php">My Profile</a></h3>
            <h3><a href="index.php">Home</a></h3>
            <h3><a href="cart.php">Cart</a></h3>
            <h3><a href="orders.php">Orders</a></h3>
        </div>
        <div class="search-bar">
            <input type="text" placeholder="Search products...">
            <ion-icon name="search-outline" class="icon"></ion-icon>
        </div>
        <div class="cart-icon">
            <a href="cart.php">
                <ion-icon name="cart-outline" class="icon"></ion-icon>
                <span id="cartCount">0</span>
            </a>
        </div>
    </nav>

    <div class="orders-page">
        <h2 class="page-title">📦 My Orders</h2>

        <?php if (empty($orders)): ?>
            <div class="no-orders">
                <ion-icon name="bag-outline"></ion-icon>
                <h3>No orders yet!</h3>
                <p>You haven't placed any orders. Start shopping!</p>
                <a href="index.php" style="display:inline-block;margin-top:1rem;padding:.7rem 1.5rem;background:#2ecc71;color:white;border-radius:8px;text-decoration:none;font-weight:700;">Shop Now</a>
            </div>
        <?php else: ?>
            <?php foreach ($orders as $order): ?>
                <div class="order-card">
                    <div class="order-header">
                        <h3>Order #<?= $order['id'] ?> &nbsp;·&nbsp; <?= date('d M Y, h:i A', strtotime($order['created_at'])) ?></h3>
                        <span class="status-badge"><?= htmlspecialchars($order['status']) ?></span>
                    </div>
                    <div class="order-body">
                        <div class="order-meta">
                            <span><b><?= htmlspecialchars($order['address']) ?>, <?= htmlspecialchars($order['city']) ?></b>Delivery Address</span>
                            <span><b><?= htmlspecialchars($order['payment_method']) ?></b>Payment</span>
                            <span><b><?= htmlspecialchars($order['delivery_slot']) ?></b>Slot</span>
                            <span><b><?= htmlspecialchars($order['phone']) ?></b>Phone</span>
                        </div>
                        <div class="items-list">
                            <?php foreach ($order['items'] as $item): ?>
                                <div class="item-row">
                                    <span><?= htmlspecialchars($item['name']) ?> × <?= $item['quantity'] ?></span>
                                    <span>₹<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="order-total">Total: ₹<?= number_format($order['total_amount'], 2) ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <script>
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const cc = document.getElementById('cartCount');
        if (cc) cc.textContent = cart.reduce((s, i) => s + i.quantity, 0);
    </script>
    <script src="checkout.js"></script>
</body>

</html>