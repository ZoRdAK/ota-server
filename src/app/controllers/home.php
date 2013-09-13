<?php


$app->get('/', function () use ($app) {
	$app->render('home.twig', array(
		'plateformes' => Plateforme::findAllPlateformes()
	));
});

