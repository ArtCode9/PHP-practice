<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login & register</title>
   <link rel="stylesheet" href="style.css">
</head>
<body>

      <div class="container" id="signup" style="display: none;"><!---->
            <h1 class="form-title">Register</h1>

            <form action="register.php" method="post">
                  <div class="input-group">
                        <label>First Name</label>
                        <input type="text" name="fname" id="fname" placeholder="First Name" required>
                  </div>

                  <div class="input-group">
                        <label>Last Name</label>
                        <input type="text" name="lname" id="lname" placeholder="Last Name" required>
                  </div>

                  <div class="input-group">
                        <label>Email</label>
                        <input type="email" name="email" id="email" placeholder="Email" required>
                  </div>

                  <div class="input-group">
                        <label>Password</label>
                        <input type="password" name="password" id="password" placeholder="Password" required>
                  </div>
                  <input type="submit" class="btn" name="signup" value="signup">
            </form>
            <p class="or">
            ----------or--------------
            </p>
            <div class="icons">
                  <i>G</i><br>
                  <i>F</i>
            </div>

            <div class="links">
                  <p>Already Have Account?</p>
                  <button class="signInButton">Sign--In</button>
            </div>
      </div>

      <div class="container" id="signIn">
            <h1 class="form-title">😀Sign In</h1>
            <form method="post" action="register.php">
              <div class="input-group">
                  <label for="email">Email</label>
                  <input type="email" name="email" id="email" placeholder="Email" required>
              </div>
              <div class="input-group">
                  <label for="password">Password</label>              
                  <input type="password" name="password" id="password" placeholder="Password" required>
              </div>
              <p class="recover">
                <a href="#">Recover Password</a>
              </p>
             <input type="submit" class="btn" value="Sign In" name="signIn">
            </form>
            <p class="or">
              ----------or--------
            </p>
            <div class="icons">
              <i>G</i=>
              <i>F</i>
            </div>
            <div class="links">
              <p>Don't have account yet?</p>
              <button id="signUpButton">Sign Up</button>
            </div>
          </div>
          <script src="script.js"></script>
    


</body>
</html>