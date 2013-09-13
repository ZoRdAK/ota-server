<?php


abstract class Resource implements JsonSerializable
{
	protected $name;
	protected $path;
	protected $parent = null;

	public function _construct($path)
	{
		$this->path = $path;
	}

	public function getPath()
	{
		return strip_datas_dir($this->path);
	}

	public function getName()
	{
		return str_replace('_', '', basename($this->path));
	}

	public function getFullPath()
	{
		return $this->path;
	}

	public function getParent()
	{
		if ($this->parent == null) {
			$path = dirname($this->path);
			if ($path == rtrim(DIR_DATAS, '/')) {
				$this->parent = new BaseFolder();
			} else {
				$this->parent = new Folder($path);
			}
		}
		return $this->parent;
	}

	public function jsonSerialize(){
		return $this->getName();
	}

	public abstract function getUrl();
}