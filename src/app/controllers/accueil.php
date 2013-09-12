<?php

function hiddenFiles()
{
	return array('.', '..', '_empty', '.svn', '.git', '.DS_Store', 'ios', 'android', 'wp');
}

$app->get('/', function () use ($app) {
	$app->render('accueil.twig', array(
		'plateformes' => Plateforme::findAllPlateformes()
	));
});

