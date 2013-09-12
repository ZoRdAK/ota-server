<?php

define('DIR', dirname(__FILE__));
define('DIR_DATAS', DIR . '/datas/');
define('DIR_TPL', DIR . '/app/templates/');

define('DIR_TWIG', 'vendor/twig/twig/lib/Twig');

function initSlimView()
{
	$twig = new \Slim\Views\Twig();
	$twig->parserDirectory = DIR_TWIG;
	$twig->setTemplatesDirectory(DIR_TPL);

	$filter = new Twig_SimpleFilter('toUrl', 'toUrl');
	$twig->getInstance()->addFilter($filter);

	return $twig;
}