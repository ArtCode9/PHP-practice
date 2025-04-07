<div class="wrap wp-phonebook-admin">
    <h1>Phone Book</h1>
    
    <div class="wp-phonebook-form">
        <h2>Add new contact</h2>
        <form method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
            </div>
            
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea id="address" name="address"></textarea>
            </div>
            
            <input type="submit" name="add_contact" class="button button-primary" value="save contact">
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
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><?php echo esc_html($contact->name); ?></td>
                    <td><?php echo esc_html($contact->phone); ?></td>
                    <td><?php echo esc_html($contact->email); ?></td>
                    <td>
                        <a href="?page=wp-phonebook&delete_contact=<?php echo $contact->id; ?>" class="button button-danger">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>