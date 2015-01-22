<?php

define('DIR', dirname(__FILE__));
define('DIR_DATAS', DIR . '/datas/');
define('DIR_TPL', DIR . '/app/templates/');

define('DIR_TWIG', 'vendor/twig/twig/lib/Twig');


function scan_dir($dir)
{
    $ignored = hiddenFiles();

    $files = array();
    foreach (scandir($dir) as $file) {
        if (in_array($file, $ignored)) continue;
        $files[$file] = filemtime($dir . '/' . $file);
    }

    arsort($files);
    $files = array_keys($files);

    return ($files) ? $files : array();
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


function hiddenDataDirectories()
{
    return array('ios', 'android', 'wp');
}

function hiddenStandardFiles()
{
    return array(
        '.',
        '..',
        '_empty',
        '.svn',
        '.git',
        '.DS_Store'
    );
}

function hiddenFiles()
{
    return array_merge(hiddenStandardFiles(), hiddenDataDirectories());
}