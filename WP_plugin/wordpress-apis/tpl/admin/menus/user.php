<div>
   <h1>User is ARTCODE9</h1>

   
   <hr style="border: 3px solid red;">

   <form action="" method="post">
      <label for="vip_mode">Vip mode</label>
      <input type="checkbox" name="vip_mode"
      <?php echo isset($current_VIP) && intval($current_VIP) > 0 ? 'checked' : '' ?>>
      <button class="button primary" type="submit" name="saveVip">VIP</button>
   </form>

   <hr style="border: 3px solid green;">


</div>