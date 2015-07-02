<?php

return [

	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session',

	/**
	 * Consumers
	 */
	'consumers' => [

		'Facebook' => [
			'client_id'     => '799340646815931',
			'client_secret' => '4a9775d9cf61f21e7d6890126dceac3c',
			'scope'         => ['email'],
		],

		'Twitter' => [
			'client_id'     => 'W8rrQItpmu8DIL3JhVCF14Fmb',
			'client_secret' => '98P5Xr4fMF5mcQpuSyl76Aekh9FNLL7NmgerouxOmkn37sEXnu',
		],

	]

];
