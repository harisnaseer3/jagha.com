<?php

return [
    'jazzcash' => [
        'MERCHANT_ID' 	 => '',
        'PASSWORD' 		 => '',
        'INTEGERITY_SALT'=> '',
        'CURRENCY_CODE'  => 'PKR',
        'VERSION'		 => '1.1',
        'LANGUAGE'  	 => 'EN',


        'RETURN_URL'  => 'http://127.0.0.1/dashboard/paymentStatus',
//        'RETURN_URL'  => 'https://property.aboutpakistan.com/dashboard/paymentStatus',
        'TRANSACTION_POST_URL'  => 'https://sandbox.jazzcash.com.pk/CustomerPortal/transactionmanagement/merchantform/'

    ]
];
