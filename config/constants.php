<?php

return [
    'jazzcash' => [
        'MERCHANT_ID' => 'MC21156',
        'PASSWORD' => '1g5guy2t0z',
        'INTEGERITY_SALT' => 'ua06e5sw42',
        'CURRENCY_CODE' => 'PKR',
        'VERSION' => '1.1',
        'LANGUAGE' => 'EN',


//        'RETURN_URL' => 'http://127.0.0.1/api/paymentStatus',
        'RETURN_URL' => 'http://127.0.0.1/api/dashboard/paymentStatus',
//        'RETURN_URL'  => 'https://property.aboutpakistan.com/dashboard/paymentStatus',
        'TRANSACTION_POST_URL' => 'https://sandbox.jazzcash.com.pk/CustomerPortal/transactionmanagement/merchantform/'

    ]
];
