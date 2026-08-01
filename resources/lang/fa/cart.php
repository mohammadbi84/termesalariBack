<?php

return [
    // عنوان صفحه
    'title' => 'سبد خرید',

    // مراحل خرید (نوار بالایی)
    'steps' => [
        'step1' => 'سبد خرید',
        'step2' => 'تکمیل اطلاعات پستی',
        'step3' => 'پرداخت',
        'step4' => 'تکمیل سفارش',
    ],

    // بخش سبد خرید (سمت راست)
    'cart' => [
        'header' => 'سبد خرید شما',
        'items_label' => 'کالا', // برای عدد (مثلاً ۳ کالا)
        'empty_title' => 'سبد خرید شما خالی است!',
        'empty_text' => 'می‌توانید برای مشاهده محصولات به صفحه فروشگاه بروید.',
        'empty_button' => 'مشاهده محصولات',
    ],

    // بخش کد تخفیف
    'discount' => [
        'accordion_title' => 'آیا کد تخفیف دارید؟',
        'input_placeholder' => 'کد تخفیف...',
        'apply_button' => 'اعمال',
        'success_message' => 'کد تخفیف اعمال شد.',
        'error_empty' => 'لطفا ابتدا کد تخفیف را وارد کنید.',
    ],

    // بخش جزئیات سفارش
    'order_summary' => [
        'title' => 'جزئیات سفارش',
        'items_price_label' => 'قیمت کالاها',
        'items_unit' => 'عدد', // برای تعداد
        'discount_label' => 'تخفیف کالاها',
        'discount_code_label' => 'کد تخفیف',
        'shipping_label' => 'هزینه ارسال',
        'shipping_note' => 'محاسبه در مرحله بعد',
        'total_label' => 'جمع کل',
        'currency' => 'تومان',
    ],

    // بخش پرداخت
    'payment' => [
        'payable_label' => 'مبلغ قابل پرداخت:',
        'continue_button' => 'ادامه فرایند خرید',
        'add_more_button' => 'افزودن دیگر محصولات',
    ],

    // ردیف محصول در سبد خرید
    'product_row' => [
        'category_label' => 'دسته بندی:',
        'code_label' => 'کد محصول:',
        'guarantee_text' => 'گارانتی اصالت و سلامت فیزیکی کالا',
        'subtotal_label' => 'جمع جزء :',
        'discount_label' => 'تخفیف:', // یا reuse شود
    ],

    // پیام‌های جاوااسکریپت (برای دیالوگ‌ها و اعلان‌ها)
    'js' => [
        'confirm_delete_title' => 'آیا از حذف این محصول مطمئن هستید؟',
        'confirm_delete_text' => 'این عملیات منجر به حذف محصول از سبد خرید شما خواهد شد.',
        'confirm_delete_confirm' => 'حذف',
        'confirm_delete_cancel' => 'انصراف',
        'error_general' => 'خطا در اجرای عملیات',
        'error_stock' => 'اتمام موجودی در انبار',
        'error_server' => 'ارتباط با سرور برقرار نشد.',
        'success_delete' => 'محصول از سبد خرید شما حذف شد.',
        'success_discount' => 'کد تخفیف اعمال شد.',
        'error_discount_empty' => 'لطفا ابتدا کد تخفیف را وارد کنید.',
        'error'=>'خطا'
    ],
];
