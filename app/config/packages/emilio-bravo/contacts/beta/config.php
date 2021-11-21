<?php
return [
	'menu' => [

		'title' => 'contacts::admin/default.menu_title',
		'url' => '/admin/contacts',
		'icon_class' => 'fa fa-inbox'

	],
	'recipient' => [
		'email' => ['luisescobarbravo@gmail.com','luis.escobar@intangible.com.py'],
		'name'	=> 'INFO PROPAR Inmobiliaria'
	],
	'validation_rules' => [

        'name'   => 'required|min:3',
        'message'   => 'required|min:3',
        'email'   => 'required|email',
        'phone'   => 'required|min:3'

	]
];