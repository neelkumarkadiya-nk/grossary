<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fresh Grocery Store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <style>
        /* ─── RESET & BASE ─────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green:       #2d6a4f;
            --green-mid:   #40916c;
            --green-light: #74c69d;
            --cream:       #f8f5f0;
            --white:       #ffffff;
            --black:       #1a1a1a;
            --grey:        #6b7280;
            --grey-light:  #f3f4f6;
            --orange:      #e07b39;
            --shadow-sm:   0 2px 8px rgba(0,0,0,.08);
            --shadow-md:   0 8px 24px rgba(0,0,0,.12);
            --shadow-lg:   0 20px 48px rgba(0,0,0,.16);
            --radius:      14px;
            --transition:  .3s cubic-bezier(.4,0,.2,1);
        }

        html { scroll-behavior: smooth; font-size: 62.5%; }

        body {
            font-family: 'DM Sans', sans-serif;
            font-size: 1.6rem;
            background: var(--cream);
            color: var(--black);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* ─── NAVBAR ────────────────────────────────────── */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 900;
            display: flex;
            align-items: center;
            gap: 2.4rem;
            padding: 0 4rem;
            height: 7rem;
            background: var(--white);
            box-shadow: var(--shadow-sm);
            backdrop-filter: blur(8px);
        }

        .navbar .logo a {
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem;
            font-weight: 700;
            color: var(--green);
            text-decoration: none;
            white-space: nowrap;
            letter-spacing: -.5px;
        }

        .navbar .logo a span {
            color: var(--orange);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: .4rem;
            flex: 1;
            list-style: none;
        }

        .nav-links a {
            display: block;
            padding: .8rem 1.4rem;
            border-radius: 8px;
            font-size: 1.4rem;
            font-weight: 500;
            color: var(--grey);
            text-decoration: none;
            transition: color var(--transition), background var(--transition);
        }

        .nav-links a:hover {
            color: var(--green);
            background: #e8f5ee;
        }

        .nav-links a.active {
            color: var(--green);
            background: #e8f5ee;
        }

        /* Search */
        .search-bar {
            position: relative;
            flex: 0 0 28rem;
        }

        .search-bar input {
            width: 100%;
            padding: 1rem 1.6rem 1rem 4rem;
            border: 1.5px solid #e5e7eb;
            border-radius: 50px;
            font-family: 'DM Sans', sans-serif;
            font-size: 1.4rem;
            background: var(--grey-light);
            color: var(--black);
            outline: none;
            transition: border-color var(--transition), box-shadow var(--transition);
        }

        .search-bar input:focus {
            border-color: var(--green-light);
            box-shadow: 0 0 0 3px rgba(116,198,157,.2);
            background: var(--white);
        }

        .search-bar ion-icon {
            position: absolute;
            left: 1.4rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.8rem;
            color: var(--grey);
            pointer-events: none;
        }

        /* Cart icon */
        .cart-icon a {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 4.4rem;
            height: 4.4rem;
            border-radius: 50%;
            background: var(--green);
            color: var(--white);
            text-decoration: none;
            transition: background var(--transition), transform var(--transition);
        }

        .cart-icon a:hover {
            background: var(--green-mid);
            transform: scale(1.07);
        }

        .cart-icon ion-icon {
            font-size: 2.2rem;
        }

        .cart-icon #cartCount {
            position: absolute;
            top: -4px;
            right: -4px;
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            background: var(--orange);
            color: var(--white);
            font-size: 1.1rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--white);
        }

        /* Profile pill */
        .nav-profile {
            display: flex;
            align-items: center;
            gap: .8rem;
            padding: .6rem 1.4rem .6rem .8rem;
            border-radius: 50px;
            background: var(--grey-light);
            cursor: pointer;
            text-decoration: none;
            font-size: 1.4rem;
            font-weight: 500;
            color: var(--black);
            transition: background var(--transition);
        }

        .nav-profile:hover { background: #e8f5ee; color: var(--green); }

        .nav-avatar {
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            background: var(--green);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-avatar ion-icon { color: var(--white); font-size: 1.8rem; }

        /* ─── HERO ─────────────────────────────────────── */
        .hero {
            position: relative;
            min-height: 55rem;
            display: flex;
            align-items: center;
            overflow: hidden;
            background: linear-gradient(135deg, #1b4332 0%, #2d6a4f 60%, #40916c 100%);
        }

        .hero-bg-pattern {
            position: absolute;
            inset: 0;
            background-image: url("home-bg.jpg");
            background-size: cover;
            background-position: center;
            opacity: .18;
        }

        /* Decorative circles */
        .hero::before, .hero::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,.04);
        }
        .hero::before { width: 50rem; height: 50rem; top: -15rem; right: -10rem; }
        .hero::after  { width: 30rem; height: 30rem; bottom: -12rem; left: 5%; }

        .hero-content {
            position: relative;
            z-index: 2;
            padding: 6rem 8rem;
            max-width: 64rem;
            animation: fadeUp .7s ease both;
        }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: .8rem;
            padding: .6rem 1.6rem;
            border-radius: 50px;
            background: rgba(255,255,255,.12);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255,255,255,.2);
            color: var(--green-light);
            font-size: 1.3rem;
            font-weight: 600;
            letter-spacing: .6px;
            text-transform: uppercase;
            margin-bottom: 2.4rem;
        }

        .hero-tag span { color: var(--white); opacity: .7; }

        .hero-content h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(3.6rem, 5vw, 5.6rem);
            font-weight: 700;
            line-height: 1.15;
            color: var(--white);
            margin-bottom: 2rem;
        }

        .hero-content h1 em {
            font-style: normal;
            color: var(--green-light);
        }

        .hero-content p {
            font-size: 1.7rem;
            color: rgba(255,255,255,.72);
            line-height: 1.7;
            margin-bottom: 3.6rem;
            max-width: 48rem;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            gap: 1.6rem;
            flex-wrap: wrap;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: .8rem;
            padding: 1.4rem 3rem;
            border-radius: 50px;
            background: var(--orange);
            color: var(--white);
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: 600;
            transition: transform var(--transition), box-shadow var(--transition), background var(--transition);
            box-shadow: 0 4px 16px rgba(224,123,57,.4);
        }

        .btn-primary:hover {
            background: #c96a28;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(224,123,57,.5);
        }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: .8rem;
            padding: 1.4rem 2.8rem;
            border-radius: 50px;
            border: 1.5px solid rgba(255,255,255,.35);
            color: var(--white);
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: 500;
            transition: background var(--transition), border-color var(--transition);
        }

        .btn-ghost:hover {
            background: rgba(255,255,255,.1);
            border-color: rgba(255,255,255,.6);
        }

        /* Hero Stats bar */
        .hero-stats {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 2;
            display: flex;
            background: rgba(255,255,255,.08);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(255,255,255,.12);
        }

        .hero-stat {
            flex: 1;
            text-align: center;
            padding: 1.8rem 1rem;
            border-right: 1px solid rgba(255,255,255,.1);
        }

        .hero-stat:last-child { border-right: none; }

        .hero-stat .number {
            display: block;
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem;
            font-weight: 700;
            color: var(--white);
        }

        .hero-stat .label {
            font-size: 1.2rem;
            color: rgba(255,255,255,.6);
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        /* ─── SECTION COMMONS ───────────────────────────── */
        section {
            padding: 6rem 4rem;
        }

        .section-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 3.6rem;
        }

        .section-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 3.2rem;
            font-weight: 700;
            color: var(--black);
            line-height: 1.2;
        }

        .section-header h2 span {
            color: var(--green);
        }

        .section-sub {
            font-size: 1.4rem;
            color: var(--grey);
            margin-top: .4rem;
        }

        .view-all {
            display: inline-flex;
            align-items: center;
            gap: .6rem;
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--green);
            text-decoration: none;
            padding: .8rem 1.6rem;
            border-radius: 50px;
            border: 1.5px solid var(--green-light);
            transition: background var(--transition), color var(--transition);
        }

        .view-all:hover {
            background: var(--green);
            color: var(--white);
        }

        /* ─── PROMOTIONAL BANNER ────────────────────────── */
        .promo-strip {
            margin: 0 4rem;
            border-radius: var(--radius);
            background: linear-gradient(100deg, #fef3c7 0%, #fde68a 100%);
            padding: 2rem 3rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
            border: 1px solid #fcd34d;
        }

        .promo-strip .promo-text {
            display: flex;
            align-items: center;
            gap: 1.6rem;
        }

        .promo-icon {
            font-size: 3.6rem;
        }

        .promo-strip h4 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #92400e;
        }

        .promo-strip p {
            font-size: 1.4rem;
            color: #b45309;
            margin-top: .2rem;
        }

        .promo-btn {
            padding: 1rem 2.4rem;
            border-radius: 50px;
            background: #b45309;
            color: var(--white);
            text-decoration: none;
            font-size: 1.4rem;
            font-weight: 600;
            white-space: nowrap;
            transition: background var(--transition), transform var(--transition);
        }

        .promo-btn:hover {
            background: #92400e;
            transform: translateY(-1px);
        }

        /* ─── CATEGORIES ────────────────────────────────── */
        .categories {
            background: var(--white);
        }

        .category-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(15rem, 1fr));
            gap: 1.6rem;
        }

        /* Category card styles will be applied via JS dynamically,
           but we set a base for any .category-card class */
        .category-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1.2rem;
            padding: 2.8rem 1.6rem;
            background: var(--cream);
            border-radius: var(--radius);
            border: 1.5px solid transparent;
            cursor: pointer;
            transition: all var(--transition);
            text-decoration: none;
            color: var(--black);
        }

        .category-card:hover {
            background: #e8f5ee;
            border-color: var(--green-light);
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .category-card .cat-icon {
            font-size: 3.6rem;
        }

        .category-card .cat-name {
            font-size: 1.4rem;
            font-weight: 600;
            text-align: center;
        }

        .category-card .cat-count {
            font-size: 1.2rem;
            color: var(--grey);
        }

        /* ─── PRODUCTS ──────────────────────────────────── */
        .products {
            background: var(--cream);
        }

        .products-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(24rem, 1fr));
            gap: 2.4rem;
        }

        /* Product card — base styles for dynamic cards */
        .product-card {
            background: var(--white);
            border-radius: var(--radius);
            overflow: hidden;
            border: 1.5px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            transition: transform var(--transition), box-shadow var(--transition);
            animation: fadeUp .5s ease both;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-lg);
        }

        .product-card img {
            width: 100%;
            height: 19rem;
            object-fit: cover;
            transition: transform .5s ease;
        }

        .product-card:hover img {
            transform: scale(1.05);
        }

        .product-info {
            padding: 1.6rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: .6rem;
        }

        .product-badge {
            display: inline-block;
            padding: .3rem .9rem;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            background: #dcfce7;
            color: #15803d;
            text-transform: uppercase;
            letter-spacing: .4px;
            width: fit-content;
        }

        .product-name {
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--black);
        }

        .product-desc {
            font-size: 1.3rem;
            color: var(--grey);
            line-height: 1.5;
        }

        .product-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: auto;
            padding-top: 1.2rem;
            border-top: 1px solid #f0f0f0;
        }

        .product-price {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--green);
        }

        .product-price .old-price {
            font-family: 'DM Sans', sans-serif;
            font-size: 1.2rem;
            color: var(--grey);
            text-decoration: line-through;
            font-weight: 400;
            margin-right: .4rem;
        }

        .add-to-cart-btn {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .8rem 1.6rem;
            background: var(--green);
            color: var(--white);
            border: none;
            border-radius: 50px;
            font-family: 'DM Sans', sans-serif;
            font-size: 1.3rem;
            font-weight: 600;
            cursor: pointer;
            transition: background var(--transition), transform var(--transition);
        }

        .add-to-cart-btn:hover {
            background: var(--green-mid);
            transform: scale(1.05);
        }

        /* ─── FEATURES STRIP ────────────────────────────── */
        .features-strip {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0;
            background: var(--green);
            margin: 0;
            padding: 3.6rem 4rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 1.6rem;
            padding: 0 2.4rem;
            border-right: 1px solid rgba(255,255,255,.15);
        }

        .feature-item:last-child { border-right: none; }

        .feature-icon {
            width: 5rem;
            height: 5rem;
            border-radius: 50%;
            background: rgba(255,255,255,.12);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .feature-icon ion-icon {
            font-size: 2.4rem;
            color: var(--green-light);
        }

        .feature-text h4 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--white);
        }

        .feature-text p {
            font-size: 1.2rem;
            color: rgba(255,255,255,.65);
            margin-top: .2rem;
        }

        /* ─── ADMIN PANEL ───────────────────────────────── */
        .admin-section {
            background: var(--white);
            border-top: 3px solid var(--green);
        }

        .admin-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2.4rem;
        }

        .admin-header h2 {
            font-size: 2.4rem;
            font-weight: 700;
        }

        .admin-toggle {
            padding: .8rem 1.8rem;
            background: var(--green);
            color: var(--white);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            font-size: 1.4rem;
            font-weight: 600;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 1.4rem;
        }

        .orders-table th {
            background: var(--green);
            color: var(--white);
            padding: 1.2rem 1.6rem;
            text-align: left;
            font-weight: 600;
            font-size: 1.3rem;
        }

        .orders-table td {
            padding: 1.2rem 1.6rem;
            border-bottom: 1px solid #f0f0f0;
            color: var(--black);
        }

        .orders-table tr:hover td {
            background: #f8fffe;
        }

        /* ─── MODAL ─────────────────────────────────────── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            backdrop-filter: blur(4px);
        }

        .modal-content {
            background: var(--white);
            padding: 4rem;
            border-radius: 2rem;
            text-align: center;
            max-width: 42rem;
            width: 90%;
            animation: slideIn .35s cubic-bezier(.4,0,.2,1) both;
            box-shadow: var(--shadow-lg);
        }

        .modal-icon { font-size: 5.6rem; margin-bottom: 1.6rem; }

        .modal-content h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem;
            margin-bottom: 1rem;
        }

        .modal-content p { font-size: 1.5rem; color: var(--grey); }

        .modal-buttons {
            display: flex;
            gap: 1.2rem;
            margin-top: 2.4rem;
        }

        .btn-login {
            flex: 1;
            background: var(--green);
            color: var(--white);
            border: none;
            padding: 1.3rem;
            border-radius: 10px;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            font-size: 1.5rem;
            font-weight: 600;
            transition: background var(--transition);
        }

        .btn-login:hover { background: var(--green-mid); }

        .btn-close {
            flex: 1;
            background: var(--grey-light);
            color: #333;
            border: none;
            padding: 1.3rem;
            border-radius: 10px;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            font-size: 1.5rem;
            font-weight: 500;
            transition: background var(--transition);
        }

        .btn-close:hover { background: #e5e7eb; }

        /* ─── FOOTER ────────────────────────────────────── */
        .footer {
            background: #0d2317;
            color: rgba(255,255,255,.75);
            padding: 6rem 4rem 0;
        }

        .footer-container {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 4rem;
            padding-bottom: 4rem;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }

        .footer-col h3 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 1.4rem;
        }

        .footer-col h3 span { color: var(--green-light); }

        .footer-col p {
            font-size: 1.4rem;
            line-height: 1.8;
            color: rgba(255,255,255,.6);
        }

        .footer-col h4 {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--white);
            text-transform: uppercase;
            letter-spacing: .8px;
            margin-bottom: 1.6rem;
        }

        .footer-col ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: .8rem;
        }

        .footer-col ul a {
            font-size: 1.4rem;
            color: rgba(255,255,255,.6);
            text-decoration: none;
            transition: color var(--transition);
        }

        .footer-col ul a:hover { color: var(--green-light); }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 1.4rem;
            color: rgba(255,255,255,.6);
            margin-bottom: .8rem;
        }

        .contact-item ion-icon {
            font-size: 1.8rem;
            color: var(--green-light);
            flex-shrink: 0;
        }

        .footer-bottom {
            text-align: center;
            padding: 2.4rem 0;
            font-size: 1.3rem;
            color: rgba(255,255,255,.4);
        }

        /* ─── ANIMATIONS ────────────────────────────────── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-30px) scale(.95); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ─── RESPONSIVE ────────────────────────────────── */
        @media (max-width: 1024px) {
            .footer-container { grid-template-columns: 1fr 1fr; }
            .features-strip   { grid-template-columns: 1fr 1fr; gap: 2px; }
        }

        @media (max-width: 768px) {
            html { font-size: 55%; }

            .navbar {
                padding: 0 2rem;
                gap: 1.2rem;
            }

            .nav-links { display: none; }

            .search-bar { flex: 1; }

            .hero-content { padding: 5rem 3rem 12rem; }

            .hero-stats { position: static; }
            .hero { flex-direction: column; }

            section { padding: 4rem 2rem; }
            .promo-strip { margin: 0 2rem; flex-direction: column; text-align: center; }

            .features-strip { grid-template-columns: 1fr 1fr; padding: 2.4rem 2rem; gap: 1.6rem; }
            .feature-item { border-right: none; }

            .footer-container { grid-template-columns: 1fr; gap: 2.4rem; }
        }
    </style>
</head>
<body>

    <!-- ── NAVBAR ──────────────────────────────────────── -->
    <nav class="navbar">
        <div class="logo">
            <a href="index.php">Fresh<span>Grocery</span></a>
        </div>

        <ul class="nav-links">
            <li><a href="index.php" class="active">Home</a></li>
            <li><a href="#Product">Shop</a></li>
            <li><a href="orders.php">My Orders</a></li>
            <li><a href="#Contact Us">About</a></li>
        </ul>

        <div class="search-bar">
            <ion-icon name="search-outline"></ion-icon>
            <input type="text" id="searchInput" placeholder="Search fresh products…">
        </div>

        <a href="profile.php" class="nav-profile">
            <div class="nav-avatar"><ion-icon name="person-outline"></ion-icon></div>
            My Profile
        </a>

        <div class="cart-icon">
            <a href="cart.php" title="Shopping Cart">
                <ion-icon name="cart-outline"></ion-icon>
                <span id="cartCount">0</span>
            </a>
        </div>
    </nav>

    <!-- ── HERO ────────────────────────────────────────── -->
    <section class="hero">
        <div class="hero-bg-pattern"></div>

        <div class="hero-content">
            <div class="hero-tag">
                <ion-icon name="leaf-outline"></ion-icon>
                <span>100% Organic &amp; Fresh</span>
            </div>

            <h1>Reach For A<br><em>Healthier You</em><br>With Organic Foods</h1>

            <p>Fresh groceries from local farms delivered straight to your doorstep. Quality you can taste, prices you'll love.</p>

            <div class="hero-actions">
                <a href="#Product" class="btn-primary">
                    <ion-icon name="storefront-outline"></ion-icon>
                    Shop Now
                </a>
                <a href="#Contact Us" class="btn-ghost">
                    <ion-icon name="information-circle-outline"></ion-icon>
                    About Us
                </a>
            </div>
        </div>

        <div class="hero-stats">
            <div class="hero-stat">
                <span class="number">500+</span>
                <span class="label">Products</span>
            </div>
            <div class="hero-stat">
                <span class="number">10k+</span>
                <span class="label">Happy Customers</span>
            </div>
            <div class="hero-stat">
                <span class="number">48h</span>
                <span class="label">Fast Delivery</span>
            </div>
            <div class="hero-stat">
                <span class="number">100%</span>
                <span class="label">Organic</span>
            </div>
        </div>
    </section>

    <!-- ── PROMO BANNER ────────────────────────────────── -->
    <div class="promo-strip">
        <div class="promo-text">
            <span class="promo-icon">🎉</span>
            <div>
                <h4>Free Delivery on Orders Over ₹499!</h4>
                <p>Limited time offer — use code <strong>FRESH50</strong> for 10% off your first order</p>
            </div>
        </div>
        <a href="#Product" class="promo-btn">Claim Offer →</a>
    </div>

    <!-- ── FEATURES STRIP ──────────────────────────────── -->
    <div class="features-strip">
        <div class="feature-item">
            <div class="feature-icon"><ion-icon name="rocket-outline"></ion-icon></div>
            <div class="feature-text">
                <h4>Fast Delivery</h4>
                <p>Same-day &amp; next-day options</p>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon"><ion-icon name="shield-checkmark-outline"></ion-icon></div>
            <div class="feature-text">
                <h4>Quality Assured</h4>
                <p>Farm-fresh, handpicked produce</p>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon"><ion-icon name="leaf-outline"></ion-icon></div>
            <div class="feature-text">
                <h4>100% Organic</h4>
                <p>Certified natural &amp; pesticide-free</p>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon"><ion-icon name="card-outline"></ion-icon></div>
            <div class="feature-text">
                <h4>Secure Payment</h4>
                <p>Multiple safe payment options</p>
            </div>
        </div>
    </div>

    <main>
        <!-- ── CATEGORIES ──────────────────────────────── -->
        <section class="categories">
            <div class="section-header">
                <div>
                    <h2 id="Product">Browse <span>Categories</span></h2>
                    <p class="section-sub">Find exactly what you're looking for</p>
                </div>
                <a href="#" class="view-all">View All <ion-icon name="arrow-forward-outline"></ion-icon></a>
            </div>
            <div class="category-container">
                <!-- Categories dynamically loaded by scripts.js -->
            </div>
        </section>

        <!-- ── PRODUCTS ────────────────────────────────── -->
        <section class="products">
            <div class="section-header">
                <div>
                    <h2>Featured <span>Products</span></h2>
                    <p class="section-sub">Handpicked freshness just for you</p>
                </div>
                <a href="products.php" class="view-all">View All <ion-icon name="arrow-forward-outline"></ion-icon></a>
            </div>
            <div class="products-container">
                <!-- Products dynamically loaded by scripts.js -->
            </div>
        </section>

        <!-- ── ADMIN PANEL ─────────────────────────────── -->
        <section class="admin-section" id="adminPanel" style="display: none;">
            <div class="admin-header">
                <h2>Admin Panel — Orders</h2>
                <button class="admin-toggle" onclick="toggleAdmin()">Toggle Admin Panel</button>
            </div>
            <div class="orders-container">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Address</th>
                            <th>Payment Method</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="ordersTableBody">
                        <!-- Orders dynamically loaded -->
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- ── FOOTER ──────────────────────────────────────── -->
    <footer class="footer" id="Contact Us">
        <div class="footer-container">
            <div class="footer-col">
                <h3>Fresh<span>Grocery</span></h3>
                <p>Your one-stop shop for fresh groceries delivered to your doorstep. Quality products, unbeatable prices, and a commitment to your health.</p>
            </div>

            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="products.php">Shop Now</a></li>
                    <li><a href="orders.php">My Orders</a></li>
                    <li><a href="cart.php">Cart</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Categories</h4>
                <ul>
                    <li><a href="#">Fruits &amp; Veggies</a></li>
                    <li><a href="#">Dairy Products</a></li>
                    <li><a href="#">Beverages</a></li>
                    <li><a href="#">Snacks</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Contact Us</h4>
                <div class="contact-item">
                    <ion-icon name="location-outline"></ion-icon>
                    <span>123 Grocery Lane, Gujarat, India</span>
                </div>
                <div class="contact-item">
                    <ion-icon name="mail-outline"></ion-icon>
                    <span>support@freshgrocery.com</span>
                </div>
                <div class="contact-item">
                    <ion-icon name="call-outline"></ion-icon>
                    <span>+91 98765 43210</span>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2026 FreshGrocery Store &mdash; All Rights Reserved. Made with ❤️ in India.</p>
        </div>
    </footer>

    <script src="checkout.js"></script>
    <script src="scripts.js"></script>
    <script src="scripts (1).js"></script>

</body>
</html>