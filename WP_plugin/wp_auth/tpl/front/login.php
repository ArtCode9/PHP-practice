<div class="auth-wrapper">
      
      <div class="alert" style="display:none;">
               
      </div>

      <div class="login-wrapper">
            <?php if(isset($wp_auth_options['login_form_title'])) : ?>
        <h2> <?php echo $wp_auth_options['login_form_title']; ?></h2> <!-- this come from setting plugin  -->
            <?php endif; ?>
            <form action="" method="post" id="loginForm">

                  <div class="form-row">
                        <label for="user-email">Email :</label>
                        <input type="email" name="user-email" id="user-email">
                  </div>

                  <div class="form-row">
                        <label for="user-password">Password :</label>
                        <input type="password" name="user-password" id="user-password">
                  </div>

                  <div class="form-row">
                        <button name="submitLogin">Enter</button>
                  </div>

            </form>
      </div>
</div>