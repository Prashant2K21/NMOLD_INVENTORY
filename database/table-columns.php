<?php

$table_columns_mapping = [
    'users' => [
        'first_name','last_name','role','email','password','created_at','updated_at'
    ],
    'products' => [
        'product_name','description','img','created_by','created_at','updated_at'
    ],
    'suppliers' => [
        'supplier_name','supplier_contact','supplier_gstin','supplier_account_name','supplier_account_number','supplier_ifsc','supplier_location','email','created_by','created_at','updated_at'
    ],
    'buyers' => [
        'buyer_name', 'buyer_contact', 'buyer_gstin','buyer_account_name','buyer_account_number','buyer_ifsc','buyer_location','email','created_by','created_at','updated_at'
    ]
    ];
?>