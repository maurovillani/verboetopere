<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Forza il traffico su https
 *
 * @return void
 */
function Force_ssl()
{
    $server=$_SERVER["SERVER_NAME"];
    $uri=$_SERVER["REQUEST_URI"];
    if ($_SERVER['HTTPS'] == 'off'||!isset($_SERVER['HTTPS'])) {
        redirect("https://{$server}{$uri}");
		exit();
	}
}