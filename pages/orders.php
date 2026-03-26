<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION['username'];

$host    = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "gross_db";
$conn    = mysqli_connect($host, $db_user, $db_pass, $db_name);

$orders = array();
if ($conn) {
    $safe_user = mysqli_real_escape_string($conn, $username);
    $res = mysqli_query($conn, "SELECT * FROM orders WHERE username='$safe_user' ORDER BY created_at DESC");
    while ($row = mysqli_fetch_assoc($res)) {
        $items_res    = mysqli_query($conn, "SELECT * FROM order_items WHERE order_id='" . $row['id'] . "'");
        $row['items'] = array();
        while ($item = mysqli_fetch_assoc($items_res)) {
            $row['items'][] = $item;
        }
        $orders[] = $row;
    }
    mysqli_close($conn);
}

// Status color map
$statusColors = array(
    'pending'    => array('bg' => '#fff7ed', 'border' => '#fb923c', 'text' => '#c2410c', 'dot' => '#f97316'),
    'confirmed'  => array('bg' => '#eff6ff', 'border' => '#60a5fa', 'text' => '#1d4ed8', 'dot' => '#3b82f6'),
    'processing' => array('bg' => '#fdf4ff', 'border' => '#c084fc', 'text' => '#7e22ce', 'dot' => '#a855f7'),
    'shipped'    => array('bg' => '#f0fdf4', 'border' => '#4ade80', 'text' => '#15803d', 'dot' => '#22c55e'),
    'delivered'  => array('bg' => '#f0fdf4', 'border' => '#2ecc71', 'text' => '#166534', 'dot' => '#16a34a'),
    'cancelled'  => array('bg' => '#fef2f2', 'border' => '#f87171', 'text' => '#b91c1c', 'dot' => '#ef4444'),
);

function getStatusStyle($status, $statusColors) {
    $key = strtolower(trim($status));
    if (isset($statusColors[$key])) {
        return $statusColors[$key];
    }
    return array('bg' => '#f8fafc', 'border' => '#94a3b8', 'text' => '#475569', 'dot' => '#64748b');
}

// Stats computed with foreach (no array_column needed)
$totalOrders = count($orders);
$totalSpent  = 0;
$delivered   = 0;
foreach ($orders as $o) {
    $totalSpent += $o['total_amount'];
    if (strtolower($o['status']) === 'delivered') {
        $delivered++;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - Fresh Grocery</title>
    <link rel="stylesheet" href="checkout.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <style>
        .orders-wrapper {
            max-width: 900px;
            margin: 2.5rem auto;
            padding: 0 1.5rem 4rem;
        }
        .orders-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.2rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: var(--shadow);
        }
        .stat-icon {
            width: 46px; height: 46px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .stat-icon ion-icon { font-size: 1.4rem; }
        .stat-icon.green  { background: #d1fae5; color: #065f46; }
        .stat-icon.orange { background: #ffedd5; color: #9a3412; }
        .stat-icon.blue   { background: #dbeafe; color: #1e40af; }
        .stat-label { font-size: 0.78rem; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .stat-value { font-size: 1.4rem; font-weight: 700; color: var(--text); line-height: 1.2; }

        .order-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            margin-bottom: 1.4rem;
            overflow: hidden;
            box-shadow: var(--shadow);
            animation: slideUp 0.35s ease both;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .order-header {
            background: linear-gradient(90deg, #2ecc71 0%, #27ae60 100%);
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.6rem;
        }
        .order-header-left { display: flex; align-items: center; gap: 0.7rem; }
        .order-header-left ion-icon { color: rgba(255,255,255,0.85); font-size: 1.2rem; }
        .order-number { color: white; font-weight: 700; font-size: 1rem; }
        .order-date   { color: rgba(255,255,255,0.75); font-size: 0.82rem; margin-top: 1px; }

        .status-badge {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.3rem 0.9rem; border-radius: 20px;
            font-size: 0.78rem; font-weight: 700;
            border: 1.5px solid;
        }
        .status-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }

        .order-body { padding: 1.2rem 1.5rem 1.5rem; }
        .order-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 0.8rem 1.2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
            margin-bottom: 1rem;
        }
        .meta-item { display: flex; flex-direction: column; gap: 2px; }
        .meta-label { font-size: 0.72rem; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .meta-value { font-size: 0.9rem; color: var(--text); font-weight: 600; }

        .items-table { width: 100%; border-collapse: collapse; }
        .items-table thead th {
            font-size: 0.72rem; font-weight: 700; color: var(--muted);
            text-transform: uppercase; letter-spacing: 0.5px;
            padding: 0.4rem 0.5rem;
            border-bottom: 1.5px solid var(--border);
            text-align: left;
        }
        .items-table tbody td {
            padding: 0.55rem 0.5rem; font-size: 0.88rem;
            border-bottom: 1px dashed #edf2f7; color: var(--text);
        }
        .items-table tbody tr:last-child td { border-bottom: none; }
        .item-name-cell { display: flex; align-items: center; gap: 0.6rem; }
        .item-img {
            width: 40px; height: 40px; border-radius: 8px;
            object-fit: cover; border: 1px solid var(--border); flex-shrink: 0;
        }
        .item-img-placeholder {
            width: 40px; height: 40px; border-radius: 8px;
            background: #f0fdf4; display: flex; align-items: center;
            justify-content: center; border: 1px solid var(--border); flex-shrink: 0;
        }
        .item-img-placeholder ion-icon { font-size: 1.1rem; color: #2ecc71; }
        .qty-badge {
            background: #f0fdf4; color: #27ae60;
            border-radius: 6px; padding: 0.15rem 0.5rem;
            font-size: 0.82rem; font-weight: 600;
        }
        .line-price { font-weight: 700; color: #27ae60; }

        .order-footer {
            display: flex; justify-content: flex-end; align-items: center;
            gap: 0.5rem; margin-top: 0.9rem; padding-top: 0.8rem;
            border-top: 2px solid var(--border);
        }
        .total-label  { font-size: 0.9rem; color: var(--muted); font-weight: 600; }
        .total-amount { font-size: 1.3rem; font-weight: 800; color: #27ae60; }

        .toggle-items-btn {
            background: none; border: 1.5px solid var(--border);
            border-radius: 8px; padding: 0.35rem 0.9rem;
            font-size: 0.8rem; color: var(--muted); cursor: pointer;
            display: flex; align-items: center; gap: 0.35rem;
            transition: all 0.2s; font-family: 'DM Sans', sans-serif; font-weight: 600;
        }
        .toggle-items-btn:hover { border-color: #2ecc71; color: #27ae60; }
        .items-section { margin-top: 1rem; }
        .items-section.hidden { display: none; }

        .empty-orders {
            text-align: center; padding: 5rem 2rem; background: white;
            border-radius: 16px; border: 1px solid var(--border); box-shadow: var(--shadow);
        }
        .empty-icon-wrap {
            width: 90px; height: 90px;
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            border-radius: 50%; display: flex; align-items: center;
            justify-content: center; margin: 0 auto 1.4rem;
        }
        .empty-icon-wrap ion-icon { font-size: 2.8rem; color: #27ae60; }
        .empty-orders h3 { font-family: 'Playfair Display', serif; font-size: 1.7rem; color: var(--text); margin-bottom: 0.5rem; }
        .empty-orders p  { color: var(--muted); margin-bottom: 1.5rem; }
        .shop-btn {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.8rem 1.8rem;
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            color: white; border-radius: 10px; text-decoration: none;
            font-weight: 700; font-size: 0.95rem;
        }

        @media (max-width: 640px) {
            .orders-stats { grid-template-columns: 1fr 1fr; }
            .orders-stats .stat-card:last-child { grid-column: 1 / -1; }
            .order-header { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="logo">
        <h1><a href="index.php">Fresh Grocery</a></h1>
    </div>
    <div class="cont">
        <a href="index.php">Home</a>
        <a href="profile.php">My Profile</a>
        <a href="cart.php">Cart</a>
        <a href="orders.php" style="text-decoration:underline;">Orders</a>
    </div>
    <div class="search-bar">
        <input type="text" placeholder="Search products...">
        <ion-icon name="search-outline" class="icon"></ion-icon>
    </div>
    <div class="cart-icon" style="position:relative;">
        <a href="cart.php">
            <ion-icon name="cart-outline" class="icon"></ion-icon>
            <span id="cartCount" style="position:absolute;top:-6px;right:-6px;background:#e74c3c;color:white;border-radius:50%;padding:0.15rem 0.45rem;font-size:0.75rem;font-weight:700;">0</span>
        </a>
    </div>
</nav>

<div class="page-header">
    <h1>My Orders</h1>
    <div class="breadcrumb">
        <a href="index.php">Home</a>
        <span>&rsaquo;</span>
        My Orders
    </div>
</div>

<div class="orders-wrapper">

<?php if (empty($orders)): ?>

    <div class="empty-orders">
        <div class="empty-icon-wrap">
            <ion-icon name="bag-outline"></ion-icon>
        </div>
        <h3>No orders yet!</h3>
        <p>You haven't placed any orders. Explore our fresh produce and start shopping!</p>
        <a href="index.php" class="shop-btn">
            <ion-icon name="storefront-outline"></ion-icon> Shop Now
        </a>
    </div>

<?php else: ?>

    <div class="orders-stats">
        <div class="stat-card">
            <div class="stat-icon green"><ion-icon name="receipt-outline"></ion-icon></div>
            <div>
                <div class="stat-label">Total Orders</div>
                <div class="stat-value"><?php echo $totalOrders; ?></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue"><ion-icon name="wallet-outline"></ion-icon></div>
            <div>
                <div class="stat-label">Total Spent</div>
                <div class="stat-value">&#8377;<?php echo number_format($totalSpent, 2); ?></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange"><ion-icon name="checkmark-done-outline"></ion-icon></div>
            <div>
                <div class="stat-label">Delivered</div>
                <div class="stat-value"><?php echo $delivered; ?></div>
            </div>
        </div>
    </div>

    <?php foreach ($orders as $idx => $order):
        $sc    = getStatusStyle($order['status'], $statusColors);
        $delay = $idx * 60;
        $slot  = isset($order['delivery_slot']) ? $order['delivery_slot'] : '-';
        $itemCount = count($order['items']);
    ?>
    <div class="order-card" style="animation-delay:<?php echo $delay; ?>ms;">

        <div class="order-header">
            <div class="order-header-left">
                <ion-icon name="bag-check-outline"></ion-icon>
                <div>
                    <div class="order-number">Order #<?php echo $order['id']; ?></div>
                    <div class="order-date"><?php echo date('d M Y, h:i A', strtotime($order['created_at'])); ?></div>
                </div>
            </div>
            <span class="status-badge" style="background:<?php echo $sc['bg']; ?>;border-color:<?php echo $sc['border']; ?>;color:<?php echo $sc['text']; ?>;">
                <span class="status-dot" style="background:<?php echo $sc['dot']; ?>;"></span>
                <?php echo htmlspecialchars(ucfirst($order['status'])); ?>
            </span>
        </div>

        <div class="order-body">

            <div class="order-meta">
                <div class="meta-item">
                    <span class="meta-label">Address</span>
                    <span class="meta-value"><?php echo htmlspecialchars($order['address']); ?>, <?php echo htmlspecialchars($order['city']); ?></span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Payment</span>
                    <span class="meta-value"><?php echo htmlspecialchars($order['payment_method']); ?></span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Slot</span>
                    <span class="meta-value"><?php echo htmlspecialchars($slot); ?></span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Phone</span>
                    <span class="meta-value"><?php echo htmlspecialchars($order['phone']); ?></span>
                </div>
            </div>

            <button class="toggle-items-btn" onclick="toggleItems(this)" data-open="false">
                <ion-icon name="list-outline"></ion-icon>
                Show <?php echo $itemCount; ?> item<?php echo $itemCount !== 1 ? 's' : ''; ?>
                <ion-icon name="chevron-down-outline"></ion-icon>
            </button>

            <div class="items-section hidden">
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Qty</th>
                            <th style="text-align:right;">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order['items'] as $item): ?>
                        <tr>
                            <td>
                                <div class="item-name-cell">
                                    <?php if (!empty($item['image'])): ?>
                                        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="item-img">
                                    <?php else: ?>
                                        <div class="item-img-placeholder"><ion-icon name="leaf-outline"></ion-icon></div>
                                    <?php endif; ?>
                                    <?php echo htmlspecialchars($item['name']); ?>
                                </div>
                            </td>
                            <td><span class="qty-badge">x <?php echo (int)$item['quantity']; ?></span></td>
                            <td style="text-align:right;" class="line-price">&#8377;<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="order-footer">
                <span class="total-label">Order Total</span>
                <span class="total-amount">&#8377;<?php echo number_format($order['total_amount'], 2); ?></span>
            </div>

        </div>
    </div>
    <?php endforeach; ?>

<?php endif; ?>
</div>

<script>
    var cart = JSON.parse(localStorage.getItem('cart')) || [];
    var cc = document.getElementById('cartCount');
    if (cc) cc.textContent = cart.reduce(function(s, i) { return s + i.quantity; }, 0);

    function toggleItems(btn) {
        var isOpen  = btn.getAttribute('data-open') === 'true';
        var section = btn.nextElementSibling;
        if (isOpen) {
            section.className = 'items-section hidden';
            btn.setAttribute('data-open', 'false');
            btn.innerHTML = btn.innerHTML
                .replace('chevron-up-outline', 'chevron-down-outline')
                .replace('Hide', 'Show');
        } else {
            section.className = 'items-section';
            btn.setAttribute('data-open', 'true');
            btn.innerHTML = btn.innerHTML
                .replace('chevron-down-outline', 'chevron-up-outline')
                .replace('Show', 'Hide');
        }
    }
</script>
</body>
</html>