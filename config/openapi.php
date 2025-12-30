<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Spec
    |--------------------------------------------------------------------------
    |
    | Key spec default yang dipakai ketika parameter spec tidak dikirim.
    |
    */
    // 'default' => 'api-docs',

    /*
    |--------------------------------------------------------------------------
    | Spec Registry
    |--------------------------------------------------------------------------
    |
    | Daftar spec yang tersedia. Key adalah slug yang dipakai di URL,
    | value adalah path relatif dari public/openapi.
    |
    */
    'specs' => [
        'api-czlink' => 'api-docs.yaml',
        // 'czlink-api' => 'czlink/api-docs.yaml',
        'api-cdcp' => 'api-cdcp.yaml',
        'api-qris' => 'api-qris.yaml',
        'api-bnpl' => 'api-bnpl.yaml',
        'api-mini-atm' => 'api-mini-atm.yaml',
    ],
];
