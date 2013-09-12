<?php


class PlateformeAndroid extends Plateforme
{

	function __construct($apps = null)
	{
		parent::__construct($apps, 'android', 'Android');
	}


	/**
	 * @param $app \Slim\Slim
	 * @param $File File
	 */
	public function startSpecificDownloadForResource(\Slim\Slim $app, File $File)
	{
		$app->redirect($File->getDownloadUrl());
	}
}