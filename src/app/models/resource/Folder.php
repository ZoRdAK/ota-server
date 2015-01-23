<?php


class Folder extends Resource
{
	private $childs = null;

	function __construct($path)
	{
		parent::_construct($path);
	}

	public function getUrl()
	{
		return toUrl("apps/" . $this->getPath());
	}

	public function listResources()
	{
		if ($this->childs === null) {
			$this->childs = array('files' => array(), 'folders' => array());
			$fs = scan_dir($this->path);
			foreach ($fs as $fichier) {
				if (is_file_to_skip($fichier)) {
					continue;
				}
				$path = $this->path . '/' . $fichier;
				if (is_dir($path)) {
					$this->childs['folders'][] = new Folder($path);
				} else {
					$this->childs['files'][] = new File($path);
				}
			}

		}
		return $this->childs;
	}


	private function getChilds()
	{
		return $this->childs === null ? $this->listResources() : $this->childs;
	}


	public function getFiles()
	{
		$childs = $this->getChilds();
		return $childs['files'];
	}

	public function getFolders()
	{
		$childs = $this->getChilds();
		return $childs['folders'];
	}

	public function hasFolders()
	{
		return sizeof($this->getFolders()) > 0;
	}

	public function hasFiles()
	{
		return sizeof($this->getFiles()) > 0;
	}

	public function isFolder()
	{
		return true;
	}
}