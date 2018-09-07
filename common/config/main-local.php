<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=astro',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
             'useFileTransport' => false,
        		'transport' => [
        				'class' => 'Swift_SmtpTransport',
        				'host' => 'hosting.kameshwarieservices.com',
        				'username' => 'astro-api@expertwebworx.in',
						'password' => 'p@ssword$786',
        				'port' => '465',
        				'encryption' => 'ssl',
        		],
        ],
    ],
];
