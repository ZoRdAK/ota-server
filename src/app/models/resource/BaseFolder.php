<?php


class BaseFolder extends Folder
{

	function __construct()
	{
		parent::_construct(DIR_DATAS);
	}

	public function getUrl()
	{
		return toUrl();
	}

	public function getPath()
	{
		return DIR;
	}

	public function getName()
	{
		return 'accueil';
	}

	public function getParent()
	{
		return $this;
	}


}