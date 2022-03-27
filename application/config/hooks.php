<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['post_controller_constructor'] []= array(
    'class'    => 'LanguageLoader',
    'function' => 'initialize',
    'filename' => 'LanguageLoader.php',
    'filepath' => 'hooks'
 );
 

 /**
 * instanzia il file ssl e in particolare la funzione force_ssl per ridirezionare su https
 * Paolo Minervino
 */

$hook['post_controller_constructor'][] = array(
    'function' => 'Force_ssl',
    'filename' => 'ssl.php',
    'filepath' => 'hooks'
);