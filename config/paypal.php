<?php

return [
   'client_id' => env('PAYPAL_CLIENT_ID', 'AbAzUP1IumVC33DjOsLF4zQ45PCxkaVkNPG0B3upwA-Qf9n_9kWbUiQgzNeghaGwjhX7s5Xg-6AbhHRO'),
   'secret' => env('PAYPAL_SECRET', 'EEtLcMq8C7ZYS0gT16Gvq33tQg7DV2sL7WXCbIyxUcjmX0g1DwQIbhSJidgNEY6TJ6vrcr3i5rOtJ0Zd'),
   'settings' => array(
       'mode' => env('PAYPAL_MODE', 'sandbox'),
       'http.ConnectionTimeOut' => 60,
       'log.LogEnabled' => true,
       'log.FileName' => storage_path() . '/logs/paypal.log',
       'log.LogLevel' => 'ERROR'
   ),
];
