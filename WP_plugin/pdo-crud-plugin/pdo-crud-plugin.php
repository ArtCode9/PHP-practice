<?php
/* 
   Plugin Name: PDO CRUD Plugin
   Description: A plugin to manage a custom table with CRUD operations using PDO
   Version: 1.0
   Author: ArtCode
*/

// Security check
defined('ABSPATH') or die('No script kiddies please!');


// Define database table name
define('PDO_CRUD_TABLE', 'custom_contacts');


// Include necessary files
require_once plugin_dir_path(__FILE__) . 'includes/database.php';
require_once plugin_dir_path(__FILE__) . 'includes/functions.php';
require_once plugin_dir_path(__FILE__) . 'includes/admin-page.php';


// Activation and deactivation hooks
register_activation_hook(__FILE__, 'pdo_crud_activate');
register_deactivation_hook(__FILE__, 'pdo_crud_deactivate');



// Initialize the plugin
function pdo_crud_init() {
   // Create admin menu
   add_action('admin_menu', 'pdo_crud_admin_menu');

   // Register shortcode
   add_shortcode('pdo_crud_form', 'pdo_crud_frontend_form_shortcode');
}
add_action('plugins_loaded', 'pdo_crud_init');






//======================================================
//  map for this plugin
/* 
PDO CRUD Plugin Mind Map
│
├── Core Plugin Setup
│   ├── pdo_crud_init() - Initializes the plugin
│   └── pdo_crud_admin_menu() - Creates admin menu
│
├── Database Operations
│   ├── pdo_crud_activate() - Creates table on activation
│   ├── pdo_crud_deactivate() - Cleanup on deactivation
│   └── pdo_crud_get_pdo() - Gets PDO connection (singleton)
│
├── CRUD Functions
│   ├── Create
│   │   └── pdo_crud_create_contact() - Inserts new contact
│   │
│   ├── Read
│   │   ├── pdo_crud_get_contacts() - Gets all contacts
│   │   └── pdo_crud_get_contact() - Gets single contact by ID
│   │
│   ├── Update
│   │   └── pdo_crud_update_contact() - Updates existing contact
│   │
│   └── Delete
│       └── pdo_crud_delete_contact() - Deletes contact by ID
│
└── Admin Interface
    └── pdo_crud_admin_page() - Renders admin interface and handles form submissions
        ├── Displays add/edit form
        ├── Lists all contacts
        ├── Handles create/update/delete actions
        └── Shows success/error messages


 Expanded View of Relationships:
Initialization Flow

pdo_crud_init() → add_action('admin_menu') → pdo_crud_admin_menu()

Database Connection Flow

All CRUD functions → pdo_crud_get_pdo() → PDO instance

Admin Interface Flow

pdo_crud_admin_page() calls:

CRUD functions based on form submissions

Displays results using:

pdo_crud_get_contacts() for listing

pdo_crud_get_contact() when editing

Lifecycle Hooks

Activation: register_activation_hook() → pdo_crud_activate()

Deactivation: register_deactivation_hook() → pdo_crud_deactivate()

Key Dependencies:
All CRUD operations depend on pdo_crud_get_pdo()

Admin interface depends on all CRUD functions

The plugin structure follows WordPress standards with:

Proper hooks registration

Admin page capability checks

Nonce verification for security

This mind map shows how the functions are organized hierarchically 
and how they interact with each other to provide complete CRUD
functionality using PDO in WordPress.

*/


/* =============================================
PDO CRUD WordPress Plugin (Detailed Mind Map)
│
├── 1. PLUGIN CORE
│   ├── 1.1 Initialization
│   │   ├── pdo_crud_init()
│   │   │   ├── Hooks: 'plugins_loaded'
│   │   │   └── Calls: add_action('admin_menu')
│   │   │
│   │   └── pdo_crud_admin_menu()
│   │       ├── Uses: add_menu_page()
│   │       ├── Capability: 'manage_options'
│   │       └── Calls: pdo_crud_admin_page()
│   │
│   └── 1.2 Lifecycle Hooks
│       ├── pdo_crud_activate()
│       │   ├── Creates table: custom_contacts
│       │   ├── Columns: id, name, nickname, phone
│       │   └── Calls: pdo_crud_get_pdo()
│       │
│       └── pdo_crud_deactivate()
│           └── (Optional cleanup)
│
├── 2. DATABASE LAYER
│   └── pdo_crud_get_pdo()
│       ├── Singleton pattern
│       ├── Connection params:
│       │   ├── DB_HOST, DB_NAME, DB_USER, DB_PASSWORD
│       │   └── PDO attributes:
│       │       ├── ERRMODE_EXCEPTION
│       │       ├── FETCH_ASSOC
│       │       └── EMULATE_PREPARES=false
│       └── Used by: All CRUD operations
│
├── 3. CRUD OPERATIONS
│   ├── 3.1 CREATE
│   │   └── pdo_crud_create_contact($data)
│   │       ├── Parameters:
│   │       │   ├── $data['name'] (required)
│   │       │   ├── $data['nickname']
│   │       │   └── $data['phone']
│   │       ├── Sanitization: sanitize_text_field()
│   │       ├── SQL: INSERT
│   │       └── Returns: lastInsertId() or false
│   │
│   ├── 3.2 READ
│   │   ├── pdo_crud_get_contacts()
│   │   │   ├── SQL: SELECT * ORDER BY id DESC
│   │   │   └── Returns: array of contacts or empty array
│   │   │
│   │   └── pdo_crud_get_contact($id)
│   │       ├── Parameter: (int)$id
│   │       ├── SQL: WHERE id=:id
│   │       └── Returns: single contact or false
│   │
│   ├── 3.3 UPDATE
│   │   └── pdo_crud_update_contact($id, $data)
│   │       ├── Parameters:
│   │       │   ├── (int)$id
│   │       │   └── $data (same as create)
│   │       ├── SQL: UPDATE ... WHERE id=:id
│   │       └── Returns: bool (success)
│   │
│   └── 3.4 DELETE
│       └── pdo_crud_delete_contact($id)
│           ├── Parameter: (int)$id
│           ├── SQL: DELETE WHERE id=:id
│           └── Returns: bool (success)
│
├── 4. ADMIN INTERFACE
│   └── pdo_crud_admin_page()
│       ├── 4.1 Form Handling
│       │   ├── Actions:
│       │   │   ├── 'create' → pdo_crud_create_contact()
│       │   │   ├── 'update' → pdo_crud_update_contact()
│       │   │   └── 'delete' → pdo_crud_delete_contact()
│       │   ├── Security:
│       │   │   ├── check_admin_referer()
│       │   │   └── wp_nonce_field()
│       │   └── User Feedback:
│       │       ├── success notices
│       │       └── error notices
│       │
│       ├── 4.2 Display Components
│       │   ├── Edit Form:
│       │   │   ├── Pre-fills with pdo_crud_get_contact()
│       │   │   └── Condition: $_GET['edit']
│       │   │
│       │   └── Contact Table:
│       │       ├── Uses: pdo_crud_get_contacts()
│       │       ├── Columns: ID, Name, Nickname, Phone
│       │       └── Actions:
│       │           ├── Edit links (?edit=ID)
│       │           └── Delete forms
│       │
│       └── 4.3 UI Elements
│           ├── WP List Table style
│           ├── Form-table class
│           └── Button styles:
│               ├── button-primary
│               └── button-link-delete
│
└── 5. SECURITY MEASURES
    ├── Input:
    │   ├── All user input sanitized with sanitize_text_field()
    │   └── ID parameters cast to (int)
    │
    ├── Database:
    │   ├── PDO prepared statements
    │   └── EMULATE_PREPARES disabled
    │
    └── WordPress:
        ├── Capability check (manage_options)
        └── Nonce verification
=============================================

Key Technical Relationships:
Data Flow:

User Input → Admin Page → CRUD Functions → PDO → MySQL

MySQL → PDO → CRUD Functions → Admin Page → User

Error Handling:

PDO Exceptions → error_log()

User-facing notices via admin_notice

Dependency Chain:
=========================================
WordPress Core
→ pdo_crud_init()
  → pdo_crud_admin_menu()
    → pdo_crud_admin_page()
      → (All CRUD Functions)
        → pdo_crud_get_pdo()
          → PDO Extension
=========================================
Template Hierarchy:

Admin Page
├── Edit Form Template
│   ├── Field: name (required)
│   ├── Field: nickname
│   └── Field: phone
│
└── List Table Template
    ├── Pagination (potential future enhancement)
    └── Sortable columns (potential future enhancement)

=========================================

This expanded mind map includes implementation details that would be particularly useful for:

Debugging (shows all error handling paths)

Security auditing (highlights all protection layers)

Feature extensions (identifies template structure)

Performance optimization (shows database interaction points)

*/