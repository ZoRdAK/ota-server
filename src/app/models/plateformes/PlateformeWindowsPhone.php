<?php


class PlateformeWindowsPhone extends Plateforme
{
    function __construct($apps = null)
    {
        parent::__construct($apps, 'wp', 'Windows Phone');
    }

    public function startSpecificDownloadForFile(\Slim\Slim $app, $dossier, $fichier)
    {
        // TODO: Implement startSpecificDownloadForFile() method.
    }

    public function getDownloadUrl(Version $Version)
    {
        return '#';
    }

	public function getDownloadUrlForPath($chemin)
	{
		return '#';
	}
}