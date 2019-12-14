<?php
return [
    //Http请求超时时间
    'timeout' => 10.0,
    //默认发送配置
    'default' => [
        //网关调用策略,默认:顺序调用
        'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,
        //默认可以的发送网关
        'geteways' => [
            'aliyun',
        ]
    ],
    //可用配置网关
    'geteways' => [
        'errorlog' => [
            'file' => '/tmp/easy-sms.log',
        ],
        'aliyun' => [
            'access_key_id' => env('SMS_ALIYUN_ACCESS_KEY_ID'),
            'access_key_secret' => env('SMS_ALIYUN_ACCESS_KEY_SECRET'),
            'sign_name' => 'larabbs',
        ]
    ]
];
