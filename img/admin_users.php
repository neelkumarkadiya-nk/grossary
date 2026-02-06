<?php

use LDAP\Result;

session_start();
include 'process_redister.php';


$admin_id = $_SESSION['admin'];

$select_users = $conn->prepare("SELECT * FROM `users` WHERE admin = '$admin_id");
      // $select_users->execute([$admin_id]);
      $result = mysqli_query($conn, $select_users);
      
      if(!isset($admin_id))
         {
         header('location:admin_users.php');
         exit();
      }

// if(isset($_POST['delete'])){
//    $delete_id = $_POST['delete'];
//    $delete_users = $conn->prepare("DELETE FROM `users` WHERE id = 'id'");
//    $delete_users->execute([$delete_id]);
//    header('location:login.php');
//    exit();
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User Accounts</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   
   <style>
      :root {
         --orange: #e67e22;
         --red: #e74c3c;
         --black: #333;
         --white: #fff;
         --light-bg: #f6f6f6;
         --border: 1px solid #222;
         --box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
      }

      * {
         font-family: 'Poppins', sans-serif;
         margin: 0; padding: 0;
         box-sizing: border-box;
         outline: none; border: none;
         text-decoration: none;
      }

      body { background-color: var(--light-bg); }

      .user-accounts { padding: 2rem; max-width: 1200px; margin: 0 auto; }

      .title {
         text-align: center;
         margin-bottom: 2rem;
         text-transform: uppercase;
         color: var(--black);
         font-size: 2.5rem;
      }

      .box-container {
         display: grid;
         grid-template-columns: repeat(auto-fit, 33rem);
         gap: 2rem;
         justify-content: center;
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

      .box img {
         height: 15rem;
         width: 15rem;
         border-radius: 50%;
         object-fit: cover;
         margin-bottom: 1rem;
         border: var(--border);
      }

      .box p {
         line-height: 1.5;
         padding: .5rem 0;
         font-size: 1.8rem;
         color: var(--black);
      }

      .box p span { color: var(--orange); }

      /* The Red Delete Button from your screenshot */
      .delete-btn {
         display: block;
         width: 100%;
         margin-top: 1rem;
         border-radius: .5rem;
         color: var(--white);
         font-size: 1.8rem;
         padding: 1rem 3rem;
         cursor: pointer;
         text-transform: capitalize;
         background-color: var(--red);
         transition: .2s linear;
      }

      .delete-btn:hover { background-color: var(--black); }

      .empty {
         padding: 1.5rem;
         text-align: center;
         width: 100%;
         font-size: 2rem;
         color: var(--red);
         border: var(--border);
         background-color: var(--white);
      }
   </style>
</head>
<body>


<section class="user-accounts">

   <h1 class="title">User Accounts</h1>

   <div class="box-container">

   <?php
      
      
      if($select_users->rowCount() > 0){
         while($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)){
         }
      }else{
         echo '<p class="empty">no accounts available!</p>';
      }
         ?>
      <div class="box">
         <img src="uploaded_img/<?= $fetch_users['image']; ?>" alt="user profile">
         <p> user id : <span><?= $fetch_users['id']; ?></span> </p>
         <p> username : <span><?= $fetch_users['name']; ?></span> </p>
         <p> email : <span><?= $fetch_users['email']; ?></span> </p>
         <p> user type : <span style="color:<?php if($fetch_users['user_type'] == 'admin'){ echo 'var(--orange)'; } ?>"><?= $fetch_users['user_type']; ?></span> </p>
         <a href="admin_users.php?delete=<?= $fetch_users['id']; ?>" onclick="return confirm('delete this user?');" class="delete-btn">Delete</a>
      </div>

   </div>

</section>

<script src="js/admin_script.js"></script>

</body>
</html>