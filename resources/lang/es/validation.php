<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"             => "El :attribute debe ser aceptado.",
	"active_url"           => "El :attribute no es una URL válida.",
	"after"                => "El :attribute debe ser una fecha después de :date.",
	"alpha"                => "El :attribute sólo puede contener letras.",
	"alpha_dash"           => "El :attribute sólo puede contener letras, números y guiones.",
	"alpha_num"            => "El :attribute sólo puede contener letras y números.",
	"array"                => "El :attribute debe ser una Matriz.",
	"before"               => "El :attribute debe ser una fecha anterior :date.",
	"between"              => [
		"numeric" => "El campo :attribute debe estar entre :min y :max.",
		"file"    => "El campo :attribute debe estar entre :min y :max kilobytes.",
		"string"  => "El campo :attribute debe estar entre :min y :max caracteres como máximo.",
		"array"   => "El campo :attribute debe tener entre :min y :max items.",
	],
	"boolean"              => "El campo :attribute ser verdadero o falso.",
	"confirmed"            => "La confirmación del campo :attribute no coincide.",
	"date"                 => "El campo :attribute no es una fecha.",
	"date_format"          => "El campo :attribute does not match the format :format.",
	"different"            => "El campo :attribute and :other must be different.",
	"digits"               => "El campo :attribute must be :digits digits.",
	"digits_between"       => "El campo :attribute must be between :min and :max digits.",
	"email"                => "El campo :attribute debe ser una dirección de correo válida.",
	"filled"               => "El campo :attribute field is required.",
	"exists"               => "El campo selected :attribute is invalid.",
	"image"                => "El campo :attribute must be an image.",
	"in"                   => "El campo selected :attribute is invalid.",
	"integer"              => "El campo :attribute must be an integer.",
	"ip"                   => "El campo :attribute must be a valid IP address.",
	"max"                  => [
		"numeric" => "The :attribute may not be greater than :max.",
		"file"    => "The :attribute may not be greater than :max kilobytes.",
		"string"  => "The :attribute may not be greater than :max characters.",
		"array"   => "The :attribute may not have more than :max items.",
	],
	"mimes"                => "The :attribute must be a file of type: :values.",
	"min"                  => [
		"numeric" => "The :attribute must be at least :min.",
		"file"    => "The :attribute must be at least :min kilobytes.",
		"string"  => "The :attribute must be at least :min characters.",
		"array"   => "The :attribute must have at least :min items.",
	],
	"not_in"               => "The selected :attribute is invalid.",
	"numeric"              => "The :attribute must be a number.",
	"regex"                => "The :attribute format is invalid.",
	"required"             => "El campo :attribute es requerido.",
	"required_if"          => "The :attribute field is required when :other is :value.",
	"required_with"        => "The :attribute field is required when :values is present.",
	"required_with_all"    => "The :attribute field is required when :values is present.",
	"required_without"     => "The :attribute field is required when :values is not present.",
	"required_without_all" => "The :attribute field is required when none of :values are present.",
	"same"                 => "The :attribute and :other must match.",
	"size"                 => [
		"numeric" => "The :attribute must be :size.",
		"file"    => "The :attribute must be :size kilobytes.",
		"string"  => "The :attribute must be :size characters.",
		"array"   => "The :attribute must contain :size items.",
	],
	"unique"               => "El campo :attribute ya ha sido tomado.",
	"url"                  => "El campo :attribute tiene un formato invalido.",
	"timezone"             => "El campo :attribute debe ser una zona válida.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => [
		'attribute-name' => [
			'rule-name' => 'custom-message',
		],
	],

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => [],

];
