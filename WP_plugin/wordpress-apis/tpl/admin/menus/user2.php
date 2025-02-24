<div>
      <h1>Batman Section Operator</h1>

      <hr style="border: 3px solid black;">

      <form action="" method="post">
         <label for="batman_car">Batman and joker</label>
         <input type="checkbox" name="batman_car" 
         <?php echo isset($batman_fly) && intval($batman_fly) > 0 ? 'checked' : '' ?>>
         <button type="submit" name="call_batman" class="button primary">Call Batman</button>
      </form>

</div>