<div>
   <h1>This is form section</h1>
   <hr>
   <?php var_dump($user_data); ?>
   <hr style="border: 3px solid black;">
   
   
   <form action="" method="post">
         <label>Set your feeling</label><br>
         <label for="anger">Anger</label>
         <input type="checkbox" name="anger"
         <?php echo isset($option) && intval($option) > 0 ? 'checked' : '' ?>>
         <label for="happy">Happy</label>
         <input type="checkbox" name="happy" 
         <?php echo isset($option) && intval($option) > 0 ? 'checked' : '' ?>>
         <label for="shy">Shy</label>
         <input type="checkbox" name="shy"
         <?php echo isset($option) && intval($option) > 0 ? 'checked' : '' ?>>
         <hr style="border: 3px solid blue">
         <button name="save_feeling" class="button primary">Active Feeling</button>
   </form>


</div>