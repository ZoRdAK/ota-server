<?php

define('DIR', dirname(__FILE__));
define('DIR_DATAS', DIR . '/datas/');
define('DIR_TPL', DIR . '/app/templates/');

define('DIR_TWIG', 'vendor/twig/twig/lib/Twig');


function scan_dir($dir) {
    $ignored = array('.', '..', '.svn', '.htaccess');

    $files = array();    
    foreach (scandir($dir) as $file) {
        if (in_array($file, $ignored)) continue;
        $files[$file] = filemtime($dir . '/' . $file);
    }

    arsort($files);
    $files = array_keys($files);

    return ($files) ? $files : false;
}

function initSlimView()
{
	$twig = new \Slim\Views\Twig();
	$twig->parserDirectory = DIR_TWIG;
	$twig->setTemplatesDirectory(DIR_TPL);

	$filter = new Twig_SimpleFilter('toUrl', 'toUrl');
	$twig->getInstance()->addFilter($filter);

	return $twig;
}


function hiddenFiles()
{
	return array(
		'.',
		'..',
		'_empty',
		'.svn',
		'.git',
		'.DS_Store',
		'ios',
		'android',
		'wp'
	);
}