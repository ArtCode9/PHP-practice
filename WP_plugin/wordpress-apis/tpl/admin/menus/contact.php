<div class="wrap">

<h1>This is contact Note</h1>
<hr style="border:3px solid green">
<a href="<?php echo add_query_arg(['action' => 'add']) ?>">add person</a> 


   <table class="widefat">
         <thead>
            <tr>
               <th>ID</th>
               <th>Name</th>
               <th>Family</th>
               <th>Mobile</th>
               <th>Address</th>
               <th>Delete</th>
            
            </tr>
         </thead>
         <tbody>
               <?php foreach($contacts as $con):?>
                  <tr>
                     <td><?php echo $con->id; ?></td>
                     <td><?php echo $con->name; ?></td>
                     <td><?php echo $con->family; ?></td>
                     <td><?php echo $con->mobile; ?></td>
                     <td><?php echo $con->address; ?></td>  
               <td>
                  <a href="<?php echo add_query_arg(['action' => 'delete', 'id' => $con->id]) ?>">
                    <span class="dashicons dashicons-table-row-delete"></span>
                  </a>
               </td>
                  </tr>
               <?php endforeach ?>
         </tbody>
   </table>
</div>

