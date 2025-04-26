<?php
/* 
   Plugin Name: Ticket System
   Plugin URI: www.artcode9.com
   Description: Ticket problem sending and response
   Version: 2.0.0
   Author: Vida Rajabi & ArtCode9
   Author URI: www.artcode9.com
   Tex Domain: plug-ticket
   Domain Path: /languages/
*/

defined('ABSPATH') || exit;



define('PLUG_TICKET_VERSION' , '1.0.0');
define('PLUG_TICKET_DIR' , plugin_dir_path(__FILE__));
define('PLUG_TICKET_URL' , plugin_dir_url(__FILE__));



require_once PLUG_TICKET_DIR . 'includes/functions.php';
require_once PLUG_TICKET_DIR . 'includes/short.php';
require_once PLUG_TICKET_DIR . 'includes/admin.php';
require_once PLUG_TICKET_DIR . 'includes/ajax-handlers.php';


register_activation_hook(__FILE__ , 'create_support_ticket_table2');

add_action('wp_ajax_mark_ticket_viewed', 'mark_ticket_viewed_callback');
add_action('wp_ajax_get_new_tickets_count', 'get_new_tickets_count_callback');



// register form [registration_form]
add_shortcode('registration_form' , 'registration_form_shortcode2');
// ticket form [support_ticket_form]
add_shortcode('support_ticket_form', 'support_ticket_form_shortcode');

add_shortcode('tracking_form', 'tracking_form_shortcode');



// add menu
add_action('admin_menu', 'add_ticket_menu');



// ایمن‌سازی با اضافه کردن محدودیت برای بارگذاری فایل‌ها
function secure_file_uploads() {
   // Limit file sizes (in bytes)
   @ini_set('upload_max_filesize', '5M');
}
add_action('init', 'secure_file_uploads');

// افزودن فیلد برای نشان دادن وضعیت تیکت در فرم
function add_status_field_in_ticket_form() {
   echo '<input type="hidden" name="ticket_status" value="new">';
}
add_action('support_ticket_form', 'add_status_field_in_ticket_form');


add_action('admin_enqueue_scripts', 'add_pop_up_script');


// ========================================================================
//                this is a mind map of plugin

/* 
   Ticket System Plugin (v2.0.0)
├── Core Configuration
│   ├── Constants (PLUG_TICKET_VERSION, DIR, URL)
│   ├── Security (ABSPATH check, file upload limits)
│   └── Activation Hook (create_support_ticket_table2)
│
├── Database
│   ├── Table Structure (_support_tickets)
│   │   ├── Fields (id, tracking_code, user_id, ip_address, etc.)
│   │   └── Indexes (PRIMARY KEY on id)
│   └── Table Creation/Update (dbDelta)
│
├── Admin Interface
│   ├── Menu System
│   │   ├── Main Menu (with notification bubble)
│   │   ├── Submenus (New, Active, Closed tickets)
│   │   └── Access Control (manage_options)
│   ├── Ticket Display
│   │   ├── Filtering (by status)
│   │   ├── Table Layout
│   │   └── Status Update Form
│   └── Popup System
│       ├── Message Viewing
│       ├── Response Form
│       └── AJAX Interactions
│
├── Frontend Components
│   ├── Shortcodes
│   │   ├── [registration_form]
│   │   ├── [support_ticket_form]
│   │   └── [tracking_form]
│   ├── Form Handlers
│   │   ├── User Registration
│   │   ├── Ticket Submission
│   │   └── Ticket Tracking
│   └── Styling
│       ├── Form CSS
│       └── Responsive Design
│
├── AJAX Functionality
│   ├── mark_ticket_viewed
│   └── get_new_tickets_count
│
├── Security Features
│   ├── Input Sanitization
│   ├── File Upload Restrictions
│   ├── CAPTCHA (commented)
│   └── Nonce Verification (needed)
│
└── Assets
    ├── CSS (admin-ui.css)
    │   ├── Table Styling
    │   ├── Popup Design
    │   └── Notification Indicators
    └── JavaScript (script.js)
        ├── Modal Functions
        └── AJAX Handlers
*/


//  =======================================================
//   recreate the mind map with full map

/* 
   Ticket System Plugin (v2.0.0)
├── 1. CORE CONFIGURATION
│   ├── 1.1 Constants
│   │   ├── PLUG_TICKET_VERSION = '1.0.0'
│   │   ├── PLUG_TICKET_DIR = plugin_dir_path(__FILE__)
│   │   └── PLUG_TICKET_URL = plugin_dir_url(__FILE__)
│   │
│   ├── 1.2 Security
│   │   ├── ABSPATH exit prevention
│   │   ├── secure_file_uploads() [5MB limit]
│   │   └── hidden status field in forms
│   │
│   └── 1.3 Activation Hook
│       └── register_activation_hook → create_support_ticket_table2()
│
├── 2. DATABASE STRUCTURE
│   ├── 2.1 Table: {$wpdb->prefix}_support_tickets
│   │   ├── Core Fields
│   │   │   ├── id (PK, auto-increment)
│   │   │   ├── tracking_code (unique)
│   │   │   └── user_id
│   │   │
│   │   ├── User Data
│   │   │   ├── full_name
│   │   │   ├── email
│   │   │   └── phone
│   │   │
│   │   ├── Ticket Metadata
│   │   │   ├── subject
│   │   │   ├── priority (low/medium/high/urgent)
│   │   │   └── support_agent
│   │   │
│   │   ├── Status Tracking
│   │   │   ├── status (new/active/closed)
│   │   │   ├── viewed (boolean)
│   │   │   └── response (text)
│   │   │
│   │   └── Timestamps
│   │       ├── created_at
│   │       └── updated_at
│   │
│   └── 2.2 Schema Management
│       ├── Conditional table creation (dbDelta)
│       └── Column updates (viewed field check)
│
├── 3. ADMIN INTERFACE
│   ├── 3.1 Menu System (admin_menu)
│   │   ├── Main Menu
│   │   │   ├── Dashicon: dashicons-tickets
│   │   │   └── Dynamic badge (new tickets count)
│   │   │
│   │   └── Submenus
│   │       ├── New Tickets (filter_new_tickets)
│   │       ├── Active Tickets (filter_active_tickets)
│   │       └── Closed Tickets (filter_closed_tickets)
│   │
│   ├── 3.2 Ticket Display
│   │   ├── Filter System
│   │   │   ├── Status dropdown (all/new/active/closed)
│   │   │   └── URL parameter: ?ticket_status=
│   │   │
│   │   ├── Table Columns (13 fields)
│   │   │   ├── ID/Tracking Code
│   │   │   ├── User Info (name/email/phone)
│   │   │   ├── Ticket Details (subject/priority)
│   │   │   └── Management (status/response)
│   │   │
│   │   └── Visual Indicators
│   │       ├── New tickets (green highlight)
│   │       └── Unread badges
│   │
│   └── 3.3 Interactive Features
│       ├── Status Update Form (POST)
│       ├── Response Submission (textarea)
│       └── Message Popups (per-ticket)
│
├── 4. FRONTEND COMPONENTS
│   ├── 4.1 Shortcodes
│   │   ├── [registration_form]
│   │   │   ├→ registration_form_shortcode2()
│   │   │   └→ handle_registration()
│   │   │
│   │   ├── [support_ticket_form]
│   │   │   ├→ support_ticket_form_shortcode()
│   │   │   └→ handle_ticket_submission()
│   │   │
│   │   └── [tracking_form]
│   │       ├→ tracking_form_shortcode()
│   │       └→ DB lookup by tracking_code
│   │
│   ├── 4.2 Form Handlers
│   │   ├── User Registration
│   │   │   ├→ wp_insert_user()
│   │   │   └→ WP_Error handling
│   │   │
│   │   ├── Ticket Submission
│   │   │   ├→ File upload validation
│   │   │   ├→ Attachment handling
│   │   │   └→ Tracking code generation (uniqid)
│   │   │
│   │   └── Ticket Tracking
│   │       └→ $wpdb->get_row() lookup
│   │
│   └── 4.3 Styling
│       ├── Form CSS (lightblue themes)
│       ├── Responsive layouts
│       └→ ob_start() buffer management
│
├── 5. AJAX SYSTEM
│   ├── 5.1 Handlers (wp_ajax_*)
│   │   ├── mark_ticket_viewed
│   │   │   ├→ Updates viewed=1
│   │   │   └→ manage_options cap check
│   │   │
│   │   └── get_new_tickets_count
│   │       └→ Returns JSON {count: x}
│   │
│   └── 5.2 Client-Side
│       ├── script.js
│       │   ├→ Modal show/hide
│       │   └→ AJAX callbacks
│       └→ Notification updates
│
├── 6. SECURITY
│   ├── 6.1 Data Sanitization
│   │   ├→ sanitize_text_field()
│   │   ├→ sanitize_email()
│   │   └→ intval() for IDs
│   │
│   ├── 6.2 Protection
│   │   ├→ File type whitelisting
│   │   ├→ IP address recording
│   │   └→ CAPTCHA scaffolding
│   │
│   └── 6.3 Access Control
│       └→ manage_options capability checks
│
└── 7. ASSETS
    ├── 7.1 CSS (admin-ui.css)
    │   ├── Table styling
    │   │   ├→ Zebra striping
    │   │   └→ Header colors (orangered)
    │   │
    │   └── Popup system
    │       ├→ Fixed positioning
    │       └→ Overlay effects
    │
    └── 7.2 JavaScript (script.js)
        ├── Modal management
        │   ├→ showModal(ticketId)
        │   └→ hideModal(ticketId)
        │
        └── AJAX integration
            ├→ mark_ticket_viewed
            └→ count updates
*/