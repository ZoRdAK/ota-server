<?php


class File extends Resource
{

	function __construct($path)
	{
		parent::_construct($path);
	}

	public function getUrl()
	{
		return toUrl("dl/" . $this->getPath());
	}
}