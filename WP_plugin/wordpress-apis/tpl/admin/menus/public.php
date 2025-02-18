<div>
<h1>Public View Option</h1>


<form action="" method="post">
   <label for="opt1">Option 1:</label>
   <input type="checkbox" name="opt1"
   <?php echo isset($current_public_) && intval($current_public_) > 0 ? 'checked': '' ?>>
   <label for="opt2">Option 2:</label>
   <input type="checkbox" name="opt2"
   <?php echo isset($current_public_) && intval($current_public_) > 0 ? 'checked': '' ?>>
   <button class="button primary" name="option_save">Save</button>
</form>


</div>