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

$app->get('/delete(/:dossiers+?)', function ($dossiers = null) use ($app) {
    $path = '';
    $parentPath = '';
    $parentName = 'Accueil';
    $folderName = '';

    if (is_array($dossiers)) {
        $folderName = array_pop($dossiers);
        $parentPath = join(DIRECTORY_SEPARATOR, $dossiers);
        $parentName = sizeof($dossiers) > 0 ? array_pop($dossiers) : $parentName;
        $path = $parentPath . '/' . $folderName;
    }
    if (is_string($dossiers)) {
        $path = $dossiers;
        $folderName = $path;
    }
    $elements = ResourceFactory::findInPath($path);

    $app->render('pages/delete.twig', array(
            'currentUrl' => currentUrl(),
            'currentFolder' => $path,
            'isRootFolder' => $path == '',
            'folderName' => $folderName,
            'parentPath' => $parentPath,
            'parentName' => $parentName,
            'elements' => $elements)
    );
});