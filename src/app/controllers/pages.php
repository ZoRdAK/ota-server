<?php


$app->get('/', function () use ($app) {
	$app->render('pages/home.twig', array(
		'plateformes' => Plateforme::findAllPlateformes()
	));
});

$app->get('/upload', function () use ($app) {
	$app->render('pages/upload.twig', array(
		'plateformes' => Plateforme::findAllPlateformes()
	));
});

$app->get('/delete', function () use ($app) {
	$elements = ResourceFactory::findAll();

	$app->render('pages/delete.twig', array(
			'currentUrl' => currentUrl(),
			'elements' => $elements)
	);
});