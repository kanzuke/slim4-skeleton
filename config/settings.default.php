<?php

// Error reporting for production
error_reporting(0);
ini_set('display_errors', '0');

// Timezone
date_default_timezone_set('Europe/Paris');

// Settings
$settings = [];


$settings['app']['basepath'] = '';
$settings['app']['api'] = "http://portail-outils-posa.intradef.gouv.fr/stcia/api";

$settings['ldap-cpt'] = [
     // Mandatory Configuration Options
    'hosts'            => ['ldapserver'],
    'base_dn'          => 'dc=example,dc=com',
    'username'         => 'ldap_username',
    'password'         => 'ldap_password',

    // Optional Configuration Options
    //'port'             => 389,
    'use_ssl'          => false,
    'use_tls'          => false,
    'version'          => 3,
    'timeout'          => 5,
    'follow_referrals' => false,

    // Custom LDAP Options
    'options' => [
        // See: http://php.net/ldap_set_option
        LDAP_OPT_DEBUG_LEVEL => 7,        // 7 for debugging
        LDAP_OPT_PROTOCOL_VERSION => 3,
        LDAP_OPT_X_TLS_REQUIRE_CERT => LDAP_OPT_X_TLS_NEVER
        
    ]
];


$settings['smobi']['adbasegroup'] = "SMOBI_GLOBAL";




$GLOBALS['settings'] = $settings;

?>