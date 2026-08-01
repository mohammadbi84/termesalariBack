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
];
