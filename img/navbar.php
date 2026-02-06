<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <link rel="stylesheet" href="style.css"> -->
  <!-- <link rel="stylesheet" href="styles.css"> -->
  <title>Document</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      display: center;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      font-family: Arial, sans-serif;
      line-height: 1.6;
      background-color: #f4f4f4;
    }
      
    /* Navbar styles */
    .navbar {
      width: 100%;
      background-color: #2ecc71;
      padding: 1rem 2rem;
      display: flex;
      justify-content: top;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: -1;
    }
    
    
    .logo h1 {
      color: white;
      font-size: 1.5rem;
    }
    
    .logo a {
      text-decoration: none;
      color: white;
    }
    
    
    .search-bar {
      display: flex;
      gap: 0.5rem;
      flex: 0 1 400px;
    }
    
    .search-bar input {
      padding: 0.5rem;
      border: none;
      border-radius: 4px;
      flex: 1;
    }
    
    .search-bar button {
      padding: 0.5rem 1rem;
      background-color: #27ae60;
      border: none;
      border-radius: 4px;
      color: white;
      cursor: pointer;
    }
    
    .cart-icon a {
      color: white;
      text-decoration: none;
      /* background-image: url("🛒"); */
      font-size: 1.2rem;
      position: relative;
    }
    
    #cartCount {
      position: absolute;
      top: -8px;
      right: -8px;
      background-color: #e74c3c;
      color: white;
      border-radius: 50%;
      padding: 0.2rem 0.5rem;
      font-size: 0.8rem;
    }
    
    .navbar .cont{
      display: flex;
      justify-content: start;
      width: 40%;
    }
    .navbar .cont a{
      color: white;
      text-decoration: none;
      margin: 10px;        
    }
  </style>
    
  </head>
  <body>
    <nav class="navbar">
      <div class="logo">
        <h1><a href="index.php">Fresh Grocery</a></h1>
      </div>
      <div class="cont">
        <h3> <a href="index.php">Home</a></h3>
        
        <h3> <a href="login.php">Login</a></h3>
        <!-- <h3><a href="login.php">Contact Us</a> </h3> -->
        
      </div>
      
      <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search products...">
        <button type="button"><i class="fas fa-search">🔍</i></button>
        
      </div>
      <div class="cart-icon">
        <a href="cart.php">
          <i class="fas fa-shopping-cart">🛒</i>
          <span id="cartCount">0</span>
        </a>
      </div>
    </nav>

</body>
</html>