<div class="wrap">
   <h1>First plugin Setting</h1>
   <hr style="border: 3px solid green;">
   <?php
      // this user data come from menu.php in function section
      var_dump($user_data);
   ?>

   <br><br><hr style="border: 3px solid orange;">
   <form action="" method="post">
      <label for="mycheck">
      
         <input type="checkbox" id="mycheck" name="mycheck">
         Active Option
      
      </label>
      
      <button class="button primary" type="submit" name="saveSetting">Save Changes</button>
      <!-- the class belong to button is css pre-define by wordpress like bootstrap -->
   </form>

</div>