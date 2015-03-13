<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => [
		'domain' => '',
		'secret' => '',
	],

	'mandrill' => [
		'secret' => '',
	],

	'ses' => [
		'key' => '',
		'secret' => '',
		'region' => 'us-east-1',
	],

	'stripe' => [
		'model'  => 'User',
		'secret' => '',
	],
    'google' => [
        'client_id' => '741360746130-j22f3npp278bma1i54845m10gbblk9nb.apps.googleusercontent.com',
        'client_secret' => 'YA01Aa-lomnwHd35-1D4RlNy',
        'redirect' => 'http://localhost:8000/oauth2callback'
        //'redirect' => 'https://fathomless-atoll-9455.herokuapp.com/oauth2callback',
    ],

];
