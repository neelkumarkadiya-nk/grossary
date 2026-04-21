<?php
session_start();

// ── SIMPLE ADMIN GUARD ─────────────────────────────────────────────────────
// Set admin credentials here
define('ADMIN_USER', 'admin');
define('ADMIN_PASS', 'admin123');


if (!isset($_SESSION['admin_loggedin'])) {
    if (isset($_POST['admin_login'])) {
        if ($_POST['admin_username'] === ADMIN_USER && $_POST['admin_password'] === ADMIN_PASS) {
            $_SESSION['admin_loggedin'] = true;
        } else {
            $login_error = "Invalid admin credentials.";
        }
    }
    if (!isset($_SESSION['admin_loggedin'])) {
        // Show login form
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Admin Login – Fresh Grocery</title>
            <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="admin.css">
        </head>
        <body>
        <div class="login-card">
            <div class="brand">
                <div class="shield">🛡️</div>
                <h1>Admin Panel</h1>
                <p>Fresh Grocery Management</p>
            </div>
            <?php if (isset($login_error)) echo '<div class="error">'.$login_error.'</div>'; ?>
            <form method="POST">
                <div class="field">
                    <label>Admin Username</label>
                    <input type="text" name="admin_username" placeholder="Enter username" required autofocus>
                </div>
                <div class="field">
                    <label>Password</label>
                    <input type="password" name="admin_password" placeholder="Enter password" required>
                </div>
                <button type="submit" name="admin_login" class="btn">🔐 Login to Admin</button>
            </form>
        </div>
        </body>
        </html>
        <?php
        exit();
    }
}

// ── LOGOUT ─────────────────────────────────────────────────────────────────
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit();
}

// ── DB CONFIG ──────────────────────────────────────────────────────────────
$host    = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "gross_db";
$conn = mysqli_connect($host, $db_user, $db_pass, $db_name);
if (!$conn) die("DB Error: " . mysqli_connect_error());

// ── UPDATE ORDER STATUS ────────────────────────────────────────────────────
if (isset($_POST['update_status'])) {
    $oid    = intval($_POST['order_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    mysqli_query($conn, "UPDATE orders SET status='$status' WHERE id=$oid");
    header("Location: admin.php?updated=1&tab=" . urlencode(isset($_POST['tab']) ? $_POST['tab'] : ''));
    exit();
}

// ── FILTERS ───────────────────────────────────────────────────────────────
$filter_status = isset($_POST['status']) ? mysqli_real_escape_string($conn, $_POST['status']) : '';
$search        = isset($_POST['search']) ? mysqli_real_escape_string($conn, $_POST['search']) : '';

$where = "WHERE 1=1";
if ($filter_status) $where .= " AND o.status = '$filter_status'";
if ($search)        $where .= " AND (o.full_name LIKE '%$search%' OR o.username LIKE '%$search%' OR o.id LIKE '%$search%' OR o.phone LIKE '%$search%')";

// ── FETCH ORDERS ───────────────────────────────────────────────────────────
$orders_sql = "SELECT o.*, COUNT(oi.id) as item_count
               FROM orders o
               LEFT JOIN order_items oi ON o.id = oi.order_id
               $where
               GROUP BY o.id
               ORDER BY o.created_at DESC";
$orders_res = mysqli_query($conn, $orders_sql);
$orders     = array();
while ($row = mysqli_fetch_assoc($orders_res)) $orders[] = $row;

// ── STATS ──────────────────────────────────────────────────────────────────
$stats = array();
$sr = mysqli_query($conn, "SELECT COUNT(*) as total, SUM(total_amount) as revenue FROM orders");
$s  = mysqli_fetch_assoc($sr);
$stats['total']   = isset($s['total'])   ? $s['total']   : 0;
$stats['revenue'] = isset($s['revenue']) ? $s['revenue'] : 0;

foreach (array('pending','processing','dispatched','delivered','cancelled') as $st) {
    $r    = mysqli_query($conn, "SELECT COUNT(*) as c FROM orders WHERE status='$st'");
    $rrow = mysqli_fetch_assoc($r);
    $stats[$st] = isset($rrow['c']) ? $rrow['c'] : 0;
}

// ── FETCH USERS ────────────────────────────────────────────────────────────
$users_res = mysqli_query($conn, "SELECT u.*, COUNT(o.id) as order_count, SUM(o.total_amount) as total_spent FROM users u LEFT JOIN orders o ON u.username=o.username GROUP BY u.id ORDER BY u.id DESC");
$users = array();
while ($row = mysqli_fetch_assoc($users_res)) $users[] = $row;

mysqli_close($conn);

// ── HELPERS ────────────────────────────────────────────────────────────────
function statusBadge($s) {
    $map = array(
        'pending'    => array('#fff3cd','#856404','Pending'),
        'processing' => array('#cfe2ff','#084298','Processing'),
        'dispatched' => array('#d1ecf1','#0c5460','Dispatched'),
        'delivered'  => array('#d4edda','#155724','Delivered'),
        'cancelled'  => array('#f8d7da','#721c24','Cancelled'),
    );
    $d = isset($map[$s]) ? $map[$s] : array('#e2e8f0','#444', ucfirst($s));
    return "<span style='background:{$d[0]};color:{$d[1]};padding:.25rem .8rem;border-radius:20px;font-size:.75rem;font-weight:700;display:inline-flex;align-items:center;gap:.3rem;'>".$d[2]."</span>";
}
function fmtDate($d) {
    return date('d M Y, h:i A', strtotime($d));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel – Fresh Grocery</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <div style="font-size:1.5rem;margin-bottom:.4rem;">🌿</div>
        <h1>Fresh Grocery</h1>
        <p>Admin Dashboard</p>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Main</div>
        <a href="#" class="nav-item active" onclick="showTab('orders')">
            <ion-icon name="receipt-outline"></ion-icon> Orders
        </a>
        <a href="#" class="nav-item" onclick="showTab('users')">
            <ion-icon name="people-outline"></ion-icon> Users
        </a>
        <div class="nav-label" style="margin-top:.8rem;">Status Filter</div>
        <a href="admin.php?status=pending"    class="nav-item"><ion-icon name="time-outline"></ion-icon> Pending <span style="margin-left:auto;background:rgba(255,200,0,.2);color:#f0c040;border-radius:10px;padding:.1rem .5rem;font-size:.72rem;"><?php echo $stats['pending'] ?></span></a>
        <a href="admin.php?status=processing" class="nav-item"><ion-icon name="settings-outline"></ion-icon> Processing <span style="margin-left:auto;background:rgba(100,150,255,.2);color:#7eb8f7;border-radius:10px;padding:.1rem .5rem;font-size:.72rem;"><?php echo $stats['processing'] ?></span></a>
        <a href="admin.php?status=dispatched" class="nav-item"><ion-icon name="bicycle-outline"></ion-icon> Dispatched <span style="margin-left:auto;background:rgba(100,220,200,.2);color:#5dccba;border-radius:10px;padding:.1rem .5rem;font-size:.72rem;"><?php echo $stats['dispatched'] ?></span></a>
        <a href="admin.php?status=delivered"  class="nav-item"><ion-icon name="checkmark-circle-outline"></ion-icon> Delivered <span style="margin-left:auto;background:rgba(46,204,113,.2);color:var(--green);border-radius:10px;padding:.1rem .5rem;font-size:.72rem;"><?php echo $stats['delivered'] ?></span></a>
        <a href="admin.php?status=cancelled"  class="nav-item"><ion-icon name="close-circle-outline"></ion-icon> Cancelled <span style="margin-left:auto;background:rgba(231,76,60,.2);color:#e77070;border-radius:10px;padding:.1rem .5rem;font-size:.72rem;"><?php echo $stats['cancelled'] ?></span></a>
        <div class="nav-label" style="margin-top:.8rem;">Store</div>
        <a href="index.php" class="nav-item"><ion-icon name="storefront-outline"></ion-icon> View Store</a>
    </nav>
    <div class="sidebar-footer">
        <a href="admin.php?logout=1" class="logout-btn"><ion-icon name="log-out-outline"></ion-icon> Logout Admin</a>
    </div>
</aside>

<!-- MAIN CONTENT -->
<main class="main">
    <!-- TOPBAR -->
    <div class="topbar">
        <h2>📦 Admin Panel</h2>
        <div class="topbar-right">
            <span class="admin-badge">🛡️ Administrator</span>
            <a href="index.php" style="color:var(--muted);text-decoration:none;font-size:.85rem;"><ion-icon name="storefront-outline"></ion-icon> Store</a>
        </div>
    </div>

    <div class="content">

        <?php if (isset($_GET['updated'])): ?>
        <div id="toastBox" class="toast show">✅ Order status updated successfully!</div>
        <script>setTimeout(()=>document.getElementById('toastBox').classList.remove('show'),3000)</script>
        <?php endif; ?>

        <!-- STATS -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background:#d4f5e2;">📦</div>
                <div><div class="stat-val" style="color:#27ae60;"><?php echo $stats['total'] ?></div><div class="stat-lbl">Total Orders</div></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#fff3cd;">⏳</div>
                <div><div class="stat-val" style="color:#856404;"><?php echo $stats['pending'] ?></div><div class="stat-lbl">Pending</div></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#d1ecf1;">🚚</div>
                <div><div class="stat-val" style="color:#0c5460;"><?php echo $stats['dispatched'] ?></div><div class="stat-lbl">Dispatched</div></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#d4edda;">✅</div>
                <div><div class="stat-val" style="color:#155724;"><?php echo $stats['delivered'] ?></div><div class="stat-lbl">Delivered</div></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#e8f5e9;">💰</div>
                <div><div class="stat-val" style="color:#2d6a4f;font-size:1.4rem;">₹<?php echo number_format($stats['revenue'],0) ?></div><div class="stat-lbl">Revenue</div></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#dbeafe;">👥</div>
                <div><div class="stat-val" style="color:#1e40af;"><?php echo count($users) ?></div><div class="stat-lbl">Users</div></div>
            </div>
        </div>

        <!-- TABS -->
        <div class="panel">
            <div class="tabs">
                <a href="#" class="tab active" id="tab-orders" onclick="showTab('orders');return false;">
                    <ion-icon name="receipt-outline"></ion-icon> Orders
                    <span class="tab-count"><?php echo count($orders) ?></span>
                </a>
                <a href="#" class="tab" id="tab-users" onclick="showTab('users');return false;">
                    <ion-icon name="people-outline"></ion-icon> Users
                    <span class="tab-count"><?php echo count($users) ?></span>
                </a>
            </div>

            <!-- ORDERS TAB -->
            <div id="panel-orders">
                <!-- Filter Bar -->
                <form method="GET" class="filters-bar">
                    <input type="text" name="search" value="<?php echo htmlspecialchars($search) ?>" placeholder="🔍 Search by name, order ID, phone...">
                    <?php if ($filter_status): ?>
                        <input type="hidden" name="status" value="<?php echo htmlspecialchars($filter_status) ?>">
                    <?php endif; ?>
                    <button type="submit" class="filter-btn" style="background:var(--green);color:#fff;border-color:var(--green);">Search</button>
                    <?php if ($search || $filter_status): ?>
                        <a href="admin.php" class="filter-btn danger">✕ Clear</a>
                    <?php endif; ?>
                    <span style="margin-left:auto;color:var(--muted);font-size:.82rem;"><?php echo count($orders) ?> result(s)</span>
                </form>

                <!-- Table -->
                <div style="overflow-x:auto;">
                    <?php if (empty($orders)): ?>
                        <div class="empty-state"><span class="ei">📭</span><p>No orders found.</p></div>
                    <?php else: ?>
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>#Order</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($orders as $o): ?>
                            <tr>
                                <td><strong>#<?php echo $o['id'] ?></strong></td>
                                <td>
                                    <div style="font-weight:600;"><?php echo htmlspecialchars($o['full_name']) ?></div>
                                    <div style="color:var(--muted);font-size:.78rem;">@<?php echo htmlspecialchars($o['username']) ?></div>
                                </td>
                                <td><?php echo htmlspecialchars($o['phone']) ?></td>
                                <td><span style="background:var(--green-lt);color:var(--green-dk);border-radius:8px;padding:.2rem .6rem;font-size:.8rem;font-weight:700;"><?php echo $o['item_count'] ?> items</span></td>
                                <td><strong style="color:var(--green-dk);">₹<?php echo number_format($o['total_amount'],2) ?></strong></td>
                                <td><span style="font-size:.8rem;"><?php echo htmlspecialchars($o['payment_method']) ?></span></td>
                                <td>
                                    <form method="POST" style="margin:0;">
                                        <input type="hidden" name="order_id" value="<?php echo $o['id'] ?>">
                                        <select name="status" class="status-select" onchange="this.form.submit()">
                                            <?php foreach (array('pending','processing','dispatched','delivered','cancelled') as $st): ?>
                                                <option value="<?php echo $st; ?>" <?php echo ($o['status']===$st ? 'selected' : ''); ?>><?php echo ucfirst($st); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <input type="hidden" name="update_status" value="1">
                                    </form>
                                </td>
                                <td style="font-size:.78rem;color:var(--muted);"><?php echo isset($o['created_at']) ? fmtDate($o['created_at']) : '—' ?></td>
                                <td>
                                    <div style="display:flex;gap:.4rem;flex-wrap:wrap;">
                                        <a href="admin_order_detail.php?id=<?php echo $o['id'] ?>" class="act-btn view">
                                            <ion-icon name="eye-outline"></ion-icon> View
                                        </a>
                                        <a href="admin_order_detail.php?id=<?php echo $o['id'] ?>&print=1" target="_blank" class="act-btn print">
                                            <ion-icon name="print-outline"></ion-icon> Label
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php endif; ?>
                </div>
            </div>

            <!-- USERS TAB -->
            <div id="panel-users" style="display:none;">
                <div style="overflow-x:auto;">
                    <?php if (empty($users)): ?>
                        <div class="empty-state"><span class="ei">👥</span><p>No users found.</p></div>
                    <?php else: ?>
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Orders</th>
                                <th>Total Spent</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:.7rem;">
                                        <div class="avatar-sm"><?php echo strtoupper(substr($u['username'],0,1)) ?></div>
                                        <div>
                                            <div style="font-weight:600;"><?php echo htmlspecialchars($u['username']) ?></div>
                                            <div style="color:var(--muted);font-size:.75rem;">ID: #<?php echo $u['id'] ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td style="color:var(--muted);"><?php echo htmlspecialchars(isset($u['email']) ? $u['email'] : '&mdash;') ?></td>
                                <td><span style="background:var(--green-lt);color:var(--green-dk);border-radius:8px;padding:.2rem .6rem;font-size:.8rem;font-weight:700;"><?php echo $u['order_count'] ?> orders</span></td>
                                <td><strong style="color:var(--green-dk);">&#8377;<?php echo number_format(isset($u['total_spent']) ? $u['total_spent'] : 0, 2) ?></strong></td>
                                <td>
                                    <a href="admin.php?search=<?php echo urlencode($u['username']) ?>&tab=orders" class="act-btn view" onclick="showTab('orders')">
                                        <ion-icon name="receipt-outline"></ion-icon> Orders
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div><!-- /content -->
</main>

<script>
function showTab(tab) {
    document.getElementById('panel-orders').style.display = tab==='orders' ? 'block' : 'none';
    document.getElementById('panel-users').style.display  = tab==='users'  ? 'block' : 'none';
    document.getElementById('tab-orders').classList.toggle('active', tab==='orders');
    document.getElementById('tab-users').classList.toggle('active', tab==='users');
    // Update sidebar active
    document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
}
// Auto-open tab from URL
const urlTab = new URLSearchParams(window.location.search).get('tab');
if (urlTab) showTab(urlTab);
</script>
</body>
</html>