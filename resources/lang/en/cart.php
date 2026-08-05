<?php

return [
    // Page title
    'title' => 'Shopping Cart',

    // Checkout steps (top bar)
    'steps' => [
        'step1' => 'Shopping Cart',
        'step2' => 'Shipping Information',
        'step3' => 'Payment',
        'step4' => 'Order Complete',
    ],

    // Cart section (right side)
    'cart' => [
        'header' => 'Your Shopping Cart',
        'items_label' => 'item(s)', // for quantity (e.g., 3 items)
        'empty_title' => 'Your cart is empty!',
        'empty_text' => 'You can browse products in the store.',
        'empty_button' => 'View Products',
    ],

    // Discount section
    'discount' => [
        'accordion_title' => 'Do you have a discount code?',
        'input_placeholder' => 'Discount code...',
        'apply_button' => 'Apply',
        'success_message' => 'Discount code applied.',
        'error_empty' => 'Please enter a discount code first.',
    ],

    // Order summary
    'order_summary' => [
        'title' => 'Order Summary',
        'items_price_label' => 'Items price',
        'items_unit' => 'item(s)',
        'discount_label' => 'Items discount',
        'discount_code_label' => 'Discount code',
        'shipping_label' => 'Shipping cost',
        'shipping_note' => 'Calculated in next step',
        'total_label' => 'Total',
        'currency' => 'Toman',
    ],

    // Payment section
    'payment' => [
        'payable_label' => 'Amount payable:',
        'continue_button' => 'Continue Checkout',
        'add_more_button' => 'Add More Products',
    ],

    // Product row in cart
    'product_row' => [
        'category_label' => 'Category:',
        'code_label' => 'Product code:',
        'guarantee_text' => 'Guarantee of authenticity and physical health of the product',
        'subtotal_label' => 'Subtotal:',
        'discount_label' => 'Discount:',
    ],

    // JavaScript messages (for dialogs and alerts)
    'js' => [
        'confirm_delete_title' => 'Are you sure you want to remove this product?',
        'confirm_delete_text' => 'This will remove the product from your shopping cart.',
        'confirm_delete_confirm' => 'Delete',
        'confirm_delete_cancel' => 'Cancel',
        'error_general' => 'Operation failed',
        'error_stock' => 'Product out of stock',
        'error_server' => 'Server connection error.',
        'success_delete' => 'Product removed from your cart.',
        'success_discount' => 'Discount code applied.',
        'error_discount_empty' => 'Please enter a discount code first.',
        'error'=>'error'
    ],



    /*
    |--------------------------------------------------------------------------
    | Checkout Step 2 (Address, Shipping & Payment)
    |--------------------------------------------------------------------------
    */
    'checkout_step2' => [
        'title' => 'Continue Checkout - Step 2',
        'card_title' => 'Checkout – Step 2',

        // Address selection section
        'address' => [
            'select_label' => 'Select delivery address:',
            'send_to_this_address' => 'Ship to this address',
            'add_new' => 'Add new address',
            'change_address' => 'Change or edit address',
            'selected_title' => 'Delivery Address',
            'postal_code' => 'Postal Code',
            'mobile' => 'Mobile',
            'recipient_name' => 'Recipient full name',
            'edit' => 'Edit',
            'delete' => 'Delete',
        ],

        // Shipping method
        'shipping' => [
            'select_label' => 'Select shipping method',
            'cost' => 'Shipping cost:',
            'free' => 'Free',
            'delivery_time' => 'Delivery time max :',
        ],

        // Payment method
        'payment' => [
            'select_label' => 'Select payment method',
        ],

        // Main buttons
        'buttons' => [
            'back_to_cart' => 'Back to Cart',
            'confirm_info' => 'Continue Checkout - Confirm Information',
            'close' => 'Close',
            'save' => 'Save',
        ],

        // Add address modal
        'add_address_modal' => [
            'title' => 'Address Details',
            'fields' => [
                'province' => 'Province*',
                'city' => 'City*',
                'address' => 'Address*',
                'address_help' => '(If living in an apartment complex, please mention block and unit number.)',
                'address_placeholder' => 'Please enter your address.',
                'house_number' => 'House Number*',
                'house_placeholder' => 'Please enter house number.',
                'zipcode' => 'Postal Code*',
                'zipcode_help' => '(10 digits, no dashes)',
                'zipcode_placeholder' => 'Please enter postal code.',
                'recipient_self' => 'I am the recipient.',
                'recipient_name' => 'Recipient First Name*',
                'recipient_name_placeholder' => 'Please enter recipient first name.',
                'recipient_family' => 'Recipient Last Name*',
                'recipient_family_placeholder' => 'Please enter recipient last name.',
                'national_code' => 'Recipient National ID*',
                'national_code_help' => '(no dashes)',
                'national_code_placeholder' => 'Please enter national ID.',
                'mobile' => 'Mobile Number*',
                'mobile_help' => '(e.g. 09131568758)',
                'mobile_placeholder' => 'Please enter mobile number.',
            ],
            'placeholders' => [
                'select_province' => '. Select province',
                'select_city' => '. Select city',
            ],
            'validation' => [
                'province_required' => 'Please select a province.',
                'city_required' => 'Please select a city.',
                'address_required' => 'Address field is required.',
                'house_required' => 'House number must be numeric and required.',
                'zipcode_required' => 'Postal code must be numeric and required.',
                'recipient_name_required' => 'Recipient first name is required.',
                'recipient_family_required' => 'Recipient last name is required.',
                'national_code_required' => 'National ID must be numeric and required.',
                'mobile_required' => 'Mobile number must be numeric and required.',
            ],
        ],

        // JavaScript messages (SweetAlert & errors)
        'js' => [
            'error_title' => 'Operation failed',
            'select_address' => 'Please select a delivery address.',
            'select_shipping' => 'Please select a shipping method.',
            'select_payment' => 'Please select a payment method.',
            'delete_confirm_title' => 'Are you sure you want to delete this address?',
            'delete_success' => 'Operation completed successfully.',
        ],
    ],




    /*
    |--------------------------------------------------------------------------
    | Final Checkout Step (Confirm Information)
    |--------------------------------------------------------------------------
    */
    'checkout_final' => [
        // Page title and card titles
        'title' => 'Continue Checkout - Confirm Information',
        'recipient_card_title' => 'Recipient Information',
        'invoice_card_title' => 'Invoice',

        // Recipient info labels
        'recipient_fields' => [
            'name' => 'Name :',
            'family' => 'Last Name :',
            'national_code' => 'National ID :',
            'mobile' => 'Mobile :',
            'address' => 'Address :',
            'postal_code' => 'Postal Code :',
            'house_number' => 'House No.',
        ],

        // Buttons
        'buttons' => [
            'back' => 'Back to previous step',
            'confirm_and_pay' => 'Confirm & Pay',
        ],

        // Order summary
        'summary' => [
            'payment_method' => 'Payment Method',
            'shipping_method' => 'Shipping via',
            'shipping_cost' => 'Shipping cost :',
            'special_discount' => 'Special Discount',
            'payable_amount' => 'Amount Payable',
            'discount_label' => 'Discount',
        ],
    ],



    /*
    |--------------------------------------------------------------------------
    | Register Recipient (Standalone Page)
    |--------------------------------------------------------------------------
    */
    'checkout_recipient' => [
        // Page title and card
        'title' => 'Continue Checkout - Register Recipient',
        'card_title' => 'Register Recipient Information',

        // Submit button
        'submit_button' => 'Save Recipient Information',
    ],



    /*
    |--------------------------------------------------------------------------
    | Purchase Invoice
    |--------------------------------------------------------------------------
    */
    'invoice' => [
        'title' => 'Purchase Invoice',
        'card_title' => 'Purchase Invoice',
        'code_label' => 'Invoice Code :',
        'date_label' => 'Date :',
        'print_button' => 'Print Page',
        'home_button' => 'Store Home',
        'orders_button' => 'Manage Orders',
        'store_name' => 'Termeh Salari | Glory of Three Generations Art',
        'central_store' => 'Central Store: Amir Chakhmaq Sq. | Tel: 035-3626-0637',
        'branch_store' => 'Branch 2: Next to Haj Khalifeh Leader Bakery, Saray Termeh | Tel: 035-3622-3880',
        'website' => 'http://TermehSalari.com',
        'email' => 'Info@TermehSalari.com',
        'instagram' => 'https://www.instagram.com/termehsalari',
        'whatsapp' => '09134577500',
    ],



    /*
    |--------------------------------------------------------------------------
    | Payment Error (Unsuccessful Transaction)
    |--------------------------------------------------------------------------
    */
    'payment_error' => [
        'title' => 'Purchase Invoice',
        'message' => 'Sorry, the transaction was unsuccessful.',
        'back_to_cart' => 'Back to Cart',
        'back_to_store' => 'Back to Store',
    ],
];
