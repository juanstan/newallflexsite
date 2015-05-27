<?php 

return array( 
	
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
	'consumers' => array(

		/**
		 * Facebook
		 */
        'Facebook' => array(
			'client_id'     => '799340646815931',
			'client_secret' => '4a9775d9cf61f21e7d6890126dceac3c',
			'scope'         => array('email'),
        ),

		'Twitter' => array(
			'client_id'     => 'W8rrQItpmu8DIL3JhVCF14Fmb',
			'client_secret' => '98P5Xr4fMF5mcQpuSyl76Aekh9FNLL7NmgerouxOmkn37sEXnu',
			// No scope - oauth1 doesn't need scope
		),

	)

);