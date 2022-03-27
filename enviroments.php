<?php

defined('RESTRICTED') OR exit('No direct script access allowed');

if (!defined('ENVIRONMENT')) {
    $domain = strtolower($_SERVER['HTTP_HOST']);

    switch ($domain) {
		case "localhost":
			define('ENVIRONMENT', 'development');
			break;
		case "ecm2mule":
			define('ENVIRONMENT', 'testing');
			break;
		default:
			define('ENVIRONMENT', 'production');
			break;
    }
}
