<?php


function isJsonCall(\Slim\Slim $app)
{
	return strstr($app->request()->headers('Accept'), 'json') !== false;
}

function currentUrl()
{
	$pageURL = 'http';
	if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
		$pageURL .= "s";
	}
	$pageURL .= "://";
	$path = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"] . $path . ":" . $_SERVER["SERVER_PORT"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"] . $path;
	}

	return $pageURL;
}