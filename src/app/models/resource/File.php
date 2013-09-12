<?php


class File extends Resource
{

	function __construct($path)
	{
		parent::_construct($path);
	}

	public function getUrl()
	{
		return toUrl("dl/" . $this->getPath().'?manifest');
	}

	public function startDownload(\Slim\Slim $app)
	{
		$Plateforme = $this->getPlateforme();
		$Plateforme->startSpecificDownloadForResource($app, $this);
	}

	/**
	 * @return Plateforme
	 */
	private function getPlateforme()
	{
		$path = $this->getPath();
		$plateformDirectory = current(explode("/", $path));
		return Plateforme::findById($plateformDirectory);
	}

	public function getFullPath()
	{
		return $this->path;
	}
}