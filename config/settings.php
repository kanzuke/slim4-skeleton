<?php

// Error reporting for production
error_reporting(0);
ini_set('display_errors', '0');

// Timezone
date_default_timezone_set('Europe/Paris');

// Settings
$settings = [];


$settings['app']['basepath'] = '/suivi-finances';
?>