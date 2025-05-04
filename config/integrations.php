<?php

return [
    'sms' => [
        'api_url' => env('SMS_API_URL', 'http://mshastra.com/sendurl.aspx'),
        'user_name' => env('SMS_USER_NAME', 'KiswaTrans'),
        'password' => env('SMS_PASSWORD', '9es16syb'),
        'sender_id' => env('SMS_SENDER_ID', 'KISWA'),
    ],

];
