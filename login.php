<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign up / Login Form</title>
    <link rel="stylesheet" href="login.css" />
    <link
    href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet"
    />
    
    <style>
      * {
        
        padding: 0;
        
        margin: 0;
        
        box-sizing: border-box;
        
        font-family: "Jost", sans-serif;
        
      }
      
      
      
      body{
        
        display: flex;
        
        justify-content: center;
        
        align-items: center;
        
        height: 100vh;
        
        /* background: linear-gradient(to bottom, #0f0c29, #302b63, #24243e); */
        background-image: url(home-bg.jpg);
        background-repeat: no-repeat;
        background-position: center;
        
        
        
      }
      
      
      
      main{
        
        width: 350px;
        
        height: 500px;
        
        /* background-color: #302b63; */
        background-color: #54cc0acb;
        
        box-shadow: 0px 0px 50px 2px black;
        position: absolute;
        left: 10%;
        
        border-radius: 10px;
        
        overflow: hidden;
        
      }
      
      
      #chk{
        
        display: none;
        
      }
      
      
      
      .signup{
        
        width: 100%;
        
        height: 100%;
        
      }
      
      
      
      .signupForm{
        
        display: flex;
        
        justify-content: center;
        
        align-items: center;
        
        flex-direction: column;
        
      }
      
      .signupForm label{
        
        font-size: 35px;
        
        color: #fff;
        
        font-weight: bold;
        
        margin: 35px 0px;
        
        cursor: pointer;
        
        transition: .8s ease-in-out;
        
      }
      
      .user_type{
        
        width: 70%;
        
        height: 40px;
        
        padding: 5px;
        
        font-size: 19px;
        
        margin-bottom: 9px;
        
        border: none;
        
        outline: none;
        
        border-radius: 4px;
        
        background: #e0dede;
      }
      
      
      input{
        
        width: 70%;
        
        height: 40px;
        
        padding: 10px;
        
        font-size: 20px;
        
        margin-bottom: 20px;
        
        border: none;
        
        outline: none;
        
        border-radius: 4px;
        
        background: #e0dede;
        
      }
      
      
      
      button{
        
        width: 60%;
        
        padding: 7px;
        
        font-size: 18px;
        
        font-weight: 700;
        
        color: #fff;
        
        background: #573b8a;
        
        border: none;
        
        outline: none;
        
        border-radius: 5px;
        
        cursor: pointer;
        
      }

      .login-btn{

        width: 60%;
        
        padding: 7px;
        
        font-size: 18px;
        
        font-weight: 700;
        
        color: #fff;
        
        background: #573b8a;
        
        border: none;
        
        outline: none;
        
        border-radius: 5px;
        
        cursor: pointer;

      }
      
      
      
      button:hover{
        
        background: #6d44b8;
        
      }
      
      
      
      .login{
        
        width: 100%;
        
        height: 450px;
        
        background: #eee;
        
        border-radius: 60% / 10%;
        
        transform: translateY(-95px);
        
        transition: .8s ease-in-out;
        
      }
      
      
      
      .login form{
        
        display: flex;
        
        justify-content: center;
        
        align-items: center;
        
        flex-direction: column;
        
      }
      
      
      
      .login label{
        
        font-size: 35px;
        
        color: #573b8a;
        
        font-weight: bold;
        
        margin: 15px 0px 50px 0px;
        
        cursor: pointer;
        
        transform: scale(.6);
        
        transition: .8s ease-in-out;
        
      }
      

      #chk:checked~.login{
        
        transform: translateY(-415px);
        
      }
      
      
      
      #chk:checked~.login label{
        
        transform: scale(1);
        
      }
      
      #chk:checked~.signup {
        transform: translateY(-415px);
        transform: scale(1);



      }

      #chk:checked~.signup button{

        transform: scale(1);


      }
      
      #chk:checked~.signup label{
        
        transform: scale(.6);
        
      }


      /* successAlert */
      .custom-alert {
        width: 100%;
        position: absolute;
        top: 20px;
        right: -100%; /* Hidden off-screen */
        background: #27ae60;
        color: white;
        padding: 15px 25px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        transition: all 0.5s ease-in-out;
        z-index: 1001;
      }
      
      /* Slides in from the right */
      .custom-alert.show {
        right: 20px; 
      }
      
      .alert-content {
        display: flex;
        align-items: center;
        gap: 15px;
      }
      
      .alert-content h4 { margin: 0; font-size: 1.1rem; }
      .alert-content p { margin: 0; font-size: 0.9rem; opacity: 0.9; }
      .icon { font-size: 24px; }
      
    </style>
  </head>
  <body>
       
    
    
    <main>
      
      
      
      
      <!-- <form action="process_register.php" method="POST" id="fill"> -->
        
        <input type="checkbox" aria-hidden="false" id="chk">
        <div class="signup">
          <form action="process_register.php" method="POST" class="signupForm">
            
            <div id="successAlert" class="custom-alert">
              <div class="alert-content">
                <span class="icon">✅</span>
                <div class="text">
                  <h4>Registration Successful!</h4>
                  <p>Welcome to our Grocery Store.</p>
                </div>
              </div>
            </div>
           
           <label for="chk"> Sign up</label>
           <input type="text" name="username"   placeholder="Username">
           <input type="email" name="email"  placeholder="Email">
           <!-- <input type="tel" required placeholder="Phone No."> -->
           <input type="password" name="password"  placeholder="Password">
           
           <!-- <select name="user_type" class="user_type">
             <option value="user">user</option>
             <option value="admin">admin</option>
            </select> -->
            <button type="submit" name="register" class="btn-register">Registert</button>
           
            
          </form>
          
        </div>
        
        <div class="login">
          
          
          <form action="process_register.php" method="POST" id="login">
            <label for="chk">Login</label>
            <!-- <input type="email" required placeholder="Email"> -->
            <input type="text"  name="username"  id="username"  placeholder="Enter you username" required>
            
            <input type="password" name="password" id="password" required placeholder="Password" require>
            <!-- <button>Login</button> -->
            <button type="submit" name="login" class="login-btn">Login</button>
            
            <p>IF Your Are New,Please Sign up First </p>
            
            
          </form>
          
        </div>
        
      <!-- </form> -->
      
    </main>
      <script>
        
        function registerUser(event) {
          event.preventDefault();
          
          
          // 1. Get the username from the form
          const username = document.getElementById('username').value;
          // const userType = document.getElementById('user_type').value;
          
          // 2. Save user data (as we discussed before)
          const userData = {
            username: username,
            // role: userType,
            isLoggedIn: true
          };
          localStorage.setItem('currentUser', JSON.stringify(userData));
          
          // 3. SHOW THE ALERT
          alert("Registration Successful! \nWelcome, " + username);
          
          // 4. Redirect to the Shop
          window.location.href = '#login';
        }
        
        let alertTimeout; // Variable to store the timer
        function triggerSuccessAlert() {
          const alertBox = document.getElementById('successAlert');
          
          if (alertBox ) {
            alertBox.classList.add('show');
            
            // Start the 10-second timer
            alertTimeout = setTimeout(() => {
              closeAlert(); // Automatically close after 10s // Then redirect
            }, 5000); 
          }
        }
        
        // Function to close the alert manually
        function closeAlert() {
          const alertBox = document.getElementById('successAlert');
          if (alertBox) {
            alertBox.classList.remove('show');
            
            // Stop the timer so it doesn't try to close it again or redirect early
            clearTimeout(alertTimeout);
            
            window.history.replaceState({}, document.title, window.location.pathname);

          }
        } 
        
        triggerSuccessAlert();
      </script>
  </body>
</html>