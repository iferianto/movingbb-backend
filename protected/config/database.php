<?php

// This is the database connection configuration.
return array(
	'connectionString' => 'pgsql:host=localhost;port=5432;dbname=gis',
    'username' => 'postgres',
    'password' => 'postgres',
	'emulatePrepare' => true,
	'charset' => 'utf8',
);
