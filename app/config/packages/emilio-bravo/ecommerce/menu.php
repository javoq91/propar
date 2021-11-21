<?php

return [
  'items' => [
      [
        'title' => 'ecommerce::admin/default.menu_title',
        'url' => '#',
        'icon_class' => 'fa fa-shopping-cart',
        'submenu' => [

            ['title' => 'ecommerce::admin/default.orders',
            'url' => '/admin/orders',
            'icon_class' => 'fa fa-cart-plus'],

            ['title' => 'ecommerce::admin/default.payments',
            'url' => '/admin/payments',
            'icon_class' => 'fa fa-money'],
        ]
      ]
    ]
  ]
;
