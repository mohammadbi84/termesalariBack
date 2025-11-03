<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    "accepted"         => ":attribute باید پذیرفته شده باشد.",
    "active_url"       => "آدرس :attribute معتبر نیست",
    "after"            => ":attribute باید تاریخی بعد از :date باشد.",
    "alpha"            => ":attribute باید شامل حروف الفبا باشد.",
    "alpha_dash"       => ":attribute باید شامل حروف الفبا و عدد و خظ تیره(-) باشد.",
    "alpha_num"        => ":attribute باید شامل حروف الفبا و عدد باشد.",
    "array"            => ":attribute باید شامل آرایه باشد.",
    "before"           => ":attribute باید تاریخی قبل از :date باشد.",
    "between"          => array(
        "numeric" => ":attribute باید بین :min و :max باشد.",
        "file"    => ":attribute باید بین :min و :max کیلوبایت باشد.",
        "string"  => ":attribute باید بین :min و :max کاراکتر باشد.",
        "array"   => ":attribute باید بین :min و :max آیتم باشد.",
    ),
    "boolean"          => "The :attribute field must be true or false",
    "confirmed"        => ":attribute با تاییدیه مطابقت ندارد.",
    "date"             => ":attribute یک تاریخ معتبر نیست.",
    "date_format"      => ":attribute با الگوی :format مطاقبت ندارد.",
    "different"        => ":attribute و :other باید متفاوت باشند.",
    "digits"           => ":attribute باید :digits رقم باشد.",
    "digits_between"   => ":attribute باید بین :min و :max رقم باشد.",
    "email"            => "فرمت :attribute معتبر نیست.",
    "exists"           => ":attribute انتخاب شده، معتبر نیست.",
    "image"            => ":attribute باید تصویر باشد.",
    "in"               => ":attribute انتخاب شده، معتبر نیست.",
    "integer"          => ":attribute باید نوع داده ای عددی (integer) باشد.",
    "ip"               => ":attribute باید IP آدرس معتبر باشد.",
    "max"              => array(
        "numeric" => ":attribute نباید بزرگتر از :max باشد.",
        "file"    => ":attribute نباید بزرگتر از :max کیلوبایت باشد.",
        "string"  => ":attribute نباید بیشتر از :max کاراکتر باشد.",
        "array"   => ":attribute نباید بیشتر از :max آیتم باشد.",
    ),
    "mimes"            => ":attribute باید یکی از فرمت های :values باشد.",
    "min"              => array(
        "numeric" => ":attribute نباید کوچکتر از :min باشد.",
        "file"    => ":attribute نباید کوچکتر از :min کیلوبایت باشد.",
        "string"  => ":attribute نباید کمتر از :min کاراکتر باشد.",
        "array"   => ":attribute نباید کمتر از :min آیتم باشد.",
    ),
    "not_in"           => ":attribute انتخاب شده، معتبر نیست.",
    "numeric"          => ":attribute تنها باید شامل عدد باشد.",
    "regex"            => ":attribute یک فرمت معتبر نیست",
    "required"         => "پر کردن فیلد :attribute الزامی  می باشد.",
    "required_if"      => "پر کردن فیلد :attribute هنگامی که :other برابر با :value است، الزامیست.",
    "required_with"    => ":attribute الزامی است زمانی که حداقل :values موجود است.",
    "required_with_all"=> ":attribute الزامی است زمانی که :values موجود است.",
    "required_without" => ":attribute الزامی است زمانی که :values موجود نیست.",
    "required_without_all" => ":attribute الزامی است زمانی که :values موجود نیست.",
    "same"             => ":attribute و :other باید مانند هم باشند.",
    "size"             => array(
        "numeric" => ":attribute باید برابر با :size باشد.",
        "file"    => ":attribute باید برابر با :size کیلوبایت باشد.",
        "string"  => ":attribute باید برابر با :size کاراکتر باشد.",
        "array"   => ":attribute باسد شامل :size آیتم باشد.",
    ),
    'string' => 'فیلد :attribute باید از نوع متنی باشد و پر کردن آن الزامی است.',
    "timezone"         => "The :attribute must be a valid zone.",
    "unique"           => ":attribute قبلا ثبت شده است.",
    "url"              => "فرمت آدرس :attribute اشتباه است.",

    'jdate' => ':attribute تاریخ شمسی معتبر نمی باشد.',
    'jdate_equal' => ':attribute تاریخ شمسی برابر :fa-date نمی باشد.',
    'jdate_not_equal' => ':attribute تاریخ شمسی نامساوی :fa-date نمی باشد.',
    'jdatetime' => 'تاریخ و زمان شمسی معتبر نمی باشد.',
    // 'jdatetime' => ':attribute تاریخ و زمان شمسی معتبر نمی باشد.',
    'jdatetime_equal' => ':attribute تاریخ و زمان شمسی مساوی :fa-date نمی باشد.',
    'jdatetime_not_equal' => ':attribute تاریخ و زمان شمسی نامساوی :fa-date نمی باشد.',
    'jdate_after' => ':attribute تاریخ شمسی باید بعد از :fa-date باشد.',
    'jdate_after_equal' => ':attribute تاریخ شمسی باید بعد یا برابر از :fa-date باشد.',
    'jdatetime_after' => ':attribute تاریخ و زمان شمسی باید بعد از :fa-date باشد.',
    'jdatetime_after_equal' => ':attribute تاریخ و زمان شمسی باید بعد یا برابر از :fa-date باشد.',
    'jdate_before' => ':attribute تاریخ شمسی باید قبل از :fa-date باشد.',
    'jdate_before_equal' => ':attribute تاریخ شمسی باید قبل یا برابر از :fa-date باشد.',
    'jdatetime_before' => ':attribute تاریخ و زمان شمسی باید قبل از :fa-date باشد.',
    'jdatetime_before_equal' => ':attribute تاریخ و زمان شمسی باید قبل یا برابر از :fa-date باشد.',

            // "This password reset link will expire in :count minutes." : "لطفاً توجه داشته باشید، این لینک پس از  :count ساعت منقضی خواهد شد." ,
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */
    

    'custom' => array(

    ),

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */
    'attributes' => array(
        "name" => "نام",
        "family" => "نام خانوادگی",
        "username" => "نام کاربری",
        "email" => "پست الکترونیکی",
        "first_name" => "نام",
        "last_name" => "نام خانوادگی",
        "password" => "رمز عبور",
        "Password" => "رمز عبور",
        "password_confirmation" => "تاییدیه ی رمز عبور",
        "Password_confirmation" => "تاییدیه ی رمز عبور",
        "city" => "شهر",
        "country" => "کشور",
        "address" => "نشانی",
        "phone" => "تلفن",
        "mobile" => "موبایل",
        "age" => "سن",
        "sex" => "جنسیت",
        "gender" => "جنسیت",
        "day" => "روز",
        "month" => "ماه",
        "year" => "سال",
        "hour" => "ساعت",
        "minute" => "دقیقه",
        "second" => "ثانیه",
        "title" => "عنوان",
        "text" => "متن",
        "content" => "توضیحات",
        "description" => "توضیحات",
        "excerpt" => "گلچین کردن",
        "date" => "تاریخ",
        "time" => "زمان",
        "available" => "موجود",
        "size" => "اندازه",
        "category" => "دسته بندی",
        "code" => "کد  ",
        "unit" => "واحد",
        "summary" => "خلاصه خبر",
        "photo" => "عکس خبر",
        "avatar" => "آواتار",
        "compony" => "شرکت",
        "job" => "سمت شغلی",
        "level" => "سطح حادثه",
        "file" => "فایل",
        "reportid" => "شماره گزارش",
        "cat_name" => "عنوان دسته بندی",
        "pages" => "تعداد صفحات" ,
        "desc" => "توضیحات" ,
        "publisher" => "ناشر" ,
        "authors" => "نویسنده",
        "conditions" => "پذیرش شرایط عضویت" ,
        "category_id" => "دسته بندی محصول" ,
        "design_id" => "عنوان طرح" ,
        "design_color_id" => "رنگ محصول" ,
        "contains" => "" ,
        "dimensions" => "ابعاد محصول" ,
        "weight" => "وزن محصول" ,
        "kind" => "جنس محصول" ,
        "sewingType" => "نوع دوخت" ,
        "kindOfEster" => "جنس آستر" ,
        "washable" => "قابلیت شستشو" ,
        "uses" => "موارد استفاده" ,
        "price" => "قیمت محصول" ,
        "offType" => "نوع تخفیف" ,
        "offPrice" => "میزان تخفیف" ,
        "price.*" => "قیمت محصول" ,
        "offType.*" => "نوع تخفیف" ,
        "offPrice.*" => "میزان تخفیف" ,
        "local.*" => "واحد پول" ,
        "price.0" => "اولین قیمت  محصول" ,
        "offType.0" => "نوع تخفیف" ,
        "offPrice.0" => "میزان تخفیف" ,
        "local.0" => "واحد پول" ,
        "price.1" => "دومین قیمت  محصول" ,
        "offType.1" => "نوع تخفیف" ,
        "offPrice.1" => "میزان تخفیف" ,
        "local.1" => "واحد پول" ,
        "price.2" => "سومین قیمت  محصول" ,
        "offType.2" => "نوع تخفیف" ,
        "offPrice.2" => "میزان تخفیف" ,
        "local.2" => "واحد پول" ,
        "type" => "نوع محصول" ,
        "tags" => "برچسب" ,
        "images" => "تصاویر محصول" ,
        "quantity" => "میزان موجودی محصول" ,
        "description" => "توضیحات" ,
        "haveEster" => "ویژگی آستر" ,
        "city" => "استان" ,
        "subcity" => " شهر" ,
        "zipcode" => "کدپستی" ,
        "houseId" => "پلاک" ,
        "nationalCode" => "کدملی" ,
        "companyName" => "نام شرکت یا سازمان" ,
        "companyEconomyID" => "کد اقتصادی" ,
        "companyNationalID" => "شناسه ملی" ,
        "companyRegistrationID" => "شناسه ثبت" ,
        "companyTel" => "شماره تلفن ثابت" ,
        "companySite" => " سایت" ,
        "birthday" => "تاریخ تولد" ,
        "city_id" => "نام استان" ,
        "subcity_id" => "نام شهر " ,
        // 'start_date' => 'start date',
        // 'expire_datetime' => 'expire datetime',
        "currentPassword" => "رمز عبور فعلی" ,
        "message" => "متن پیام" ,
        "subject" => "عنوان پیام" ,
        "order" => "ترتیب" ,
        "image" => "تصویر" ,
        'start_date' => 'تاریخ شروع',
        'expire_datetime' => 'تاریخ انقضا',
        "tracing_code" => "شماره ارجاع یا شماره پیگیری" ,
        "price_cardPay" => "مبلغ پرداختی" ,
        "countOfColor" => "تعداد رنگ بافت " ,
        "shaba_number" => "شماره شبا" ,
        "" => "" ,
        "" => "" ,

    ),
);
