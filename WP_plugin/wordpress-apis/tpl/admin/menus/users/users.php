<div class="wrap">
      <h1>VIP users</h1>

      <table class="widefat">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>email</th>
                  <th>Name</th>
                  <th>Mobile number</th>
                  <th>wallet</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
                     <?php foreach($users as $user): ?>
                           <tr>
                              <td><?php echo $user->ID ?></td>
                              <td><?php echo $user->user_email ?></td>
                              <td><?php echo $user->display_name ?></td>
                              <td><?php echo get_user_meta($user->ID, 'mobile', true)?></td> <!--👈this line get metadata from base-->
                              <td><?php echo get_user_meta($user->ID, 'wallet', true)?></td>  
                              <!--we can use👆 number_format(); for make number like 122/000 T -->
                              <td>
                                 <a href="<?php echo add_query_arg(['action' => 'edit', 'id' => $user->ID]) ?>">
                                    <span class="dashicons dashicons-edit"></span>               
                                 </a>
                              </td>
                           </tr>
                     <?php endforeach ?>
            </tbody>
      </table>

</div>