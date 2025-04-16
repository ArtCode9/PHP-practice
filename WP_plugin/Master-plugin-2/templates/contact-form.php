<div class="wp-master-contact-form-container">
    <form id="wp-master-contact-form" class="wp-master-form" method="post">
        <div class="form-group">
            <label for="wp-master-name"><?php _e('Your Name', 'wp-master-plugin'); ?> *</label>
            <input type="text" id="wp-master-name" name="name" required>
        </div>
        
        <div class="form-group">
            <label for="wp-master-email"><?php _e('Email Address', 'wp-master-plugin'); ?> *</label>
            <input type="email" id="wp-master-email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="wp-master-message"><?php _e('Your Message', 'wp-master-plugin'); ?> *</label>
            <textarea id="wp-master-message" name="message" rows="5" required></textarea>
        </div>
        
        <input type="hidden" name="action" value="wp_master_submit_contact">
        
        <button type="submit" class="submit-button">
            <?php _e('Send Message', 'wp-master-plugin'); ?>
        </button>
        
        <div class="form-messages"></div>
    </form>
</div>