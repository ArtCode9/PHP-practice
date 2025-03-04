<div class="wrap">
   <h1>Edit user Info</h1>

   <form action="" method="post">
      <table class="form-table">
         <tr valign="top">
            <th scope="row">Mobile</th>
            <td>
               <input type="text" name="mobile" value="<?php echo $mobile; ?>">
            </td>
         </tr>

         <tr valign="top">
            <th scope="row">Wallet</th>
            <td>
               <input type="text" name="wallet" value="<?php echo $wallet ?>">
            </td>
         </tr>

         <tr valign="top">
            <th scope="row"></th>
            <td>
               <input type="submit" name="saveUserInfo" class="button primary">
            </td>
         </tr>
      </table>
   </form>


</div>