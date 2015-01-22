<?php


class UnknownResource extends Resource {

	public function getUrl()
	{
		return '#';
	}

	public function isFolder()
	{
		return false;
	}
}