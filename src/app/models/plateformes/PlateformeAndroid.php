<?php


class PlateformeAndroid extends Plateforme
{

	function __construct($apps = null)
	{
		parent::__construct($apps, 'android', 'Android');
	}

	public function startSpecificDownloadForFile(\Slim\Slim $app, $dossier, $fichier)
	{
		header('Content-Type: application/vnd.android.package-archive');
		header('Content-Disposition: attachment; filename="' . $fichier . '"');
		readfile(DIR . '/' . $dossier . '/' . $fichier);
	}

	public function getDownloadUrl(Version $Version)
	{
		$dossier = '/datas/' . $this->id . '/' . $Version->Section->Application->id . '/' . $Version->Section->id . '/' . $Version->id;
		$exe = $this->getAppFileFromDirectory($dossier);

		if ($exe == null) {
			return '#';
		}

		return $dossier . '/' . $exe;
	}

	public function getDownloadUrlForPath($chemin)
	{
		$chemin = '/datas/' . $chemin;
		if (!file_exists(DIR . $chemin)) {
			return '#';
		}

		return $chemin;
	}
}