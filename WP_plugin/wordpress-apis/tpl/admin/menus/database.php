<div class="warp">
   
    <h1>List of information</h1>
    <a href="<?php echo add_query_arg(['action' => 'add']) ?>">add person</a> 

<!-- here in this table we get data from database and show them in a table -->
    <table class="widefat">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>mobile</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
                <?php foreach($samples as $sample): ?>
                    <tr>
                        <td><?php echo $sample->id; ?></td>
                        <td><?php echo $sample->firstName; ?></td>
                        <td><?php echo $sample->lastName; ?></td>
                        <td><?php echo $sample->mobile; ?></td>
                        <td> <!-- This is delete section -->
                            <a href="<?php echo add_query_arg(['action' => 'delete', 'item' => $sample->id]) ?>">delete</a>
                        </td>
                    </tr>
                <?php endforeach ?>
        </tbody>
    </table>
    
</div>