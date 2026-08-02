<?php

return [
    // Page title and card
    'title' => 'User Profile',
    'card_title' => 'Personal Account Information',

    // Personal information section
    'personal_info' => [
        'name' => 'First Name',
        'family' => 'Last Name',
        'national_code' => 'National ID (no dashes)',
        'birthday' => 'Date of Birth',
        'mobile' => 'Mobile Number',
        'email' => 'Email Address',
        'shaba_number' => 'IBAN (for refunds)',
        'send_newsletter' => 'Receive Newsletter',
        'yes' => 'Yes',
        'no' => 'No',
    ],

    // Legal information section
    'legal_info' => [
        'header' => 'Add Legal Information',
        'description' => 'By completing the legal information, you can make corporate purchases with official invoices and VAT certificates.',
        'company_name' => 'Company/Organization Name',
        'company_economy_id' => 'Economic Code',
        'company_national_id' => 'National ID (Company)',
        'company_registration_id' => 'Registration ID',
        'company_city' => 'Province of Head Office',
        'company_subcity' => 'City of Head Office',
        'company_tel' => 'Phone Number (Landline)',
        'company_site' => 'Website Address',
    ],

    // Buttons
    'buttons' => [
        'submit' => 'Save Information',
    ],

    // Placeholders
    'placeholders' => [
        'select_city' => '. Select province',
        'select_subcity' => '. Select city',
    ],


    /*
    |--------------------------------------------------------------------------
    | Orders Section
    |--------------------------------------------------------------------------
    */
    'orders' => [
        // Page title and card
        'title' => 'My Orders',
        'card_title' => 'Order History',

        // Status tabs
        'tabs' => [
            'processing' => 'Processing',
            'posted' => 'Shipped',
            'rejected' => 'Rejected',
            'unsuccessful' => 'Unsuccessful Payment',
        ],

        // Order header
        'header' => [
            'code' => 'Invoice Code',
            'date' => 'Date',
            'payment' => 'Payment',
            'details' => 'Details',
        ],

        // Order items table
        'items_table' => [
            'row' => 'Row',
            'product' => 'Product Title',
            'count' => 'Quantity',
            'amount' => 'Amount',
            'discount' => 'Discount',
            'payable' => 'Payable',
        ],

        // Order summary
        'summary' => [
            'total' => 'Total',
            'total_discount' => 'Total Discount',
            'special_discount' => 'Special Discount',
            'total_payable_with_shipping' => 'Total Payable (incl. shipping)',
            'payable_with_shipping' => 'Payable (incl. shipping)',
        ],

        // Recipient information
        'recipient_info' => [
            'title' => 'Recipient Information',
            'name' => 'First Name',
            'family' => 'Last Name',
            'national_code' => 'National ID',
            'mobile' => 'Mobile Number',
            'address' => 'Address',
            'house_number' => 'House Number',
            'zipcode' => 'Postal Code',
        ],

        // Shipping information
        'shipping_info' => [
            'title' => 'Shipping Information',
            'method' => 'Shipping Method',
            'cost' => 'Cost',
            'duration' => 'Duration',
            'max_duration' => 'Maximum',
            'send_date' => 'Shipping Date',
            'tracking_code' => 'Tracking Code',
        ],

        // Payment information
        'payment_info' => [
            'title' => 'Payment Information via',
            'ref_number' => 'Reference/Tracking Number',
            'payment_date' => 'Payment Date',
            'amount' => 'Amount',
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Order Detail Section
    |--------------------------------------------------------------------------
    */
    'order_detail' => [
        // Page title and card
        'title' => 'Order Details',
        'card_title' => 'Order Details',

        // Order header
        'header' => [
            'code' => 'Invoice Code',
            'date' => 'Date',
        ],

        // Order items table
        'items_table' => [
            'row' => 'Row',
            'product' => 'Product Title',
            'count' => 'Quantity',
            'amount' => 'Amount',
            'discount' => 'Discount',
            'payable' => 'Payable',
        ],

        // Order summary
        'summary' => [
            'total' => 'Total',
            'total_discount' => 'Total Discount',
            'special_discount' => 'Special Discount',
            'total_payable_with_shipping' => 'Total Payable (incl. shipping)',
        ],

        // Recipient information
        'recipient_info' => [
            'title' => 'Recipient Information',
            'name' => 'First Name',
            'family' => 'Last Name',
            'national_code' => 'National ID',
            'mobile' => 'Mobile Number',
            'address' => 'Address',
            'house_number' => 'House Number',
            'zipcode' => 'Postal Code',
        ],

        // Shipping information
        'shipping_info' => [
            'title' => 'Shipping Information',
            'method' => 'Shipping Method',
            'cost' => 'Cost',
            'duration' => 'Duration',
            'max_duration' => 'Maximum',
            'send_date' => 'Shipping Date',
            'tracking_code' => 'Tracking Code',
        ],

        // Payment information
        'payment_info' => [
            'title' => 'Payment Information via',
            'ref_number' => 'Reference/Tracking Number',
            'payment_date' => 'Payment Date',
            'amount' => 'Amount',
        ],

        // Back button
        'back_button' => 'Back',
    ],


    /*
    |--------------------------------------------------------------------------
    | Payments Section
    |--------------------------------------------------------------------------
    */
    'payments' => [
        // Page title and card
        'title' => 'My Payments',
        'card_title' => 'Payment History',

        // Table title (if used)
        'table_title' => 'Payments List',

        // Table columns
        'columns' => [
            'row' => 'Row',
            'method' => 'Payment Method',
            'ref_number' => 'Reference/Transaction ID',
            'amount' => 'Amount',
            'date' => 'Date',
            'invoice_code' => 'Invoice Code',
            'description' => 'Description',
        ],

        // DataTable settings (JavaScript strings)
        'datatable' => [
            'next' => 'Next',
            'previous' => 'Previous',
            'search' => 'Search : ',
            'length_menu' => 'Show <select> ... </select> entries',
            'info_empty' => 'No records found',
            'info' => 'Showing _START_ to _END_ of _TOTAL_ entries',
            'info_filtered' => '(filtered from _MAX_ total entries)',
            'zero_records' => 'No data available',
            'loading_records' => 'Loading...',
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Favorites Section
    |--------------------------------------------------------------------------
    */
    'favorites' => [
        // Page title and card
        'title' => 'Favorites',
        'card_title' => 'Favorites',

        // Words used in product title
        'design' => 'Design',
        'color' => 'Color',

        // Product related texts
        'product' => [
            'out_of_stock' => 'Out of Stock',
            'view_product' => 'View Product',
            'remove_from_list' => 'Remove from list',
            'price_unit' => 'Toman',
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Comments Section
    |--------------------------------------------------------------------------
    */
    'comments' => [
        // Card title
        'card_title' => 'Comments',

        // Words used in product title
        'design' => 'Design',
        'color' => 'Color',

        // Display fields in card
        'fields' => [
            'date' => 'Date :',
            'status' => 'Status :',
            'count' => 'Comments count :',
        ],

        // Comment statuses
        'statuses' => [
            'approved' => 'Approved',
            'pending' => 'Pending Review',
        ],

        // Buttons
        'buttons' => [
            'view' => 'View',
            'delete' => 'Delete',
            'close' => 'Close',
        ],

        // Modal (comments details table)
        'modal' => [
            'columns' => [
                'row' => 'Row',
                'date' => 'Date',
                'text' => 'Comment',
                'status' => 'Status',
                'delete' => 'Delete',
            ],
        ],

        // JavaScript messages (for SweetAlert)
        'js' => [
            'confirm_delete_single_title' => 'Warning',
            'confirm_delete_single_text' => 'Are you sure you want to delete this comment?',
            'confirm_delete_all_title' => 'Warning',
            'confirm_delete_all_text' => 'Are you sure you want to delete all comments related to this product?',
            'cancel' => 'Cancel',
            'confirm' => 'Delete',
            'error_title' => 'Operation failed',
            'success_title' => 'Operation completed successfully.',
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Addresses Section
    |--------------------------------------------------------------------------
    */
    'addresses' => [
        // Card title
        'card_title' => 'Addresses',

        // Tooltips and labels
        'recipient_name_tooltip' => 'Recipient full name',
        'postal_code_tooltip' => 'Postal Code',
        'mobile_tooltip' => 'Mobile',
        'house_number' => 'House Number',

        // Buttons
        'buttons' => [
            'edit' => 'Edit',
            'delete' => 'Delete',
        ],

        // JavaScript messages (for SweetAlert)
        'js' => [
            'confirm_title' => 'Attention',
            'confirm_text' => 'Are you sure you want to delete this recipient?',
            'cancel' => 'Cancel',
            'confirm' => 'Delete',
            'success_title' => 'Operation completed successfully',
            'error_title' => 'Operation failed',
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Messages Section
    |--------------------------------------------------------------------------
    */
    'messages' => [
        // Card title
        'card_title' => 'Messages',

        // Tabs
        'tabs' => [
            'new' => 'Send Message',
            'list' => 'Message List',
        ],

        // Send message section
        'send' => [
            'subject_label' => 'Subject',
            'message_label' => 'Message Body',
            'submit_button' => 'Send',
            'alert_title' => 'Attention!',
        ],

        // Message list section (table)
        'list' => [
            'columns' => [
                'row' => 'Row',
                'date' => 'Date',
                'subject' => 'Subject',
                'message' => 'Message',
                'view' => 'View',
                'delete' => 'Delete',
            ],
            'view_tooltip' => 'View Conversation',
            'delete_tooltip' => 'Delete Conversation',
        ],

        // JavaScript messages (for SweetAlert)
        'js' => [
            'confirm_title' => 'Are you sure you want to delete this message?',
            'confirm_text' => 'Deleting this message will remove all related conversations.',
            'cancel' => 'Cancel',
            'confirm' => 'Delete',
            'success_title' => 'Operation completed successfully.',
            'error_title' => 'Operation failed',
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Message Detail Section
    |--------------------------------------------------------------------------
    */
    'message_detail' => [
        // Card title
        'card_title' => 'Message Details',

        // Initial card info
        'info' => [
            'date' => 'Date :',
            'subject' => 'Subject :',
            'message' => 'Message :',
        ],

        // Back link
        'back_link' => 'Back',

        // Conversation table
        'table' => [
            'columns' => [
                'row' => 'Row',
                'date' => 'Date',
                'message' => 'Message',
                'view' => 'View',
                'delete' => 'Delete',
            ],
            'delete_tooltip' => 'Delete Message',
            'no_records' => 'No messages available.',
        ],

        // Modal for viewing message
        'modal' => [
            'date_label' => 'Date :',
            'close_button' => 'Close',
        ],

        // Reply form
        'reply_form' => [
            'textarea_placeholder' => 'Enter your message...',
            'submit_button' => 'Send',
        ],

        // JavaScript messages (for SweetAlert)
        'js' => [
            'confirm_delete_title' => 'Are you sure you want to delete this message?',
            'confirm_delete_text' => 'This action cannot be undone.',
            'cancel' => 'Cancel',
            'confirm' => 'Delete',
            'success_title' => 'Operation completed successfully.',
            'error_title' => 'Operation failed',
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Change Password Section
    |--------------------------------------------------------------------------
    */
    'change_password' => [
        // Card title
        'card_title' => 'Change Password',

        // Form labels
        'labels' => [
            'current_password' => 'Current Password',
            'new_password' => 'New Password',
            'confirm_password' => 'Confirm New Password',
        ],

        // Submit button
        'submit_button' => 'Save',

        // Alert title
        'alert_title' => 'Attention!',
    ],


    /*
    |--------------------------------------------------------------------------
    | User Panel Section (Sidebar & Header)
    |--------------------------------------------------------------------------
    */
    'panel' => [
        // Avatar modal title
        'avatar_modal_title' => 'Change Your Profile Picture',

        // Close button in modal
        'avatar_modal_close' => 'Close',

        // Sidebar menu
        'menu' => [
            'my_orders' => 'My Orders',
            'my_payments' => 'My Payments',
            'favorites' => 'Favorites',
            'comments' => 'Comments',
            'recipients' => 'Recipients',
            'messages' => 'Messages',
            'profile' => 'Profile',
            'change_password' => 'Change Password',
            'logout' => 'Logout',
        ],

        // Email verification alert
        'email_alert' => [
            'title' => 'Attention!',
            'text' => 'You have not verified your email address.',
            'description' => 'An email containing the verification link has been sent to you. Please open the received email and click on the link.',
            'resend_button' => 'Resend Verification Email',
            'success_message' => 'The verification email has been resent. Please check your inbox.',
        ],
    ],
];
