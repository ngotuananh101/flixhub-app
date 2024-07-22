<?php

return [
    'sidebar' => [
        'analytics' => 'Analytics',
        'system_settings' => 'System Settings',
        'roles' => 'Roles',
        'users' => 'Users',
    ],
    'settings' => [
        'general' => [
            'title' => 'General Settings',
            'short_title' => 'General',
            'description' => 'Configure site url, homepage, theme and other general settings.',
            'app_name' => 'App Name',
            'app_description' => 'App Description',
            'app_url' => 'App URL',
            'app_timezone' => 'App Timezone',
            'app_locale' => 'App Locale',
            'app_theme' => 'App Theme',
            'app_favicon' => 'App Favicon',
            'app_logo_small' => 'App Logo Small',
            'app_logo' => 'App Logo',
            'app_logo_dark' => 'App Logo Dark',
            'save' => 'Save General Settings',
        ],
        'mail' => [
            'title' => 'Mail Settings',
            'short_title' => 'Mail',
            'description' => 'Configure mail settings for outgoing emails.',
            'host' => 'Mail Host',
            'host_help' => 'The SMTP host to use for sending emails.',
            'port' => 'Mail Port',
            'port_help' => 'The SMTP port to use for sending emails. e.g. 2525, 587(TLS), 465(SSL)',
            'username' => 'Mail Username',
            'username_help' => 'The username to use for sending emails.',
            'password' => 'Mail Password',
            'password_help' => 'The password to use for sending emails.',
            'encryption' => 'Mail Encryption',
            'encryption_help' => 'The encryption to use for sending emails. e.g. tls, ssl',
            'from_address' => 'Mail From Address',
            'from_address_help' => 'The email address to use for sending emails.',
            'from_name' => 'Mail From Name',
            'from_name_help' => 'The name to use for sending emails.',
            'save' => 'Save Mail Settings',
        ],
        'logging' => [
            'title' => 'Logging Settings',
            'short_title' => 'Logging',
            'description' => 'Configure logging settings for the application.',
            'sentry_laravel_dsn' => 'Sentry Laravel DSN',
            'sentry_laravel_dsn_help' => 'The DSN to use for sending errors to Sentry.',
            'sentry_client_key' => 'Sentry Client Key',
            'sentry_client_key_help' => 'The client key to use for sending errors to Sentry.',
            'sentry_traces_sample_rate' => 'Sentry Traces Sample Rate',
            'sentry_traces_sample_rate_help' => 'The sample rate to use for sending traces to Sentry.',
            'note' => 'Note',
            'sentry_info' => 'Sentry is a Self-hosted and cloud-based application performance monitoring & error tracking that helps software teams see clearer, solve quicker, & learn continuously.',
            'channel' => 'Logging Channels',
            'channel_help' => 'The logging channels to use for logging. e.g. stack, single, daily, syslog, errorlog, custom',
            'level' => 'Logging Level',
            'level_help' => 'The logging level to use for logging. e.g. emergency, alert, critical, error, warning, notice, info, debug',
            'save' => 'Save Logging Settings',
        ],
        'cache' => [
            'title' => 'Cache Settings',
            'short_title' => 'Cache',
            'description' => 'Configure cache settings for the application.',
            'cache_store' => 'Cache Store',
            'cache_store_help' => 'The cache store to use for caching. e.g. apc, array, database, file, memcached, redis',
            'cache_prefix' => 'Cache Prefix',
            'cache_prefix_help' => 'A string that should be prepended to keys to prevent overlap with other items stored in the cache.',
            'note' => 'Note',
            'cache_info' => 'Caching is a technique used to store copies of files or data in a place where subsequent requests for that data can be served faster.',
            'save' => 'Save Cache Settings',
        ],
    ],
    'roles' => [
        'title' => 'Roles Management',
        'description' => 'Configure roles for the application.',
        'actions' => [
            'title' => 'Actions',
            'reload' => 'Reload',
            'create' => 'Create Role',
            'search' => 'Search Roles...',
            'edit' => 'Edit',
            'delete' => 'Delete',
            'selected' => 'Selected',
            'delete_confirmation' => 'Are you sure you want to delete selected roles?',
            'delete_confirm' => 'Yes, delete them!',
            'cancel' => 'No, cancel',
            'delete_success' => 'Selected roles have been deleted successfully!',
            'delete_error' => 'Could not delete :names role! Please make sure that it is not default role!',
            'save' => 'Save',
            'default_role_cannot_change' => 'You must set another default role before changing this role!',
            'edit_success' => 'Role :name has been updated successfully!',
            'create_success' => 'Role :name has been created successfully!',
        ],
        'columns' => [
            'name' => 'Name',
            'guard_name' => 'Guard',
            'is_default' => 'Default',
            'last_updated' => 'Last Updated',
            'actions' => 'Actions',
        ],
        'create' => [
            'title' => 'Create Role',
            'description' => 'Create a new role for the application.',
        ],
        'edit' => [
            'title' => 'Edit Role',
            'description' => 'Edit a role for the application.',
        ],
        'fields' => [
            'name' => 'Name',
            'guard_name' => 'Guard Name',
            'is_default' => 'Default',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'permissions' => 'Permissions',
        ]
    ],
    'users' => [
        'title' => 'Users Management',
        'description' => 'Configure users for the application.',
        'actions' => [
            'title' => 'Actions',
            'create' => 'Create User',
            'search' => 'Search Users...',
            'reload' => 'Reload',
            'edit' => 'Edit',
            'delete' => 'Delete',
            'block' => 'Block',
            'no_selected' => 'No selected users',
            'block_confirmation' => 'Are you sure you want to block selected users?',
            'block_confirm' => 'Yes, block them!',
            'cancel' => 'No, cancel',
            'block_success' => 'Selected users have been blocked successfully!',
            'block_error' => 'Could not block :names ! Please try again later!',
            'delete_confirmation' => 'Are you sure you want to delete selected users?',
            'delete_confirm' => 'Yes, delete them!',
            'delete_success' => 'Selected users have been deleted successfully!',
            'delete_error' => 'Could not delete :names ! Please try again later!',
            'remove_avatar' => 'Remove Avatar',
            'cancel_avatar' => 'Cancel',
            'change_avatar' => 'Change Avatar',
            'form_invalid' => 'Please fill in all required fields!',
        ],
        'fields' => [
            'user' => 'User',
            'roles' => 'Roles',
            'username' => 'Username',
            'email' => 'Email',
            'google_id' => 'Google ID',
            'facebook_id' => 'Facebook ID',
            'email_verified_at' => 'Email Verified At',
            'password' => 'Password',
            'last_login_at' => 'Last Login At',
            'is_active' => 'Active',
            'permissions' => 'Permissions',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'actions' => 'Actions',
            'avatar' => 'Avatar',
            'avatar_hint' => 'Allowed file types: png, jpg, jpeg. Max file size 5MB.',
            'password' => 'Password',
            'password_confirmation' => 'Password Confirmation',
        ]
    ]
];
