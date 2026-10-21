<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Feature flags (PRD 6.3)
    |--------------------------------------------------------------------------
    | Office document entries in the "New" menu stay hidden until enabled.
    */
    'features' => [
        'office_docs' => (bool) env('STOMAN_OFFICE_DOCS', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Storage quota
    |--------------------------------------------------------------------------
    | Displayed by the storage meter and the upload modal subtitle.
    | The backend will later enforce the real value.
    */
    'storage' => [
        'quota' => env('STOMAN_STORAGE_QUOTA', '10 GB'),
        'warning_percent' => 70,
        'danger_percent' => 90,
    ],

];
