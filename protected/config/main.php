<?php
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'SOMAN',
	'theme'=>'classic',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'root',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
		'mailer' => array(
		      'class' => 'application.extensions.mailer.EMailer',
		      'pathViews' => 'application.views.email',
		      'pathLayouts' => 'application.views.email.layouts'
		),	
		'bootstrap'=>array(
	            'class'=>'bootstrap.components.Bootstrap',
	    ),
		'authManager'=>array(
		'class'=>"CDbAuthManager", 
		'connectionID'=>"db"),	

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		
		//Para implementar facebook connect
		//'session' => array(
          // 'autoStart'=>true,  
   		//),

		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>FALSE,
			'urlSuffix'=>'.html',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'<controller:(authitem)>/<action:\w+>/<id:\w+>'=>'authitem/<action>',
				'<controller:(authitem)>/<id:\w+>'=>'authitem/view',
				'<controller:(article)>/<action:\w+>/<name:\w+>'=>'article/<action>',
				'<controller:(article)>/<name:\w+>'=>'article/indexbuscar',
				'<controller:(user)>/<action:\w+>/<name:\w+>'=>'user/<action>',
				'<controller:(user)>/<name:\w+>'=>'user/indexbuscar',
				'<controller:(category)>/<action:\w+>/<name:\w+>'=>'category/catalogo/<action>',
				'<controller:(category)>/<action:\w+>/<idu:\w+>/<idc:\d+>'=>'category/articulocategoriautor/<action>',
				'<controller:(category)>/<action:\w+>/<table:\w+>'=>'category/description/<action>',
				
				
			),
		),
		
		'session' => array(
           'autoStart'=>true,  
   						   ),

		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),		

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>YII_DEBUG ? null : 'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'ax.calle.88@gmail.com',
		'icon-framework'=>'fa'
		//'host_email' => 'ceis.cujae.edu.cu',
		//'info_email_account' => 'pw@ceis.cujae.edu.cu',
    	//'info_email_password' => '(uxt23&-*',		
	),
);
