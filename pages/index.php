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
    <link rel="stylesheet" href="styles.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <title>Fresh Grocery Store</title>
    <style>

            /* Modal Overlay - Blurs the background */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        /* Modal Box */
        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            max-width: 400px;
            width: 90%;
            animation: slideIn 0.3s ease-out;
        }

        .modal-icon {
            font-size: 50px;
            margin-bottom: 15px;
        }

        .modal-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-login {
            flex: 1;
            background: #27ae60;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-close {
            flex: 1;
            background: #eee;
            color: #333;
            border: none;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
        }

        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* about */
        .home-bg .home .content{
            display: flex;
            flex-direction: column;
            align-items: start;
            justify-content: center;
            width: 100%;
            padding: 4%;
            /* margin: 5%; */
            /* position: relative; */
        }
        .home-bg .home .content{
            display: flex;
            flex-direction: column;
            align-items: start;
            background-image: url(home-bg.jpg) ; 
               background-size: cover;
               background-position: no-repeat;
            
           
        }
        .home-bg .home .content span{
        
            color:orange;
            font-size: 2rem;
        }
        
        .home-bg .home .content h3{
            width: 50%;
            font-size: 2.5rem;
            text-transform: uppercase;
            margin-top: 1.5rem;
            color:var(--black);
        }
        
        .home-bg .home .content p{
            font-size: 1.6rem;
            padding:1rem 0;
            line-height: 2;
            width: 55%;
            color:var(--light-color);
        }
        
        .home-bg .home .content a{
            
            align-items: center;
            text-align: center;
            display: inline-block;
            width: 10%;
            font-size: 1.5rem;
            color: white;
            background-color: #2c3e50;
            text-decoration: none;
            border-radius: 20px;

            
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
            <h1><a href="login.php">Fresh Grocery</a></h1>
        </div>
        <div class="cont">
            <h3> <a href="profile.php">My Profile</a></h3>
            <h3> <a href="login.php">Login</a></h3>
            
            <h3> <a href="index.php">Home</a></h3>
            <h3> <a href="#Product">Product</a></h3>
            <h3> <a href="orders.php">Orders</a></h3>
            
            <h3><a href="#Contact Us">Contact Us</a> </h3>
            
        </div>
        
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search products...">
            <ion-icon name="search-outline" class="icon"></ion-icon>
            <!-- <button type="button"><i class="fas fa-search">🔍</i></button> -->
            
        </div>
        <div class="cart-icon">
            <a href="cart.php">
                
                <ion-icon name="cart-outline"  class="icon"></ion-icon>
                <span id="cartCount">0</span>
                
                <!-- <i class="fas fa-shopping-cart">🛒</i> -->
            </a>
        </div>
    </nav>
    
    <div class="home-bg">
        <section class="home">
            
            
            <div class="content" >
                <span>don't panic, go organice</span>
                <h3>Reach For A Healthier You With Organic Foods</h3>
                <!-- <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto natus culpa officia quasi, accusantium explicabo?</p> -->
                <a href="#Contact Us" class="btn">about us</a>
            </div>
            
        </section>
    </div>
    
    <main>
        
        <section class="categories">
            <h2 id="Product">Product Categories</h2>
            <div class="category-container">
                <!-- Categories will be dynamically loaded here -->
            </div>
        </section>
        
        <section class="products">
            <h2>Featured Products</h2>
            <div class="products-container">
                <!-- Products will be dynamically loaded here -->
            </div>
        </section>
        
        <section class="admin-section" id="adminPanel" style="display: none;">
            <div class="admin-header">
                <h2>Admin Panel - Orders</h2>
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
                        <!-- Orders will be dynamically loaded here -->
                    </tbody>
                </table>
                
            </div>
        </section>
        
        
        
        
        
        
        
    </main>
    
    <footer class="footer" id="Contact Us">
        <div class="footer-container">
            <div class="footer-col">
                <h3>Fresh Grocery</h3>
                <!-- <h3>FreshMart</h3> -->
                <p>Your one-stop shop for fresh groceries delivered to your doorstep. Quality products at the best prices.</p>
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
                    <li><a href="#">Fruits & Veggies</a></li>
                    <li><a href="#">Dairy Products</a></li>
                    <li><a href="#">Beverages</a></li>
                    <li><a href="#">Snacks</a></li>
                </ul>
            </div>
            
            <div class="footer-col">
                <h4>Contact Us</h4>
                <p>123 Grocery Lane, India</p>
                <p>Email: support@freshmart.com</p>
                <p>Phone: +91 98765 43210</p>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2026 FreshMart Grocery System | All Rights Reserved</p>
        </div>
        <footer>
            <p>&copy; 2025 Fresh Grocery. All rights reserved.</p>
        </footer>
        
        
    </footer>
    
        <!-- 
        <script src="/static/checkout.js"></script>
        <script src="static/script.js"></script>
        <script src="/static/scripts.js"></script>  -->
        

           
    <script src="checkout.js"></script>
    <script src="scripts.js"></script>
    <script src="scripts (1).js"></script>




</body>
</html>
