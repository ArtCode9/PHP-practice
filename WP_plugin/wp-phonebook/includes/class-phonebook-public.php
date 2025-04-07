<?php
if (!defined('ABSPATH')) {
    exit;
}

class PhoneBook_Public {
    public function enqueue_public_assets() {
        if (is_page('phonebook')) {
            wp_enqueue_style(
                'wp-phonebook-public',
                WP_PHONEBOOK_URL . 'assets/css/public.css',
                array(),
                WP_PHONEBOOK_VERSION
            );
            
            wp_enqueue_script(
                'wp-phonebook-public',
                WP_PHONEBOOK_URL . 'assets/js/public.js',
                array('jquery'),
                WP_PHONEBOOK_VERSION,
                true
            );
        }
    }
    
    public static function display_phonebook($atts) {
        $db = new PhoneBook_DB();
        $contacts = $db->get_contacts();
        
        ob_start();
        include WP_PHONEBOOK_PATH . 'templates/public-display.php';
        return ob_get_clean();
    }
}


add_shortcode('wp_phonebook', array('PhoneBook_Public', 'display_phonebook'));