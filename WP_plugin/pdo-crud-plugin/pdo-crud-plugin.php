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
}
add_action('plugins_loaded', 'pdo_crud_init');


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