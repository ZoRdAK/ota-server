<?php


class PlateformeWindowsPhone extends Plateforme
{
	function __construct($apps = null)
	{
		parent::__construct($apps, 'wp', 'Windows Phone');
	}

	/**
	 * @param $app \Slim\Slim
	 * @param $File File
	 */
	public function startSpecificDownloadForResource(\Slim\Slim $app, File $File)
	{
		//TODO
	}
}