<?php
session_start(); 
include "process_register.php";

if (isset($_POST['login'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);

        if ($row['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $row['name'];
            header('location: admin.php');
            exit(); 
            
        } elseif ($row['user_type'] == 'user') {
            $_SESSION['user_name'] = $row['name'];
            header('location: index.php');
            exit();
        }
    } else {
        $error[] = 'incorrect email or password!';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Fresh Grocery</title>
    <link rel="stylesheet" href="styles.css">
   
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* Reset and base styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    font-family: Arial, sans-serif;
    line-height: 1.6;
    background-color: #f4f4f4;
}
#box{  
    height: 100%;
    width: 420px;
    background-color: rgb(208, 208, 208);
    color: rgb(246, 250, 248);
    border:5px solid ;
    border-radius: 20px;
    padding: 35px ;
    margin: 35px;
    backdrop-filter: blur(5px);
    box-shadow: 25px 25px 28px rgb(36, 36, 36);
    position: relative;
    

}

.navbar {
    width: 100%;
    background-color: #2ecc71;
    padding: 1rem 5rem;
    display: flex;
    justify-content: space-between;
    border-radius:10px;
  
}

.logo h1 {
    color: white;
    font-size: 1.5rem;
}

.logo a {
    text-decoration: none;
    color: white;
}

.login-container{
    align-items: center;
    padding: 5px;
    /* margin: 5px; */
    height: 100%;
    width: 100%;
}
 h2{
    display: flex;
    justify-content: center;
    align-items: center;
   


}
.form-group{
    margin-top: 10px;
}
.form-group input{
    height: 20px;
    border-radius: 10px;
    padding: 15px;
    color:black;
}
.form-group #username{
    height: 30px;
    width: 100%;

}

.form-group #password{
    height: 30px;
    width: 100%;

}
.form-group a{
    margin: 10px;
    height: 30px;
    width: 100%;

}

.login-btn{
    width: 100%;
    height: 45px;   
    border-radius: 10px;
    background-color: #2ecc71; ;
}
.login-btn:hover{
    background-color: rgba(82, 82, 82, 1);
    color: white;

}

#fg{
    background-color: #b5b5b5;
    color: rgb(0, 0, 0);
    text-align: center;
    /* padding: 5px; */
    position: absolute;
    bottom: 1%;
    left: 9%;
    transform: translate(50% ,-50%);
}

.reg{
    padding: 10px;
    text-align: center;
    color: black;
}
.reg p{
    text-align: center;
    color:black;
}
    </style>

</head>
<body>
    
    <?php if (isset($error)) { ?>
        <p class="error"><?php echo $error; ?></p>
        <?php } ?>
        
        <form method="post">
            <div id="box">
                
                <nav class="navbar">
                    <div class="logo">
                        <h1><a href="index.php">Fresh Grocery</a></h1>
                    </div>
                </nav>
                
                <main>
                    <h2 id="h2">Login </h2>
                    <section class="login-container">
                        <form id="loginForm" class="login-form">
                            <div>
                                
                                <div class="form-group">
                                    <!-- <label for="username">Username</label> -->
                                    <input type="text" id="username" placeholder="Enter you username" required>
                                </div>
                                <div class="form-group">
                                    <!-- <label for="password">Password</label> -->
                                    <input type="password" id="password" placeholder="Enter you password" required>
                                    <a href="#">Forgot password</a>
                                </div>
                            </div>
                            
                            <div class="error-message" id="loginError"></div>
                            <button type="submit" name="login" class="login-btn">Login</button>

                            <div class="reg">
                                
                                <p>IF Your Are New,Please</p>
                                <!-- <a href="process_register.php">Register First </a> -->
                                <a href="register.php">Register First</a>
                                <p id="fg">Welcom Fresh Grocery.</p>
                            </div>

                        </form>
                    </section>
                </main>
                    
            </div>
            
            
        </form>
        
                
                
    <!-- <script src="login.js/"></script> -->
    <script src="scripts.js"></script>
</body>
</html> 