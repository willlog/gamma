<?php

// This is the database connection configuration.
//Local
/*return array(
	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database
	
	'connectionString' => 'mysql:host=localhost; dbname=db_sigma2',
	//'connectionString' => 'mysql:host=8.43.86.183; port=3306 ;dbname=db_sigma2',
	'emulatePrepare' => true,
	//'username' => 'cristianl',
	'//password' => 'OOIrs4Tx',
	'username' => 'sigma',
	'password' => 'sigma2016',
	'charset' => 'utf8',	
);*/

// This is the database connection configuration.
//Producción
return array(
	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database
	
	'connectionString' => 'mysql:host=localhost;dbname=db_sigma2',
	'emulatePrepare' => true,
	'username' => 'root',
	'password' => '.Fisei123sigma',
	'charset' => 'utf8',	
);
