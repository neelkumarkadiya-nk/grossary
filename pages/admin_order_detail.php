<?php
session_start();

// Admin guard
if (!isset($_SESSION['admin_loggedin'])) {
    header("Location: admin.php");
    exit();
}

// DB
$host    = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "gross_db";
$conn = mysqli_connect($host, $db_user, $db_pass, $db_name);
if (!$conn) die("DB Error: " . mysqli_connect_error());

// Get order ID
$order_id = intval($_POST['id'] ?? 0);
if (!$order_id) { header("Location: admin.php"); exit(); }

// Update status if submitted
if (isset($_POST['update_status'])) {
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);
    $note       = mysqli_real_escape_string($conn, $_POST['admin_note'] ?? '');
    mysqli_query($conn, "UPDATE orders SET status='$new_status', admin_note='$note' WHERE id=$order_id");
    header("Location: admin_order_detail.php?id=$order_id&updated=1" . (isset($_POST['print']) ? '&print=1' : ''));
    exit();
}

// Fetch order
$res   = mysqli_query($conn, "SELECT * FROM orders WHERE id=$order_id");
$order = mysqli_fetch_assoc($res);
if (!$order) { echo "Order not found."; exit(); }

// Fetch items
$ires  = mysqli_query($conn, "SELECT * FROM order_items WHERE order_id=$order_id");
$items = [];
while ($row = mysqli_fetch_assoc($ires)) $items[] = $row;

// Fetch user info
$uname = mysqli_real_escape_string($conn, $order['username']);
$ures  = mysqli_query($conn, "SELECT * FROM users WHERE username='$uname' LIMIT 1");
$user  = mysqli_fetch_assoc($ures) ?: [];

// Fetch user order history count
$ucnt  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c, SUM(total_amount) as t FROM orders WHERE username='$uname'"));

mysqli_close($conn);

// Helpers
$print_mode = isset($_POST['print']) && $_POST['print'] == 1;

function statusColor($s) {
    $map = [
        'pending'    => ['#fff3cd','#856404'],
        'processing' => ['#cfe2ff','#084298'],
        'dispatched' => ['#d1ecf1','#0c5460'],
        'delivered'  => ['#d4edda','#155724'],
        'cancelled'  => ['#f8d7da','#721c24'],
    ];
    return $map[$s] ?? ['#e2e8f0','#444'];
}
function fmtDate($d) {
    return $d ? date('d M Y, h:i A', strtotime($d)) : '—';
}
$sc = statusColor($order['status']);
$subtotal = array_sum(array_map(fn($i)=>$i['price']*$i['quantity'], $items));
$delivery = $order['total_amount'] - $subtotal;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #<?= $order_id ?> – Admin Detail</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <style>
        :root {
            --green:#2ecc71; --green-dk:#27ae60; --green-lt:#d4f5e2;
            --navy:#1a2e1f; --white:#fff; --light:#f4fdf7;
            --text:#1a2e22; --muted:#6b7a72; --border:#e2ece5;
            --shadow:0 4px 20px rgba(46,204,113,.10);
        }
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'DM Sans',sans-serif;background:var(--light);color:var(--text);}

        /* ── TOPBAR ── */
        .topbar{
            background:linear-gradient(90deg,var(--navy),#2d4a35);
            padding:1rem 2rem; display:flex; align-items:center; gap:1rem;
            position:sticky;top:0;z-index:100;
        }
        .topbar a{color:rgba(255,255,255,.7);text-decoration:none;font-size:.9rem;display:flex;align-items:center;gap:.4rem;transition:.2s;}
        .topbar a:hover{color:#fff;}
        .topbar h1{color:#fff;font-family:'Playfair Display',serif;font-size:1.3rem;flex:1;text-align:center;}
        .topbar-btns{display:flex;gap:.6rem;}
        .tbtn{padding:.5rem 1.1rem;border-radius:8px;border:none;font-family:'DM Sans',sans-serif;font-size:.85rem;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:.4rem;transition:.2s;}
        .tbtn.print-btn{background:var(--green);color:#fff;}
        .tbtn.print-btn:hover{background:var(--green-dk);}
        .tbtn.back-btn{background:rgba(255,255,255,.12);color:#fff;}
        .tbtn.back-btn:hover{background:rgba(255,255,255,.22);}

        /* ── LAYOUT ── */
        .page{max-width:1100px;margin:2rem auto;padding:0 1.5rem 3rem;display:grid;grid-template-columns:1fr 340px;gap:1.8rem;align-items:start;}
        .left-col{display:flex;flex-direction:column;gap:1.5rem;}
        .right-col{display:flex;flex-direction:column;gap:1.5rem;position:sticky;top:80px;}

        /* ── CARD ── */
        .card{background:#fff;border-radius:16px;border:1px solid var(--border);box-shadow:var(--shadow);overflow:hidden;}
        .card-head{padding:1.1rem 1.5rem;display:flex;align-items:center;gap:.65rem;border-bottom:1px solid var(--border);}
        .card-head ion-icon{font-size:1.2rem;color:var(--green-dk);}
        .card-head h2{font-size:1rem;font-weight:700;color:var(--text);}
        .card-head .hbadge{margin-left:auto;}
        .card-body{padding:1.5rem;}

        /* ── ORDER HERO ── */
        .order-hero{
            background:linear-gradient(135deg,var(--navy) 0%,#2d4a35 100%);
            border-radius:16px; padding:1.8rem; color:#fff;
            box-shadow:var(--shadow);
        }
        .order-hero-top{display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1rem;}
        .order-no{font-family:'Playfair Display',serif;font-size:2rem;font-weight:700;}
        .order-date{color:rgba(255,255,255,.6);font-size:.82rem;margin-top:.2rem;}
        .status-pill{
            padding:.45rem 1.1rem;border-radius:20px;font-size:.82rem;font-weight:700;
            background:<?= $sc[0] ?>;color:<?= $sc[1] ?>;display:inline-block;
        }
        .order-hero-meta{display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-top:1.5rem;}
        .hm-item{background:rgba(255,255,255,.08);border-radius:10px;padding:.9rem 1rem;}
        .hm-lbl{font-size:.7rem;color:rgba(255,255,255,.55);text-transform:uppercase;letter-spacing:.06em;font-weight:600;}
        .hm-val{font-size:1.1rem;font-weight:700;color:#fff;margin-top:.2rem;}

        /* ── INFO GRID ── */
        .info-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem 1.5rem;}
        .info-item{}
        .info-lbl{font-size:.72rem;color:var(--muted);font-weight:700;text-transform:uppercase;letter-spacing:.07em;margin-bottom:.25rem;}
        .info-val{font-size:.92rem;color:var(--text);font-weight:600;line-height:1.4;}
        .address-block{
            background:var(--light);border:1px solid var(--border);border-radius:10px;
            padding:.9rem 1.1rem;font-size:.88rem;line-height:1.8;color:var(--text);margin-top:.5rem;
        }

        /* ── ITEMS TABLE ── */
        .items-tbl{width:100%;border-collapse:collapse;}
        .items-tbl thead th{font-size:.72rem;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;padding:.75rem .8rem;border-bottom:2px solid var(--border);text-align:left;}
        .items-tbl tbody td{padding:.75rem .8rem;border-bottom:1px dashed var(--border);font-size:.88rem;}
        .items-tbl tbody tr:last-child td{border-bottom:none;}
        .item-name-cell{display:flex;align-items:center;gap:.6rem;}
        .item-dot{width:10px;height:10px;border-radius:50%;background:var(--green);flex-shrink:0;}
        .item-price-col{font-weight:700;color:var(--green-dk);}

        /* ── TOTALS ── */
        .totals-box{border-top:2px solid var(--border);margin-top:1rem;padding-top:1rem;}
        .tot-row{display:flex;justify-content:space-between;font-size:.9rem;color:var(--muted);padding:.3rem 0;}
        .tot-row.grand{font-size:1.1rem;font-weight:700;color:var(--text);border-top:1.5px solid var(--border);padding-top:.7rem;margin-top:.5rem;}
        .tot-row.grand .amt{color:var(--green-dk);font-size:1.3rem;}

        /* ── USER CARD ── */
        .user-avatar{width:56px;height:56px;border-radius:50%;background:var(--green-lt);color:var(--green-dk);display:flex;align-items:center;justify-content:center;font-size:1.5rem;font-weight:700;margin-bottom:.8rem;}
        .ustat-grid{display:grid;grid-template-columns:1fr 1fr;gap:.6rem;margin-top:1rem;}
        .ustat{background:var(--light);border-radius:8px;padding:.7rem;text-align:center;}
        .ustat-val{font-weight:700;color:var(--green-dk);font-size:1.1rem;}
        .ustat-lbl{font-size:.7rem;color:var(--muted);margin-top:.1rem;}

        /* ── STATUS UPDATE FORM ── */
        .status-form{}
        .status-select-lg{
            width:100%;padding:.75rem 1rem;border:1.5px solid var(--border);border-radius:9px;
            font-size:.95rem;font-family:'DM Sans',sans-serif;outline:none;background:#fafafa;
            transition:.2s;margin-bottom:.8rem;cursor:pointer;
        }
        .status-select-lg:focus{border-color:var(--green);}
        .note-textarea{
            width:100%;padding:.7rem 1rem;border:1.5px solid var(--border);border-radius:9px;
            font-family:'DM Sans',sans-serif;font-size:.88rem;resize:none;height:80px;outline:none;
            background:#fafafa;transition:.2s;margin-bottom:.8rem;
        }
        .note-textarea:focus{border-color:var(--green);}
        .update-btn{
            width:100%;padding:.85rem;background:linear-gradient(135deg,var(--green),var(--green-dk));
            color:#fff;border:none;border-radius:10px;font-size:.95rem;font-weight:700;
            font-family:'DM Sans',sans-serif;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.4rem;
            transition:.2s;box-shadow:0 4px 14px rgba(46,204,113,.35);
        }
        .update-btn:hover{transform:translateY(-1px);box-shadow:0 7px 20px rgba(46,204,113,.45);}

        /* ── TIMELINE ── */
        .timeline{padding:0 1.5rem 1.5rem;}
        .tl-item{display:flex;gap:.8rem;padding:.6rem 0;position:relative;}
        .tl-item:not(:last-child)::after{content:'';position:absolute;left:10px;top:28px;width:2px;height:calc(100% - 10px);background:var(--border);}
        .tl-dot{width:22px;height:22px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.75rem;flex-shrink:0;margin-top:2px;}
        .tl-dot.done{background:var(--green-lt);color:var(--green-dk);}
        .tl-dot.curr{background:var(--green);color:#fff;}
        .tl-dot.todo{background:#f0f0f0;color:#aaa;}
        .tl-info{}
        .tl-label{font-weight:600;font-size:.85rem;}
        .tl-sub{font-size:.75rem;color:var(--muted);}

        /* ── TOAST ── */
        .toast{position:fixed;bottom:2rem;right:2rem;background:#2d6a4f;color:#fff;padding:.8rem 1.5rem;border-radius:10px;font-size:.9rem;font-weight:600;box-shadow:0 6px 24px rgba(0,0,0,.2);z-index:9999;transform:translateY(80px);opacity:0;transition:.3s;}
        .toast.show{transform:translateY(0);opacity:1;}

        /* ── PRINT STYLES ── */
        @media print {
            body{background:#fff;}
            .topbar,.status-form-card,.user-card,.no-print{display:none!important;}
            .page{grid-template-columns:1fr;max-width:100%;padding:0;margin:0;}
            .right-col{display:none;}
            .card,.order-hero{box-shadow:none;border:1px solid #ccc;}
            .print-label{display:block!important;}
        }

        /* ── PRINT LABEL ── */
        .print-label{
            display:none;
            border:2px dashed #2ecc71;border-radius:14px;padding:1.5rem;margin-top:1.5rem;
            background:#fff;font-family:'DM Sans',sans-serif;
        }
        .label-header{display:flex;justify-content:space-between;align-items:center;border-bottom:2px solid #2ecc71;padding-bottom:1rem;margin-bottom:1rem;}
        .label-brand{font-family:'Playfair Display',serif;font-size:1.4rem;color:#27ae60;font-weight:700;}
        .label-type{background:#27ae60;color:#fff;padding:.3rem .9rem;border-radius:20px;font-size:.8rem;font-weight:700;}
        .label-grid{display:grid;grid-template-columns:1fr 1fr;gap:.8rem 1.5rem;margin-bottom:1rem;}
        .label-field label{font-size:.68rem;color:#888;text-transform:uppercase;letter-spacing:.06em;font-weight:700;display:block;margin-bottom:.2rem;}
        .label-field span{font-size:.92rem;color:#1a2e22;font-weight:600;}
        .label-items table{width:100%;border-collapse:collapse;font-size:.82rem;}
        .label-items th{background:#f4fdf7;padding:.4rem .6rem;text-align:left;font-size:.7rem;color:#888;text-transform:uppercase;border:1px solid #e2ece5;}
        .label-items td{padding:.4rem .6rem;border:1px solid #e2ece5;}
        .label-footer{display:flex;justify-content:space-between;align-items:center;border-top:1px dashed #2ecc71;padding-top:.8rem;margin-top:.8rem;}
        .label-total{font-size:1.1rem;font-weight:700;color:#27ae60;}
        .label-barcode{font-family:monospace;font-size:.7rem;letter-spacing:.15em;color:#888;}
        .label-qr{font-size:.65rem;color:#aaa;text-align:right;}
        .label-stamp{
            display:inline-block;border:2px solid;border-radius:8px;
            padding:.3rem .8rem;font-weight:700;font-size:.85rem;transform:rotate(-5deg);
            margin-top:.5rem;
        }

        @media(max-width:800px){
            .page{grid-template-columns:1fr;}
            .right-col{position:static;}
            .order-hero-meta{grid-template-columns:1fr 1fr;}
            .info-grid{grid-template-columns:1fr;}
        }
    </style>
</head>
<body>

<!-- TOPBAR -->
<div class="topbar">
    <a href="admin.php" class="tbtn back-btn">
        <ion-icon name="arrow-back-outline"></ion-icon> Back
    </a>
    <h1>Order #<?= $order_id ?> Details</h1>
    <div class="topbar-btns">
        <button class="tbtn print-btn" onclick="printLabel()">
            <ion-icon name="print-outline"></ion-icon> Print Label
        </button>
    </div>
</div>

<?php if (isset($_POST['updated'])): ?>
<div id="toast" class="toast show">✅ Order status updated!</div>
<script>setTimeout(()=>document.getElementById('toast').classList.remove('show'),3000)</script>
<?php endif; ?>

<div class="page">
    <!-- LEFT COL -->
    <div class="left-col">

        <!-- ORDER HERO -->
        <div class="order-hero">
            <div class="order-hero-top">
                <div>
                    <div class="order-no">Order #<?= $order_id ?></div>
                    <div class="order-date"><?= fmtDate($order['created_at']) ?></div>
                </div>
                <div>
                    <div class="status-pill"><?= ucfirst($order['status']) ?></div>
                </div>
            </div>
            <div class="order-hero-meta">
                <div class="hm-item">
                    <div class="hm-lbl">Total Amount</div>
                    <div class="hm-val">₹<?= number_format($order['total_amount'],2) ?></div>
                </div>
                <div class="hm-item">
                    <div class="hm-lbl">Payment</div>
                    <div class="hm-val" style="font-size:.88rem;"><?= htmlspecialchars($order['payment_method']) ?></div>
                </div>
                <div class="hm-item">
                    <div class="hm-lbl">Items</div>
                    <div class="hm-val"><?= count($items) ?></div>
                </div>
            </div>
        </div>

        <!-- CUSTOMER DETAILS -->
        <div class="card">
            <div class="card-head">
                <ion-icon name="person-outline"></ion-icon>
                <h2>Customer & Delivery Info</h2>
            </div>
            <div class="card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-lbl">Full Name</div>
                        <div class="info-val"><?= htmlspecialchars($order['full_name']) ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-lbl">Username</div>
                        <div class="info-val">@<?= htmlspecialchars($order['username']) ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-lbl">Phone</div>
                        <div class="info-val"><a href="tel:<?= htmlspecialchars($order['phone']) ?>" style="color:var(--green-dk);text-decoration:none;">📞 <?= htmlspecialchars($order['phone']) ?></a></div>
                    </div>
                    <div class="info-item">
                        <div class="info-lbl">Email</div>
                        <div class="info-val"><?= htmlspecialchars($order['email'] ?: '—') ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-lbl">City</div>
                        <div class="info-val"><?= htmlspecialchars($order['city']) ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-lbl">State & PIN</div>
                        <div class="info-val"><?= htmlspecialchars($order['state']) ?> – <?= htmlspecialchars($order['pincode']) ?></div>
                    </div>
                </div>
                <div class="info-lbl" style="margin-top:1rem;">Delivery Address</div>
                <div class="address-block">
                    📍 <?= htmlspecialchars($order['address']) ?>, <?= htmlspecialchars($order['city']) ?>,
                    <?= htmlspecialchars($order['state']) ?> – <?= htmlspecialchars($order['pincode']) ?>
                    <?php if (!empty($order['notes'])): ?>
                        <br><em style="color:var(--muted);">Note: <?= htmlspecialchars($order['notes']) ?></em>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- ORDER ITEMS -->
        <div class="card">
            <div class="card-head">
                <ion-icon name="cart-outline"></ion-icon>
                <h2>Ordered Items</h2>
                <span class="hbadge" style="background:var(--green-lt);color:var(--green-dk);border-radius:10px;padding:.2rem .7rem;font-size:.78rem;font-weight:700;"><?= count($items) ?> items</span>
            </div>
            <div class="card-body" style="padding:1rem;">
                <table class="items-tbl">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td>
                                <div class="item-name-cell">
                                    <div class="item-dot"></div>
                                    <span style="font-weight:600;"><?= htmlspecialchars($item['name']) ?></span>
                                </div>
                            </td>
                            <td>₹<?= number_format($item['price'],2) ?></td>
                            <td><span style="background:var(--green-lt);color:var(--green-dk);border-radius:6px;padding:.15rem .5rem;font-size:.8rem;font-weight:700;">x<?= $item['quantity'] ?></span></td>
                            <td class="item-price-col">₹<?= number_format($item['price']*$item['quantity'],2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="totals-box">
                    <div class="tot-row"><span>Subtotal</span><span>₹<?= number_format($subtotal,2) ?></span></div>
                    <div class="tot-row"><span>Delivery Fee</span><span>₹<?= number_format(max(0,$delivery),2) ?></span></div>
                    <div class="tot-row grand"><span>Total</span><span class="amt">₹<?= number_format($order['total_amount'],2) ?></span></div>
                </div>
            </div>
        </div>

        <!-- PRINT LABEL (hidden until print) -->
        <div class="print-label" id="printLabel">
            <div class="label-header">
                <div>
                    <div class="label-brand">🌿 Fresh Grocery</div>
                    <div style="font-size:.78rem;color:#888;margin-top:.2rem;">123 Grocery Lane, India | support@freshmart.com</div>
                </div>
                <div>
                    <div class="label-type">DISPATCH LABEL</div>
                    <div style="font-size:.72rem;color:#888;margin-top:.3rem;text-align:right;">Order #<?= $order_id ?></div>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                <div>
                    <div style="font-size:.7rem;color:#888;font-weight:700;text-transform:uppercase;letter-spacing:.06em;margin-bottom:.5rem;">📤 FROM (Sender)</div>
                    <div style="font-size:.88rem;font-weight:600;line-height:1.7;">
                        Fresh Grocery<br>
                        123 Grocery Lane<br>
                        Surat, Gujarat – 395001<br>
                        📞 +91 98765 43210
                    </div>
                </div>
                <div style="border-left:2px dashed #e2ece5;padding-left:1rem;">
                    <div style="font-size:.7rem;color:#888;font-weight:700;text-transform:uppercase;letter-spacing:.06em;margin-bottom:.5rem;">📥 TO (Recipient)</div>
                    <div style="font-size:.92rem;font-weight:700;line-height:1.7;">
                        <?= htmlspecialchars($order['full_name']) ?><br>
                        <?= htmlspecialchars($order['address']) ?><br>
                        <?= htmlspecialchars($order['city']) ?>, <?= htmlspecialchars($order['state']) ?> – <?= htmlspecialchars($order['pincode']) ?><br>
                        📞 <?= htmlspecialchars($order['phone']) ?>
                        <?php if (!empty($order['notes'])): ?>
                            <br><em style="font-weight:400;font-size:.82rem;color:#555;">Note: <?= htmlspecialchars($order['notes']) ?></em>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="label-items" style="margin-bottom:.8rem;">
                <table>
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td>x<?= $item['quantity'] ?></td>
                            <td>₹<?= number_format($item['price'],2) ?></td>
                            <td>₹<?= number_format($item['price']*$item['quantity'],2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="label-footer">
                <div>
                    <div style="font-size:.7rem;color:#888;font-weight:700;text-transform:uppercase;letter-spacing:.06em;">Payment Mode</div>
                    <div style="font-weight:700;font-size:.92rem;"><?= htmlspecialchars($order['payment_method']) ?></div>
                    <?php if (stripos($order['payment_method'],'cash') !== false || stripos($order['payment_method'],'cod') !== false): ?>
                        <div class="label-stamp" style="color:#856404;border-color:#856404;">COLLECT CASH</div>
                    <?php else: ?>
                        <div class="label-stamp" style="color:#155724;border-color:#155724;">PAID ✓</div>
                    <?php endif; ?>
                </div>
                <div style="text-align:right;">
                    <div class="label-total">₹<?= number_format($order['total_amount'],2) ?></div>
                    <div class="label-barcode">ORD-<?= str_pad($order_id,8,'0',STR_PAD_LEFT) ?>-<?= strtoupper(substr(md5($order_id),0,6)) ?></div>
                    <div class="label-qr">Date: <?= fmtDate($order['created_at']) ?><br>Fresh Grocery Dispatch System</div>
                </div>
            </div>
        </div>

    </div>

    <!-- RIGHT COL -->
    <div class="right-col">

        <!-- USER INFO -->
        <div class="card user-card">
            <div class="card-head">
                <ion-icon name="person-circle-outline"></ion-icon>
                <h2>Customer Profile</h2>
            </div>
            <div class="card-body">
                <div class="user-avatar"><?= strtoupper(substr($order['username'],0,1)) ?></div>
                <div style="font-weight:700;font-size:1.05rem;"><?= htmlspecialchars($order['username']) ?></div>
                <div style="color:var(--muted);font-size:.83rem;margin-top:.2rem;"><?= htmlspecialchars($user['email'] ?? '—') ?></div>
                <div class="ustat-grid">
                    <div class="ustat">
                        <div class="ustat-val"><?= $ucnt['c'] ?? 0 ?></div>
                        <div class="ustat-lbl">Orders</div>
                    </div>
                    <div class="ustat">
                        <div class="ustat-val">₹<?= number_format($ucnt['t'] ?? 0,0) ?></div>
                        <div class="ustat-lbl">Spent</div>
                    </div>
                </div>
                <a href="admin.php?search=<?= urlencode($order['username']) ?>" style="display:block;margin-top:1rem;text-align:center;color:var(--green-dk);font-size:.85rem;font-weight:600;text-decoration:none;">
                    View All Orders →
                </a>
            </div>
        </div>

        <!-- STATUS UPDATE -->
        <div class="card status-form-card">
            <div class="card-head">
                <ion-icon name="settings-outline"></ion-icon>
                <h2>Update Order Status</h2>
            </div>
            <div class="card-body">
                <form method="POST" class="status-form">
                    <label style="font-size:.8rem;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;display:block;margin-bottom:.5rem;">Current Status</label>
                    <select name="status" class="status-select-lg">
                        <?php foreach (['pending','processing','dispatched','delivered','cancelled'] as $st): ?>
                            <option value="<?= $st ?>" <?= $order['status']===$st?'selected':'' ?>><?= ucfirst($st) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label style="font-size:.8rem;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;display:block;margin-bottom:.5rem;">Admin Note (optional)</label>
                    <textarea name="admin_note" class="note-textarea" placeholder="Add internal note about this order..."><?= htmlspecialchars($order['admin_note'] ?? '') ?></textarea>
                    <button type="submit" name="update_status" value="1" class="update-btn">
                        <ion-icon name="checkmark-circle-outline"></ion-icon> Update Status
                    </button>
                </form>
            </div>
        </div>

        <!-- ORDER TIMELINE -->
        <div class="card">
            <div class="card-head">
                <ion-icon name="git-branch-outline"></ion-icon>
                <h2>Order Timeline</h2>
            </div>
            <?php
            $stages = ['pending'=>'Order Placed','processing'=>'Being Processed','dispatched'=>'Out for Delivery','delivered'=>'Delivered'];
            $stage_keys = array_keys($stages);
            $curr_idx = array_search($order['status'], $stage_keys);
            ?>
            <div class="timeline">
                <?php foreach ($stages as $sk => $slabel):
                    $sidx = array_search($sk,$stage_keys);
                    $done = $curr_idx !== false && $sidx < $curr_idx;
                    $curr = $order['status'] === $sk;
                    $todo = !$done && !$curr;
                    $cls  = $done?'done':($curr?'curr':'todo');
                    $icon = $done?'✓':($curr?'●':'○');
                ?>
                <div class="tl-item">
                    <div class="tl-dot <?= $cls ?>"><?= $icon ?></div>
                    <div class="tl-info">
                        <div class="tl-label" style="<?= $curr?'color:var(--green-dk);':($todo?'color:#ccc;':'') ?>"><?= $slabel ?></div>
                        <div class="tl-sub"><?= $curr?'Current status':($done?'Completed':'Pending') ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php if ($order['status'] === 'cancelled'): ?>
                <div class="tl-item">
                    <div class="tl-dot" style="background:#fdf0f0;color:#e74c3c;">✕</div>
                    <div class="tl-info">
                        <div class="tl-label" style="color:#e74c3c;">Order Cancelled</div>
                        <div class="tl-sub">This order was cancelled</div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- QUICK ACTIONS -->
        <div class="card no-print">
            <div class="card-head">
                <ion-icon name="flash-outline"></ion-icon>
                <h2>Quick Actions</h2>
            </div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:.7rem;">
                <button onclick="printLabel()" style="width:100%;padding:.8rem;background:#2c3e50;color:#fff;border:none;border-radius:10px;font-family:'DM Sans',sans-serif;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.5rem;font-size:.9rem;">
                    <ion-icon name="print-outline"></ion-icon> 🖨️ Print Dispatch Label
                </button>
                <a href="admin.php" style="width:100%;padding:.8rem;border:1.5px solid var(--border);border-radius:10px;font-family:'DM Sans',sans-serif;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.5rem;font-size:.9rem;text-decoration:none;color:var(--text);">
                    <ion-icon name="list-outline"></ion-icon> All Orders
                </a>
                <a href="tel:<?= htmlspecialchars($order['phone']) ?>" style="width:100%;padding:.8rem;background:var(--green-lt);border:1.5px solid var(--green);border-radius:10px;font-family:'DM Sans',sans-serif;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.5rem;font-size:.9rem;text-decoration:none;color:var(--green-dk);">
                    <ion-icon name="call-outline"></ion-icon> Call Customer
                </a>
            </div>
        </div>

    </div><!-- /right-col -->
</div><!-- /page -->

<script>
function printLabel() {
    const label = document.getElementById('printLabel');
    label.style.display = 'block';
    window.print();
    // Hide again after print dialog closes
    setTimeout(() => { label.style.display = 'none'; }, 1000);
}

// Auto-print if ?print=1 in URL
<?php if ($print_mode): ?>
window.addEventListener('load', () => setTimeout(printLabel, 600));
<?php endif; ?>
</script>

</body>
</html>
