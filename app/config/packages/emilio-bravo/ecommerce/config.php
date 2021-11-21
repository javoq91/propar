<?php
return array(
    'sku' => [
        'valid_chars' => 'QWERTYADFGHZXCVBMNKJPU9876432',
        'length' => 6,
        'prefix' => 'CF-'],
    'tax' => 10,
    'bancard' => [
        'public_key' => getenv('bancard_public_key'),
        'private_key' => getenv('bancard_private_key')
    ],
    'shipping' => [
        'default_delivery_time' => getenv('shipping_default_delivery_time')
    ],
    'emails' => [

        'orders' => [

            'new' => [

                'subject' => 'Hemos recibido su pedido - PROPAR Inmobiliaria'

            ]

        ],

        'payments' => [

            'new' => [

                'subject' => 'Hemos recibido su pago - PROPAR Inmobiliaria'

            ]

        ]

    ]
);
