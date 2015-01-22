<?php

require_once DIR . '/app/models/plateformes/PlateformeAndroid.php';
require_once DIR . '/app/models/plateformes/PlateformeIOS.php';
require_once DIR . '/app/models/plateformes/PlateformeWindowsPhone.php';

abstract class Plateforme
{
	private $apps;
	public $id;
	public $nom;

	function __construct($apps, $id, $nom)
	{
		$this->apps = $apps;
		$this->id = $id;
		$this->nom = $nom;
	}

	/**
	 * @param $id
	 * @return Plateforme | null
	 */
	public static function findById($id)
	{
		$plateformes = static::findAllPlateformes();
		foreach ($plateformes as $p) {
			if ($p->id == $id) {
				return $p;
			}
		}
		return null;
	}

	public static function findAllPlateformes()
	{

		return array(
			new PlateformeIOS(),
			new PlateformeAndroid(),
//            new PlateformeWindowsPhone()
		);

	}

	function getApps()
	{
		$applications = array();
		$dossier = DIR . '/datas/' . $this->id;
		$fichiers = scan_dir($dossier);
		foreach ($fichiers as $fichier) {
			if ($fichier == '.' || $fichier == '..') {
				continue;
			}

			if (is_dir($dossier . '/' . $fichier)) {
				$applications[] = new Application($fichier, $fichier, $this);
			}
		}
		return $applications;
	}

	/**
	 * @param $app \Slim\Slim
	 * @param $File File
	 */
	public abstract function startSpecificDownloadForResource(\Slim\Slim $app, File $File);
}