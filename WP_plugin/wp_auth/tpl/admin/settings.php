<div class="wrap">
      <h1>settings</h1>
      <hr style="border:2px solid green">
      <form action="" method="post">
         <table class="form-table">
               <tr valign="top">
                     <th scope="row">Activation entry</th>
                     <td>
                        <input type="checkbox" name="is_login_active" <?php 
                              echo $wp_auth_options['is_login_active'] ? 'checked' : '';
                           ?>>
                     </td>
               </tr>
               <tr valign="top">
                     <th scope="row">Activation sign UP</th>
                     <td>
                        <input type="checkbox" name="is_register_active" <?php 
                           echo $wp_auth_options['is_register_active'] ? 'checked' : '';
                        ?>>
                     </td>
               </tr>
               <tr valign="top">
                     <th scope="row">Title of entry form</th>
                     <td>
                        <input type="text" name="login_form_title" value="
        <?php echo isset($wp_auth_options['login_form_title']) ? $wp_auth_options['login_form_title'] : ''; ?>
                        ">
                     </td>
               </tr>
               <tr valign="top">
                     <th scope="row">Title of signup</th>
                     <td>
                        <input type="text" name="register_form_title" value="
        <?php echo isset($wp_auth_options['register_form_title']) ? $wp_auth_options['register_form_title'] : ''; ?>
                        ">
                     </td>
               </tr>
               <tr valign="top">
                     <th scope="row"></th>
                     <td>
                        <input type="submit" class="button" name="savaData" value="save">
                     </td>
               </tr>

         </table>
      </form>
      <hr style="border: 2px solid gold;">
</div>