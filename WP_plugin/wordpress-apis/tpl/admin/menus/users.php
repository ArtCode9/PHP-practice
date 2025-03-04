<div class="wrap">
      <h1>VIP users</h1>

      <table class="widefat">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>email</th>
                  <th>Name</th>
               </tr>
            </thead>
            <tbody>
                     <?php foreach($users as $user): ?>
                           <tr>
                              <td><?php echo $user->ID ?></td>
                              <td><?php echo $user->user_email ?></td>
                              <td><?php echo $user->display_name ?></td>
                           </tr>
                     <?php endforeach ?>
            </tbody>
      </table>

</div>