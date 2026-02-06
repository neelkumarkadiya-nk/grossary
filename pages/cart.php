<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Fresh Grocery</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    

</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <h1><a href="login.php">Fresh Grocery</a></h1>
        </div>
        <div class="cont">
            <h3> <a href="index.php">Home</a></h3>
            <h3> <a href="index.php">My Profile</a></h3>
            
            <h3> <a href="login.php">Login</a></h3>
            <h3><a href="login.php">Contact Us</a> </h3>
            
        </div>
        
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search products...">
            <ion-icon name="search-outline" class="icon"></ion-icon>
            <!-- <button type="button"><i class="fas fa-search">🔍</i></button> -->
            
        </div>
  
    </nav>
    

    <main>
        <section class="cart-section">
            <h2>Shopping Cart</h2>
            <div class="cart-container">
                <!-- Cart items will be dynamically loaded here -->
            </div>
            <div class="cart-summary">
                <div class="total">
                    <h3>Total: ₹<span id="cartTotal">0.00</span></h3>
                </div>
                <button class="checkout-btn" onclick="window.location.href='checkout.php'">Proceed to Checkout</button>
            </div>
        </section>
    </main>
<!-- 
    <footer>
    </footer> -->

    <script src="coustomer.js"></script>
    <script src="checkout.js"> </script>
    <script src="scripts.js"></script>

</body>
</html> 