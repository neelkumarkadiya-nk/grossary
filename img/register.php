
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grocery System - Register</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6; display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0; 
        }
        .form-container { 
            background: #fff; 
            padding: 30px; 
            border-radius: 8px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.1); 
            width: 350px; 
        }
        .form-container h2 { 
            text-align: center; 
            color: #2ecc71; 
            margin-bottom: 20px; 
        }
        .form-group { 
            margin-bottom: 15px; 
        }
        .form-group label { 
            display: block; 
            margin-bottom: 5px; 
            color: #333; 
        }
        .form-group input { 
            width: 100%; 
            padding: 10px; 
            border: 1px solid #ddd; 
            border-radius: 4px; 
            box-sizing: border-box; 
        }

        .user_type{
            align-items: center;
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 1px;
        }

        .btn-register { 
            width: 100%; 
            padding: 10px; 
            background-color: #2ecc71; 
            border: none; 
            color: white; 
            font-size: 16px; 
            border-radius: 4px; 
            cursor: pointer; 
        }
        .btn-register:hover { 
            background-color: #27ae60; 
        }
        .error { 
            color: red; 
            font-size: 14px; 
            margin-bottom: 10px; 
        }

    </style>
</head>
<body>

<div class="form-container">
    <h2>Register Form</h2>
    <form action="process_register.php" method="POST">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="username" required placeholder="Enter your name">
        </div>
        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" required placeholder="email@example.com">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required placeholder="Create a password">
        </div>

        <select name="user_type" class="user_type">
            <option value="user">user</option>
            <option value="admin">admin</option>
        </select>
        
        <button type="submit" name="register" class="btn-register">Create Account</button>
    </form>
</div>

</body>
</html>




