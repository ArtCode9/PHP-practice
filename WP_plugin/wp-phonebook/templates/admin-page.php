<div class="wrap wp-phonebook-admin">
    <div class="phonebook-header">
        <h1><i class="dashicons dashicons-phone"></i> Phone Book </h1>
    </div>
    
    <div class="phonebook-card">
        <div class="card-header">
            <i class="dashicons dashicons-plus"></i>
            <?php echo $edit_contact ? 'Edit contact' : 'Add new Contact'; ?>
        </div>
        <div class="card-body">
            <form method="post" class="form-material">
                <?php if ($edit_contact): ?>
                    <input type="hidden" name="contact_id" value="<?php echo $edit_contact->id; ?>">
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control" required 
                           value="<?php echo $edit_contact ? esc_attr($edit_contact->name) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" class="form-control" required
                           value="<?php echo $edit_contact ? esc_attr($edit_contact->phone) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control"
                           value="<?php echo $edit_contact ? esc_attr($edit_contact->email) : ''; ?>">
                </div>
                
                <div class="form-group" style="grid-column: span 2">
                    <label for="address">Adress</label>
                    <textarea id="address" name="address" class="form-control"><?php 
                        echo $edit_contact ? esc_textarea($edit_contact->address) : ''; 
                    ?></textarea>
                </div>
                
                <div class="form-group" style="grid-column: span 2">
                    <div class="btn-group">
                        <?php if ($edit_contact): ?>
                            <button type="submit" name="update_contact" class="btn btn-primary">
                                <i class="dashicons dashicons-update"></i> Update 
                            </button>
                            <a href="<?php echo remove_query_arg('edit_contact'); ?>" class="btn btn-secondary">
                                <i class="dashicons dashicons-no"></i> Cancel
                            </a>
                        <?php else: ?>
                            <button type="submit" name="add_contact" class="btn btn-primary">
                                <i class="dashicons dashicons-plus"></i> Save Contact 
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="phonebook-card">
        <div class="card-header">
            <i class="dashicons dashicons-groups"></i>
             List of Contacts
        </div>
        <div class="card-body">
            <?php if (!empty($contacts)): ?>
                <table class="contacts-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Adress</th>
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
                                <div class="contact-actions">
                                    <a href="<?php echo add_query_arg('edit_contact', $contact->id); ?>" 
                                       class="btn btn-secondary" style="padding: 5px 10px;">
                                        <i class="dashicons dashicons-edit"></i>
                                    </a>
                                    <a href="<?php echo add_query_arg('delete_contact', $contact->id); ?>" 
                                       class="btn btn-danger" style="padding: 5px 10px;"
                                       onclick="return confirm('آیا از حذف این مخاطب مطمئن هستید؟')">
                                        <i class="dashicons dashicons-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <i class="dashicons dashicons-warning"></i>
                    <p>هنوز هیچ مخاطبی ثبت نشده است</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>