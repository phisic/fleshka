<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Fleshka.ru Флешки оптом под нанесение логотипа, флешки оптом из китая, купить флешку, флешки металлические, флешки usb, флешки под нанесение логотипа, флэшки, флешка с логотипом, флешки оптом, флешки под нанесение, флешки купить, флешки под логотип, флешки с логотипом.',

	'theme'  => 'test',

	// preloading 'log' component
	'preload'=>array(
		'log',
		'bootstrap'
		),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.yii-mail.YiiMailMessage',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
	        'generatorPaths' => array(
	          'bootstrap.gii'
	        ),			
		),
		
	),

	// application components
	'components'=>array(

	       'errorHandler'=>array(
		    'errorAction' => 'site/error'
		),

	    'ePdf' => array(
	        'class'         => 'ext.yii-pdf.EYiiPdf',
	        'params'        => array(
	            'mpdf'     => array(
	                'librarySourcePath' => 'application.vendors.mpdf.*',
	                'constants'         => array(
	                    '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
	                ),
	                'class'=>'mpdf', // the literal class filename to be loaded from the vendors folder
	                /*'defaultParams'     => array( // More info: http://mpdf1.com/manual/index.php?tid=184
	                    'mode'              => '', //  This parameter specifies the mode of the new document.
	                    'format'            => 'A4', // format A4, A5, ...
	                    'default_font_size' => 0, // Sets the default document font size in points (pt)
	                    'default_font'      => '', // Sets the default font-family for the new document.
	                    'mgl'               => 15, // margin_left. Sets the page margins for the new document.
	                    'mgr'               => 15, // margin_right
	                    'mgt'               => 16, // margin_top
	                    'mgb'               => 16, // margin_bottom
	                    'mgh'               => 9, // margin_header
	                    'mgf'               => 9, // margin_footer
	                    'orientation'       => 'P', // landscape or portrait orientation
	                )*/
	            ),

		 		'HTML2PDF' => array(
		            'librarySourcePath' => 'application.vendors.html2pdf.*',
		            'classFile'         => 'html2pdf.class.php', // For adding to Yii::$classMap
		            /*
		            'defaultParams'     => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
		                'orientation' => 'P', // landscape or portrait orientation
		                'format'      => 'A4', // format A4, A5, ...
		                'language'    => 'ru', // language: fr, en, it ...
		                'unicode'     => true, // TRUE means clustering the input text IS unicode (default = true)
		                'encoding'    => 'UTF-8', // charset encoding; Default is UTF-8
		                'marges'      => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
		            ),
		            */
		        ),

			),
		),

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'bootstrap' => array(
		    'class' => 'ext.bootstrap.components.Bootstrap',
		    'responsiveCss' => false,
            // 'coreCss'  => FALSE,
            // 'yiiCss'   => FALSE,
            // 'enableJS' => FALSE

		),

       'cache'=>array(
            'class'=>'CApcCache',
            //'servers'=>array(
                //array('host'=>'localhost', 'port'=>11211, 'weight'=>60),
                //array('host'=>'server2', 'port'=>11211, 'weight'=>40),
            //),
        ),
		
		// uncomment the following to enable URLs in path-format

		'urlManager'=>array(
			'urlFormat'=>'path',
			'cacheID' => false,
			'urlSuffix' => '/',
			//'useStrictParsing'=>true,
			'caseSensitive'=>false,
			'showScriptName'=>false,
			'rules'=>array(
				//'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<action:\w+>/<id:\d+>/<type:\w+>'=>'site/<action>',
				//'<controller:\w+>/<action:\w+>/<id:\d+>/<type:\w+>'=>'<controller>/<action>',
				//'sites/<action:\w+>/<id:\d+>/*'=>'<action>',
				//'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'chat' => 'site/chat',
				'contacts' => 'site/contacts',
				'news' => 'site/news',
				'korzina' => 'site/korzinka',
				'single_item/*' => 'site/single_item',
			),
		),

		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=newflash',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'varlorwCndjx5OJ6',
			'charset' => 'latin1',
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning, trace',
				),
				// uncomment the following to show log messages on web pages
				/*
                		array (
                 		   	'class' => 'CWebLogRoute',
                   			'showInFireBug'=>true, // будет выводить информацию через FireBug
                		)*/
			),
		),
	  	'mail'=>array(
	        'class'=>'ext.yii-mail.YiiMail',
	    ),
   	    'request' => array(
		'baseUrl' => 'http://www.fleshka.ru',
	    ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'yandex_map_api'=>'AKOS1FEBAAAAS_H3KQIAAMgY7leIm9QXKZLq5d23ngq8cvgAAAAAAAAAAAABNDsR-XKqxkSBsDQkCC8z7kXLog==',
	),
);
