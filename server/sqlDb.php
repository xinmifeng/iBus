<?php

/* Configuration */
DEFINE ('DB_TYPE', 'sqlite');
DEFINE ('DB_USER', '');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', '../server/dbfile/busfree.sqlite');
DEFINE ('DB_NAME', 'busfree');
DEFINE ('ERROR_LEVEL', 0);

require ("Database.php");
Database::initialize();

?>
