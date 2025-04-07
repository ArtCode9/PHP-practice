<?php
/* 
      Plugin Name: Phone-book
      Plugin URI: www.artcode9.com
      Description: This is simple Phonebook for WP
      Version: 1.0.0
      Author: ArtCode
      Author: www.artcode9.com
      Text Domain: wp-phonebook
*/


defined('ABSPATH') || exit;

// define constant
define('WP_PHONEBOOK_VERSION', '1.0.0');
define('WP_PHONEBOOK_PATH', plugin_dir_path(__FILE__));
define('WP_PHONEBOOK_URL' , plugin_dir_url(__FILE__));
define('WP_PHONEBOOK_BASENAME', plugin_basename(__FILE__));

// load main file 
require_once WP_PHONEBOOK_PATH . 'includes/class-phonebook.php';

function wp_phonebook_init() {
      $phonebook = new PhoneBook();
      $phonebook->run();
}
add_action('plugins_loaded', 'wp_phonebook_init');



