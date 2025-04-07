<div class="wrap wp-phonebook-admin">
    <h1>Phone Book</h1>
    
    <div class="wp-phonebook-form">
    <h2><?php echo $edit_contact ? 'Edit contact' : 'Add new contact'; ?></h2>
    <form method="post">

            <?php if ($edit_contact): ?>
                <input type="hidden" name="contact_id" value="<?php echo $edit_contact->id; ?>">
            <?php endif; ?>

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required
                value="<?php echo $edit_contact ? esc_attr($edit_contact->name) : ''; ?>">
                >
            </div>
            
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required
                value="<?php echo $edit_contact ? esc_attr($edit_contact->phone) : ''; ?>">
                >
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email"
                value="<?php echo $edit_contact ? esc_attr($edit_contact->email) : ''; ?>">
                >
            </div>
            
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea id="address" name="address">
                <?php 
                    echo $edit_contact ? esc_textarea($edit_contact->address) : ''; 
                ?>
                </textarea>
            </div>
            
            <?php if ($edit_contact): ?>
                <input type="submit" name="update_contact" class="button button-primary" value="update contact">
                <a href="<?php echo remove_query_arg('edit_contact'); ?>" class="button">Cancel</a>
            <?php else: ?>
                <input type="submit" name="add_contact" class="button button-primary" value="Save contact">
            <?php endif; ?>       
         </form>
    </div>
    
    <div class="wp-phonebook-list">
        <h2>Contacts</h2>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Tools</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><?php echo esc_html($contact->name); ?></td>
                    <td><?php echo esc_html($contact->phone); ?></td>
                    <td><?php echo esc_html($contact->email); ?></td>
                    <td><?php echo esc_html($contact->address); ?></td>
                    <td>
                    <a href="<?php echo add_query_arg('edit_contact', $contact->id); ?>" 
                           class="button button-secondary">Edit</a>
                        <a href="<?php echo add_query_arg('delete_contact', $contact->id); ?>" 
                           class="button button-danger" 
                           onclick="return confirm('Are You sure delete it ?')">Delete</a>                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>