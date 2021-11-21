<?php
return [
	'menu' => [

		'title' => 'contacts::admin/default.menu_title',
		'url' => '/admin/contacts',
		'icon_class' => 'fa fa-inbox'

	],
	'recipient' => [
		'email' => ['lic.igor@propar.com.py','lic.ivan@propar.com.py'],
		'name'	=> 'INFO PROPAR Inmobiliaria'
	],
	'validation_rules' => [

        'name'   => 'required|min:3',
        'message'   => 'required|min:3',
        'email'   => 'required|email',
        'phone'   => 'required|min:3',
				'g-recaptcha-response' => 'required|recaptcha',

	]
];
