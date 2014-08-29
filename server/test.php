<?php
/* Configuration */
DEFINE ('DB_TYPE', 'sqlite');
DEFINE ('DB_USER', '');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', 'busfree.sqlite');
DEFINE ('DB_NAME', 'busfree');
DEFINE ('ERROR_LEVEL', 0);

require 'Database.php';

Database::initialize();
$users = Database::select('bee_user', '*');
print_r($users);

/*
$users = Database::select('Users','*',array('limit' => '0,5','orderBy' => 'last_name ASC,first_name ASC' ));
print_r($users);
*/
