<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign in & Sign up Form</title>
    <link rel="stylesheet" href="signup.css" />
  </head>
  <body>
  
    <main>
      <div class="box">
        <div class="inner-box">
          <div class="forms-wrap">
            <form action="login.php" class="sign-in-form" method="post">
              <div class="logo">
                <img src="./img/logo.png" alt="connect with us" />
                <h4>Connect with us</h4>
              </div>
             
              <div class="heading">
                <h2>Welcome Back</h2>
                <h6>Not registred yet?</h6>
                <a href="#" class="toggle">Sign in</a>
              </div>

              <div class="actual-form">
                <div class="input-wrap">
                  <input type="email" minlength="4" name="email"   class="input-field" autocomplete="off" required/>
                  <label>Email</label>
                </div>

                <div class="input-wrap">
                  <input type="password" minlength="4" name="pswd" class="input-field" autocomplete="off" required />
                  <label>Password</label>
                </div>

                <input type="submit" name="submit" value="login" class="sign-btn" />

                <p class="text">
                  Forgotten your password or you login datails?
                  <a href="#">Get help</a> signing in
                </p>
              </div>
            </form>

            <form action="connect.php" class="sign-up-form" method="POST">
              <div class="logo">
                <img src="./img/logo.png" alt="easyclass" />
                <h4>Connect with us</h4>
              </div>

              <div class="heading">
                <h2>Get Started</h2>
                <h6>Already have an account?</h6>
                <a href="#" class="toggle">login</a>
              </div>

              <div class="actual-form">
                <div class="input-wrap">
                  <input type="text" minlength="4"name="firstname" class="input-field" autocomplete="off" required/>
                  <label>Name</label>
                </div>

                <div class="input-wrap">
                  <input type="email" name="email" class="input-field" autocomplete="off" required />
                  <label>Email</label>
                </div>

                <div class="input-wrap">
                  <input type="password" minlength="4" name="passwor" class="input-field" autocomplete="off" required />
                  <label>Password</label>
                </div>

                <input type="submit" value="Sign Up" class="sign-btn" />

                <p class="text">
                  By signing up, I agree to the
                  <a href="#">Terms of Services</a> and
                  <a href="#">Privacy Policy</a>
                </p>
              </div>
            </form>
          </div>

          <div class="carousel">
            <div class="images-wrapper">
             <!---<img src="./img/delulu.jpg" class="delulu img-1 show" alt="" />
              <img src="./img/aesth.jpg" class=" aesth img-2 show" alt="" />-->
             <img src="image1.jpg" class="image img-1 show" alt="" />
              <img src="image1.jpg" class="image img-1 show" alt="" />
              <!--<img src="./img/image3.png" class="image img-3" alt="" />-->
            </div>

            <div class="text-slider">
              <div class="text-wrap">
               <div class="text-group">
                 <h2>Innovate with style</h2>
                  <h2>Customize as you like</h2>
                 <!-- <h2>Invite students to your class</h2>-->
                </div>
              </div>

              <div class="bullets">
                <span class="active" data-value="1"></span>
                <span data-value="1"></span>
               <!-- <span data-value="3"></span>-->
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Javascript file -->

    <script src="signup.js"></script>
  </body>
</html>
</body>
</html>