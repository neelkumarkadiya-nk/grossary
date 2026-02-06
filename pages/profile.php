<?php
// Database connection details
// include "process_register.php";
// Handle Delete Logic
// if(isset($_POST['delete'])){
//    $delete_id = $_POST['delete'];
//    $delete_user = $conn->prepare("DELETE FROM `users` WHERE id='$id");
//    $delete_user->execute([$delete_id]);
//    header('location:index.php'); // Refresh page after delete
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Accounts</title>
    <link rel="stylesheet" href="styles.css">
    
    <link rel="stylesheet" href="style.css">
    <style>
        :root {
            --red: #e74c3c;
            --black: #333;
            --white: #fff;
            --light-bg: #f5f5f5;
            --border: 1px solid rgba(0,0,0,.1);
            --box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
        }
        
        body {
            background-color: var(--light-bg);
            font-family: 'Arial', sans-serif;
            margin: 0; padding: 0;
        }
        
        .heading {
            text-align: center;
            margin: 2rem 0;
            font-size: 2.5rem;
            color: var(--black);
            text-transform: uppercase;
        }
        
        .box-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, 33rem);
            justify-content: center;
            gap: 1.5rem;
            align-items: flex-start;
        }
        
        .box {
            background-color: var(--white);
            padding: 2rem;
            border: var(--border);
            box-shadow: var(--box-shadow);
            border-radius: .5rem;
            text-align: center;
        }
        .box .icon{
            height: 100%;
            width: 100%;


            
        }
        
        .box p {
            margin-bottom: 1rem;
            font-size: 1.2rem;
            color: var(--black);
        }
        
        .box p span {
            color: #666;
        }
        
        .delete-btn {
            display: block;
            width: 100%;
            margin-top: 1rem;
            border-radius: .5rem;
            padding: 1rem;
            font-size: 1.3rem;
            background-color: var(--red);
            color: var(--white);
            text-decoration: none;
            transition: .2s linear;
        }
        
        .delete-btn:hover {
            background-color: var(--black);
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
            <h3> <a href="index.php">Product</a></h3>
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
    
    
    <section class="accounts">
        <h1 class="heading">USER ACCOUNTS</h1>
        
        <div class="box-container">
            <?php
      // The logic from your screenshot
    //   $select_users = $conn->prepare("SELECT * FROM `users` ");
    //   $select_users->execute();
      
    //   if($select_users->rowCount() > 0){
    //       while($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)){ 
    //     }
    // } else {
    //     echo '<p class="empty">No accounts available!</p>';
    // }
    
    ?>
      <div class="box">
        <div class="icon">

            <ion-icon name="person-circle-outline"></ion-icon>
        </div>
          <p> user id : <span><?= $fetch_users['id']; ?></span> </p>
          <p> username : <span><?= $fetch_users['name']; ?></span> </p>
          <p> email : <span><?= $fetch_users['email']; ?></span> </p>
          <p> user type : <span style="color:<?php if($fetch_users['user_type'] == 'admin'){ echo 'orange'; } ?>"><?= $fetch_users['user_type']; ?></span> </p>
          
          <a href="users.php?delete=<?= $fetch_users['id']; ?>" 
          onclick="return confirm('Delete this user?');" 
          class="delete-btn">Delete</a>
        </div>
        
    </section>
</div>
<script src="scripts.js">
    // This runs when the Delete button is clicked
    onclick="return confirm('Delete this user?');"
</script>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>