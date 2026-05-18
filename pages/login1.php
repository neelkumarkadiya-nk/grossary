<?php
$msg = '';
$msg_type = '';
if (isset($_GET['registered']) && $_GET['registered'] == '1') {
    $msg = 'Account created! Please login below.';
    $msg_type = 'success';
}
if (isset($_GET['error'])) {
    $msg = htmlspecialchars($_GET['error']);
    $msg_type = 'error';
}
$active_tab = (isset($_GET['tab']) && $_GET['tab'] === 'register') ? 'register' : 'login';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fresh Grocery – Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --green:      #2ecc71;
            --green-dark: #27ae60;
            --white:      #ffffff;
            --radius:     16px;
        }
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            min-height: 100vh;
            font-family: 'DM Sans', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* ── FULL PAGE BG IMAGE ── */
        .bg {
            position: fixed;
            inset: 0;
            background: url('home-bg.jpg') center center / cover no-repeat;
            z-index: 0;
        }
        .bg::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg,
                rgba(10, 40, 20, 0.82) 0%,
                rgba(15, 50, 30, 0.70) 50%,
                rgba(5, 25, 12, 0.88) 100%);
        }

        /* ── FLOATING CARD ── */
        .card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 460px;
            margin: 1.5rem;
            background: rgba(255,255,255,0.07);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 24px;
            padding: 2.8rem 2.5rem;
            box-shadow: 0 32px 80px rgba(0,0,0,0.45);
            animation: floatIn 0.6s cubic-bezier(0.16,1,0.3,1) both;
        }

        @keyframes floatIn {
            from { opacity:0; transform: translateY(30px) scale(0.97); }
            to   { opacity:1; transform: translateY(0)  scale(1);    }
        }

        /* ── LOGO ── */
        .logo {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            margin-bottom: 2rem;
            justify-content: center;
        }
        .logo-icon {
            width: 46px; height: 46px;
            background: var(--green);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }
        .logo-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--white);
            letter-spacing: -0.3px;
        }

        /* ── TABS ── */
        .tabs {
            display: flex;
            background: rgba(255,255,255,0.07);
            border-radius: 10px;
            padding: 4px;
            margin-bottom: 1.8rem;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .tab-btn {
            flex: 1;
            padding: 0.6rem;
            border: none;
            background: transparent;
            color: rgba(255,255,255,0.5);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.92rem;
            font-weight: 500;
            border-radius: 7px;
            cursor: pointer;
            transition: all 0.25s;
        }
        .tab-btn.active {
            background: var(--green);
            color: white;
            font-weight: 700;
            box-shadow: 0 4px 14px rgba(46,204,113,0.35);
        }

        /* ── PANELS ── */
        .panel { display: none; }
        .panel.active { display: block; }

        .panel-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--white);
            margin-bottom: 0.25rem;
        }
        .panel-sub {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.45);
            margin-bottom: 1.5rem;
        }

        /* ── FIELDS ── */
        .field { margin-bottom: 1rem; }
        .field label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: rgba(255,255,255,0.45);
            text-transform: uppercase;
            letter-spacing: 0.7px;
            margin-bottom: 0.4rem;
        }
        .input-wrap {
            position: relative;
        }
        .input-wrap span {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.1rem;
            pointer-events: none;
        }
        .field input {
            width: 100%;
            padding: 0.8rem 1rem 0.8rem 2.8rem;
            background: rgba(255,255,255,0.08);
            border: 1.5px solid rgba(255,255,255,0.12);
            border-radius: 10px;
            color: var(--white);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.2s;
        }
        .field input::placeholder { color: rgba(255,255,255,0.22); }
        .field input:focus {
            border-color: var(--green);
            background: rgba(46,204,113,0.08);
        }

        /* ── SUBMIT BTN ── */
        .submit-btn {
            width: 100%;
            padding: 0.9rem;
            background: linear-gradient(135deg, var(--green), var(--green-dark));
            color: white;
            border: none;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            margin-top: 0.6rem;
            transition: all 0.25s;
            box-shadow: 0 6px 22px rgba(46,204,113,0.35);
            letter-spacing: 0.3px;
        }
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(46,204,113,0.45);
        }

        /* ── ALERT ── */
        .alert {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            font-size: 0.86rem;
            margin-bottom: 1.2rem;
            font-weight: 500;
        }
        .alert.success {
            background: rgba(46,204,113,0.15);
            border: 1px solid rgba(46,204,113,0.3);
            color: #7de8aa;
        }
        .alert.error {
            background: rgba(231,76,60,0.15);
            border: 1px solid rgba(231,76,60,0.3);
            color: #f1948a;
        }

        /* ── SWITCH LINK ── */
        .switch-link {
            text-align: center;
            font-size: 0.85rem;
            color: rgba(255,255,255,0.4);
            margin-top: 1.2rem;
        }
        .switch-link a {
            color: var(--green);
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }

        /* ── FOOTER TAG ── */
        .card-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.78rem;
            color: rgba(255,255,255,0.2);
        }
    </style>
</head>
<body>

<div class="bg"></div>

<div class="card">

    <!-- LOGO -->
    <div class="logo">
        <div class="logo-icon">🛒</div>
        <span class="logo-text">Fresh Grocery</span>
    </div>

    <!-- TABS -->
    <div class="tabs">
        <button class="tab-btn <?php echo $active_tab==='login'?'active':''; ?>"    id="loginTab"    onclick="switchTab('login')">Login</button>
        <button class="tab-btn <?php echo $active_tab==='register'?'active':''; ?>" id="registerTab" onclick="switchTab('register')">Sign Up</button>
    </div>

    <!-- ALERT -->
    <?php if ($msg): ?>
    <div class="alert <?php echo $msg_type; ?>">
        <?php echo $msg_type==='success'?'✅':'⚠️'; ?> <?php echo $msg; ?>
    </div>
    <?php endif; ?>

    <!-- LOGIN PANEL -->
    <div class="panel <?php echo $active_tab==='login'?'active':''; ?>" id="loginPanel">
        <h2 class="panel-title">Welcome back 👋</h2>
        <p class="panel-sub">Login to continue shopping</p>
        <form action="process_register.php" method="POST">
            <div class="field">
                <label>Username</label>
                <div class="input-wrap">
                    <span>👤</span>
                    <input type="text" name="username" placeholder="Enter your username" required>
                </div>
            </div>
            <div class="field">
                <label>Password</label>
                <div class="input-wrap">
                    <span>🔒</span>
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>
            </div>
            <button type="submit" name="login" class="submit-btn">Login →</button>
        </form>
        <div class="switch-link">New here? <a onclick="switchTab('register')">Create an account</a></div>
    </div>

    <!-- REGISTER PANEL -->
    <div class="panel <?php echo $active_tab==='register'?'active':''; ?>" id="registerPanel">
        <h2 class="panel-title">Create account 🌿</h2>
        <p class="panel-sub">Join and start shopping fresh</p>
        <form action="process_register.php" method="POST">
            <div class="field">
                <label>Username</label>
                <div class="input-wrap">
                    <span>👤</span>
                    <input type="text" name="username" placeholder="Choose a username" required>
                </div>
            </div>
            <div class="field">
                <label>Email</label>
                <div class="input-wrap">
                    <span>📧</span>
                    <input type="email" name="email" placeholder="you@example.com">
                </div>
            </div>
            <div class="field">
                <label>Password</label>
                <div class="input-wrap">
                    <span>🔒</span>
                    <input type="password" name="password" placeholder="Create a password" required>
                </div>
            </div>
            <button type="submit" name="register" class="submit-btn">Create Account →</button>
        </form>
        <div class="switch-link">Already have an account? <a onclick="switchTab('login')">Login here</a></div>
    </div>

    <div class="card-footer">© 2026 Fresh Grocery. All rights reserved.</div>
</div>

<script>
function switchTab(tab) {
    ['loginPanel','registerPanel'].forEach(function(id){
        document.getElementById(id).classList.remove('active');
    });
    ['loginTab','registerTab'].forEach(function(id){
        document.getElementById(id).classList.remove('active');
    });
    document.getElementById(tab+'Panel').classList.add('active');
    document.getElementById(tab+'Tab').classList.add('active');
}
</script>
</body>
</html>
