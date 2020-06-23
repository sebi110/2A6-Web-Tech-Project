<?php


// Http Url
$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
define('HTTP_URL', '/'. substr_replace(trim($_SERVER['REQUEST_URI'], '/'), '', 0, strlen($scriptName)));

// Define Path Application
define('SCRIPT', str_replace('\\', '/', rtrim(__DIR__, '/')) . '/');
define('SYSTEM', SCRIPT . 'System/');
define('CONTROLLERS', SCRIPT . 'Application/Controllers/');
define('MODELS', SCRIPT . 'Application/Models/');
define('VIEWS', SCRIPT . 'Application/Views/');
define('SERVICES', SCRIPT . 'Application/Services/');
define('MISC', SCRIPT . 'Application/Misc/');
define('COUNTABLE', array(
    'iyear'   => array('Year',1970,2017),
    'imonth'  => array('Month',0,12),
    'iday'    => array('Day',0,31),
    'count'   => array('Count',1,1000),
    'success' => array('Was it a succes?(0=false,1=true)',0,1)
));

define('DBU', 'Terrorism.users');
define('DBA', 'Terrorism.terror');