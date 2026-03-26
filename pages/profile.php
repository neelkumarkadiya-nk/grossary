<?php
// ─── SESSION / AUTH ────────────────────────────────────────────────────────
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// ─── DB CONNECTION ─────────────────────────────────────────────────────────
$host    = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "gross_db";

$conn = mysqli_connect($host, $db_user, $db_pass, $db_name);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$username = $_SESSION['username'];

// ─── FETCH USER ────────────────────────────────────────────────────────────
$safe_user = mysqli_real_escape_string($conn, $username);
$user_res  = mysqli_query($conn, "SELECT * FROM users WHERE username='$safe_user' LIMIT 1");
$user      = $user_res ? mysqli_fetch_assoc($user_res) : null;

if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// ─── FETCH RECENT ORDERS ───────────────────────────────────────────────────
$orders = array();
$res = mysqli_query($conn, "SELECT * FROM orders WHERE username='$safe_user' ORDER BY created_at DESC LIMIT 5");
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $oid   = (int)$row['id'];
        $i_res = mysqli_query($conn, "SELECT * FROM order_items WHERE order_id=$oid");
        $row['items'] = array();
        if ($i_res) {
            while ($item = mysqli_fetch_assoc($i_res)) {
                $row['items'][] = $item;
            }
        }
        $orders[] = $row;
    }
}

// ─── HANDLE PROFILE UPDATE ─────────────────────────────────────────────────
$success_msg = '';
$error_msg   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $new_name    = trim(isset($_POST['name'])    ? $_POST['name']    : '');
    $new_email   = trim(isset($_POST['email'])   ? $_POST['email']   : '');
    $new_phone   = trim(isset($_POST['phone'])   ? $_POST['phone']   : '');
    $new_address = trim(isset($_POST['address']) ? $_POST['address'] : '');
    $new_city    = trim(isset($_POST['city'])    ? $_POST['city']    : '');
    $new_pincode = trim(isset($_POST['pincode']) ? $_POST['pincode'] : '');
    $new_state   = trim(isset($_POST['state'])   ? $_POST['state']   : '');

    if (empty($new_name) || empty($new_email)) {
        $error_msg = 'Name and Email are required.';
    } else {
        $n  = mysqli_real_escape_string($conn, $new_name);
        $e  = mysqli_real_escape_string($conn, $new_email);
        $p  = mysqli_real_escape_string($conn, $new_phone);
        $a  = mysqli_real_escape_string($conn, $new_address);
        $c  = mysqli_real_escape_string($conn, $new_city);
        $pc = mysqli_real_escape_string($conn, $new_pincode);
        $st = mysqli_real_escape_string($conn, $new_state);

        $upd = "UPDATE users SET name='$n', email='$e', phone='$p', address='$a', city='$c', pincode='$pc', state='$st' WHERE username='$safe_user'";
        if (mysqli_query($conn, $upd)) {
            $success_msg = 'Profile updated successfully!';
            $user_res = mysqli_query($conn, "SELECT * FROM users WHERE username='$safe_user' LIMIT 1");
            $user     = mysqli_fetch_assoc($user_res);
        } else {
            $error_msg = 'Update failed: ' . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);

// ─── HELPERS  (all PHP 5 safe — no ?? operator) ────────────────────────────
$name = '';
if (isset($user['name']) && $user['name'] !== '') {
    $name = $user['name'];
} elseif (isset($user['username'])) {
    $name = $user['username'];
} else {
    $name = 'User';
}
$email     = isset($user['email'])     ? $user['email']     : '';
$phone     = isset($user['phone'])     ? $user['phone']     : '';
$address   = isset($user['address'])   ? $user['address']   : '';
$city      = isset($user['city'])      ? $user['city']      : '';
$pincode   = isset($user['pincode'])   ? $user['pincode']   : '';
$state     = (isset($user['state']) && $user['state'] !== '') ? $user['state'] : 'Gujarat';
$user_id   = isset($user['id'])        ? $user['id']        : 'N/A';
$user_type = isset($user['user_type']) ? $user['user_type'] : 'member';
$is_admin  = strtolower($user_type) === 'admin';
$join_date = isset($user['created_at']) ? date('d M Y', strtotime($user['created_at'])) : 'N/A';

// Initials
$initials = strtoupper(substr($name, 0, 1));
$parts = explode(' ', $name);
if (count($parts) >= 2) {
    $initials = strtoupper(substr($parts[0], 0, 1) . substr(end($parts), 0, 1));
}

// Order stats
$order_count = count($orders);
$total_spent = 0;
foreach ($orders as $o) {
    $total_spent += isset($o['total_amount']) ? (float)$o['total_amount'] : 0;
}

// Status colours
$statusColors = array(
    'pending'    => array('bg'=>'#fff7ed','border'=>'#fb923c','text'=>'#c2410c','dot'=>'#f97316'),
    'confirmed'  => array('bg'=>'#eff6ff','border'=>'#60a5fa','text'=>'#1d4ed8','dot'=>'#3b82f6'),
    'processing' => array('bg'=>'#fdf4ff','border'=>'#c084fc','text'=>'#7e22ce','dot'=>'#a855f7'),
    'shipped'    => array('bg'=>'#f0fdf4','border'=>'#4ade80','text'=>'#15803d','dot'=>'#22c55e'),
    'delivered'  => array('bg'=>'#f0fdf4','border'=>'#2ecc71','text'=>'#166534','dot'=>'#16a34a'),
    'cancelled'  => array('bg'=>'#fef2f2','border'=>'#f87171','text'=>'#b91c1c','dot'=>'#ef4444'),
);
function getStatusStyle($status, $sc) {
    $key = strtolower(trim($status));
    return isset($sc[$key]) ? $sc[$key] : array('bg'=>'#f8fafc','border'=>'#94a3b8','text'=>'#475569','dot'=>'#64748b');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Fresh Grocery</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="profile.css">
    <style>
    .order-mini-card {
        border: 1.5px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 1rem;
        transition: box-shadow .2s;
    }
    .order-mini-card:hover { box-shadow: var(--shadow-lg); }
    .order-mini-head {
        background: linear-gradient(90deg,#2d6a4f 0%,#40916c 100%);
        padding: .75rem 1.2rem;
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: .4rem;
    }
    .o-num { color:#fff; font-weight:700; font-size:.95rem; display:flex; align-items:center; gap:.4rem; }
    .o-date { color:rgba(255,255,255,.7); font-size:.78rem; }
    .status-pill {
        display: inline-flex; align-items: center; gap:.35rem;
        padding:.25rem .75rem; border-radius:999px; font-size:.72rem; font-weight:700;
        border: 1.5px solid;
    }
    .status-dot-sm { width:6px; height:6px; border-radius:50%; }
    .order-mini-body { padding:1rem 1.2rem; }
    .order-mini-meta {
        display: grid; grid-template-columns: repeat(2, 1fr);
        gap:.6rem 1rem; margin-bottom:.8rem;
        padding-bottom:.8rem; border-bottom:1px solid var(--border);
        font-size:.83rem;
    }
    .ometa-lbl { color:var(--ink-lt); font-size:.7rem; text-transform:uppercase; letter-spacing:.06em; font-weight:600; }
    .ometa-val { color:var(--ink); font-weight:600; margin-top:2px; }
    .order-items-list { display:flex; flex-direction:column; gap:.4rem; }
    .order-item-row {
        display:flex; align-items:center; justify-content:space-between;
        font-size:.83rem; padding:.4rem .3rem;
        border-bottom:1px dashed var(--border);
    }
    .order-item-row:last-child { border-bottom:none; }
    .order-total-row {
        display:flex; justify-content:flex-end; align-items:center; gap:.5rem;
        margin-top:.8rem; padding-top:.8rem; border-top:1.5px solid var(--border);
    }
    .order-total-lbl { font-size:.82rem; color:var(--ink-lt); font-weight:600; }
    .order-total-amt { font-size:1.1rem; font-weight:700; color:#2d6a4f; }
    .view-all-link {
        display:block; text-align:center; margin-top:1.5rem;
        color:var(--green); font-weight:600; font-size:.9rem; text-decoration:none;
    }
    .view-all-link:hover { text-decoration:underline; }
    .addr-summary {
        background:var(--cream); border-radius:10px;
        padding:.85rem 1rem; margin-top:1rem;
        font-size:.83rem; color:var(--ink-mid); line-height:1.7;
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
        <h3><a href="index.php#Product">Products</a></h3>
        <h3><a href="profile.php">My Profile</a></h3>
        <h3><a href="orders.php">Orders</a></h3>
        <h3><a href="login.php">Logout</a></h3>
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

<div class="profile-shell">

    <!-- SIDEBAR -->
    <aside class="sidebar-card">
        <div class="sidebar-banner"></div>
        <div class="avatar-wrap">
            <div class="avatar"><?php echo htmlspecialchars($initials); ?></div>
        </div>
        <div class="sidebar-body">
            <div class="sidebar-name"><?php echo htmlspecialchars($name); ?></div>

            <span class="badge <?php echo $is_admin ? 'admin' : 'member'; ?>">
                <ion-icon name="<?php echo $is_admin ? 'shield-checkmark-outline' : 'person-outline'; ?>"></ion-icon>
                <?php echo $is_admin ? 'Administrator' : 'Member'; ?>
            </span>

            <div class="sidebar-meta" style="margin-top:1.4rem;">
                <div class="meta-row">
                    <ion-icon name="finger-print-outline"></ion-icon>
                    <span>User ID &nbsp;<strong>#<?php echo htmlspecialchars($user_id); ?></strong></span>
                </div>
                <div class="meta-row">
                    <ion-icon name="person-outline"></ion-icon>
                    <span><?php echo htmlspecialchars($username); ?></span>
                </div>
                <div class="meta-row">
                    <ion-icon name="mail-outline"></ion-icon>
                    <span><?php echo $email ? htmlspecialchars($email) : '<em style="color:var(--ink-lt)">Not set</em>'; ?></span>
                </div>
                <div class="meta-row">
                    <ion-icon name="call-outline"></ion-icon>
                    <span><?php echo $phone ? htmlspecialchars($phone) : '<em style="color:var(--ink-lt)">Not set</em>'; ?></span>
                </div>
                <div class="meta-row">
                    <ion-icon name="calendar-outline"></ion-icon>
                    <span>Joined <?php echo htmlspecialchars($join_date); ?></span>
                </div>
            </div>

            <?php if ($address): ?>
            <div class="addr-summary">
                <ion-icon name="location-outline" style="color:var(--green-mid);vertical-align:middle;margin-right:.3rem;"></ion-icon>
                <?php
                    echo htmlspecialchars($address);
                    if ($city)    echo ', ' . htmlspecialchars($city);
                    if ($pincode) echo ' - ' . htmlspecialchars($pincode);
                    if ($state)   echo ', ' . htmlspecialchars($state);
                ?>
            </div>
            <?php endif; ?>

            <hr class="sidebar-divider">

            <div class="sidebar-stats">
                <div class="stat-box">
                    <div class="stat-val"><?php echo $order_count; ?></div>
                    <div class="stat-lbl">Orders</div>
                </div>
                <div class="stat-box">
                    <div class="stat-val">&#8377;<?php echo number_format($total_spent, 0); ?></div>
                    <div class="stat-lbl">Spent</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- MAIN COLUMN -->
    <div class="main-col">

        <?php if ($success_msg): ?>
            <div class="alert success">
                <ion-icon name="checkmark-circle-outline"></ion-icon>
                <?php echo htmlspecialchars($success_msg); ?>
            </div>
        <?php endif; ?>
        <?php if ($error_msg): ?>
            <div class="alert error">
                <ion-icon name="alert-circle-outline"></ion-icon>
                <?php echo htmlspecialchars($error_msg); ?>
            </div>
        <?php endif; ?>

        <!-- EDIT PROFILE CARD -->
        <div class="card">
            <div class="card-head">
                <ion-icon name="create-outline"></ion-icon>
                <h2>Edit Profile</h2>
                <div class="tab-group">
                    <button class="tab-btn active" onclick="switchTab('personal',this)">Personal</button>
                    <button class="tab-btn"         onclick="switchTab('address', this)">Address</button>
                    <button class="tab-btn"         onclick="switchTab('security',this)">Security</button>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="profile.php">
                    <input type="hidden" name="update_profile" value="1">

                    <!-- PERSONAL TAB -->
                    <div class="section-panel active" id="tab-personal">
                        <div class="form-grid">
                            <div class="field">
                                <label>Full Name</label>
                                <div class="field-icon-wrap">
                                    <ion-icon name="person-outline"></ion-icon>
                                    <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" placeholder="Your full name" required>
                                </div>
                            </div>
                            <div class="field">
                                <label>User ID</label>
                                <input type="text" value="#<?php echo htmlspecialchars($user_id); ?>" disabled style="opacity:.6;cursor:not-allowed;">
                            </div>
                            <div class="field">
                                <label>Username</label>
                                <input type="text" value="<?php echo htmlspecialchars($username); ?>" disabled style="opacity:.6;cursor:not-allowed;">
                            </div>
                            <div class="field">
                                <label>Email Address</label>
                                <div class="field-icon-wrap">
                                    <ion-icon name="mail-outline"></ion-icon>
                                    <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="you@example.com" required>
                                </div>
                            </div>
                            <div class="field">
                                <label>Phone Number</label>
                                <div class="field-icon-wrap">
                                    <ion-icon name="call-outline"></ion-icon>
                                    <input type="tel" name="phone" value="<?php echo htmlspecialchars($phone); ?>" placeholder="+91 XXXXX XXXXX">
                                </div>
                            </div>
                            <div class="field">
                                <label>Account Type</label>
                                <input type="text" value="<?php echo htmlspecialchars(ucfirst($user_type)); ?>" disabled style="opacity:.6;cursor:not-allowed;">
                            </div>
                            <div class="field">
                                <label>Member Since</label>
                                <input type="text" value="<?php echo htmlspecialchars($join_date); ?>" disabled style="opacity:.6;cursor:not-allowed;">
                            </div>
                        </div>
                        <input type="hidden" name="address" value="<?php echo htmlspecialchars($address); ?>">
                        <input type="hidden" name="city"    value="<?php echo htmlspecialchars($city); ?>">
                        <input type="hidden" name="pincode" value="<?php echo htmlspecialchars($pincode); ?>">
                        <input type="hidden" name="state"   value="<?php echo htmlspecialchars($state); ?>">
                    </div>

                    <!-- ADDRESS TAB -->
                    <div class="section-panel" id="tab-address">
                        <div class="form-grid">
                            <div class="field full">
                                <label>Street / House Address</label>
                                <div class="field-icon-wrap">
                                    <ion-icon name="home-outline"></ion-icon>
                                    <input type="text" name="address" value="<?php echo htmlspecialchars($address); ?>" placeholder="Flat / House No., Street, Area">
                                </div>
                            </div>
                            <div class="field">
                                <label>City</label>
                                <div class="field-icon-wrap">
                                    <ion-icon name="business-outline"></ion-icon>
                                    <input type="text" name="city" value="<?php echo htmlspecialchars($city); ?>" placeholder="City">
                                </div>
                            </div>
                            <div class="field">
                                <label>PIN Code</label>
                                <div class="field-icon-wrap">
                                    <ion-icon name="pin-outline"></ion-icon>
                                    <input type="text" name="pincode" value="<?php echo htmlspecialchars($pincode); ?>" placeholder="6-digit PIN" maxlength="6">
                                </div>
                            </div>
                            <div class="field">
                                <label>State</label>
                                <div class="field-icon-wrap">
                                    <ion-icon name="map-outline"></ion-icon>
                                    <input type="text" name="state" value="<?php echo htmlspecialchars($state); ?>" placeholder="State">
                                </div>
                            </div>
                            <div class="field">
                                <label>Country</label>
                                <input type="text" value="India" disabled style="opacity:.6;cursor:not-allowed;">
                            </div>
                        </div>
                        <input type="hidden" name="name"  value="<?php echo htmlspecialchars($name); ?>">
                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                        <input type="hidden" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                    </div>

                    <!-- SECURITY TAB -->
                    <div class="section-panel" id="tab-security">
                        <p style="font-size:.85rem;color:var(--ink-lt);margin-bottom:1rem;">Leave fields blank to keep your current password.</p>
                        <div class="form-grid">
                            <div class="field">
                                <label>Current Password</label>
                                <div class="field-icon-wrap">
                                    <ion-icon name="lock-closed-outline"></ion-icon>
                                    <input type="password" name="current_password" placeholder="Current password">
                                </div>
                            </div>
                            <div class="field">
                                <label>New Password</label>
                                <div class="field-icon-wrap">
                                    <ion-icon name="key-outline"></ion-icon>
                                    <input type="password" name="new_password" placeholder="Min 8 characters" minlength="8">
                                </div>
                            </div>
                            <div class="field full">
                                <label>Confirm New Password</label>
                                <div class="field-icon-wrap">
                                    <ion-icon name="shield-checkmark-outline"></ion-icon>
                                    <input type="password" name="confirm_password" placeholder="Repeat new password">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="name"    value="<?php echo htmlspecialchars($name); ?>">
                        <input type="hidden" name="email"   value="<?php echo htmlspecialchars($email); ?>">
                        <input type="hidden" name="phone"   value="<?php echo htmlspecialchars($phone); ?>">
                        <input type="hidden" name="address" value="<?php echo htmlspecialchars($address); ?>">
                        <input type="hidden" name="city"    value="<?php echo htmlspecialchars($city); ?>">
                        <input type="hidden" name="pincode" value="<?php echo htmlspecialchars($pincode); ?>">
                        <input type="hidden" name="state"   value="<?php echo htmlspecialchars($state); ?>">
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">
                            <ion-icon name="save-outline"></ion-icon> Save Changes
                        </button>
                        <a href="login.php" class="btn-danger" style="text-decoration:none;">
                            <ion-icon name="log-out-outline"></ion-icon> Logout
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- RECENT ORDERS CARD -->
        <div class="card">
            <div class="card-head">
                <ion-icon name="receipt-outline"></ion-icon>
                <h2>Recent Orders</h2>
            </div>
            <div class="card-body">

                <?php if (empty($orders)): ?>
                    <div class="empty-state">
                        <ion-icon name="bag-outline"></ion-icon>
                        <p>No orders yet &mdash; start shopping!</p>
                        <a href="index.php" style="color:var(--green);font-weight:600;font-size:.9rem;margin-top:.5rem;display:inline-block;">
                            Browse Products &rarr;
                        </a>
                    </div>

                <?php else: ?>

                    <?php foreach ($orders as $idx => $order):
                        $sc        = getStatusStyle($order['status'], $statusColors);
                        $itemCount = count($order['items']);
                        $delay     = $idx * 60;
                        $o_phone   = isset($order['phone']) ? $order['phone'] : 'N/A';
                        $o_city    = isset($order['city'])    ? $order['city']    : '';
                        $o_pin     = isset($order['pincode']) ? $order['pincode'] : '';
                    ?>
                    <div class="order-mini-card" style="animation:fadeUp .4s ease <?php echo $delay; ?>ms both;">

                        <div class="order-mini-head">
                            <div>
                                <div class="o-num">
                                    <ion-icon name="bag-check-outline"></ion-icon>
                                    Order #<?php echo htmlspecialchars($order['id']); ?>
                                </div>
                                <div class="o-date"><?php echo date('d M Y, h:i A', strtotime($order['created_at'])); ?></div>
                            </div>
                            <span class="status-pill"
                                  style="background:<?php echo $sc['bg']; ?>;border-color:<?php echo $sc['border']; ?>;color:<?php echo $sc['text']; ?>;">
                                <span class="status-dot-sm" style="background:<?php echo $sc['dot']; ?>;"></span>
                                <?php echo htmlspecialchars(ucfirst($order['status'])); ?>
                            </span>
                        </div>

                        <div class="order-mini-body">
                            <div class="order-mini-meta">
                                <div>
                                    <div class="ometa-lbl">Delivery Address</div>
                                    <div class="ometa-val">
                                        <?php
                                        echo htmlspecialchars($order['address']);
                                        if ($o_city) echo ', ' . htmlspecialchars($o_city);
                                        if ($o_pin)  echo ' - ' . htmlspecialchars($o_pin);
                                        ?>
                                    </div>
                                </div>
                                <div>
                                    <div class="ometa-lbl">Payment</div>
                                    <div class="ometa-val"><?php echo htmlspecialchars($order['payment_method']); ?></div>
                                </div>
                                <div>
                                    <div class="ometa-lbl">Phone</div>
                                    <div class="ometa-val"><?php echo htmlspecialchars($o_phone); ?></div>
                                </div>
                                <div>
                                    <div class="ometa-lbl">Items</div>
                                    <div class="ometa-val"><?php echo $itemCount; ?> item<?php echo $itemCount !== 1 ? 's' : ''; ?></div>
                                </div>
                            </div>

                            <?php if (!empty($order['items'])): ?>
                            <div class="order-items-list">
                                <?php foreach ($order['items'] as $item): ?>
                                <div class="order-item-row">
                                    <span>
                                        <ion-icon name="leaf-outline" style="color:#40916c;margin-right:.35rem;"></ion-icon>
                                        <?php echo htmlspecialchars($item['name']); ?>
                                        <span style="color:var(--ink-lt);font-size:.78rem;">
                                            &times; <?php echo (int)$item['quantity']; ?>
                                        </span>
                                    </span>
                                    <span style="font-weight:700;color:#2d6a4f;">
                                        &#8377;<?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                                    </span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>

                            <div class="order-total-row">
                                <span class="order-total-lbl">Order Total</span>
                                <span class="order-total-amt">&#8377;<?php echo number_format($order['total_amount'], 2); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <a href="orders.php" class="view-all-link">View all orders &rarr;</a>

                <?php endif; ?>

            </div>
        </div>

    </div><!-- /.main-col -->
</div><!-- /.profile-shell -->

<script>
(function(){
    var cart = JSON.parse(localStorage.getItem('cart')) || [];
    var cc = document.getElementById('cartCount');
    if (cc) cc.textContent = cart.reduce(function(s, i){ return s + (i.quantity || 1); }, 0);
})();

function switchTab(name, btn) {
    var panels = document.querySelectorAll('.section-panel');
    for (var i = 0; i < panels.length; i++) {
        panels[i].classList.remove('active');
    }
    var tabs = document.querySelectorAll('.tab-btn');
    for (var j = 0; j < tabs.length; j++) {
        tabs[j].classList.remove('active');
    }
    document.getElementById('tab-' + name).classList.add('active');
    btn.classList.add('active');
}
</script>

</body>
</html>