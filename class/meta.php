<?php
class Meta
{
	private $title;
	private $type;
	private $description;
	private $keywords;
	private $metaURL;
	private $image;
	// TITLE TYPE DESCRIPTION KEYWORDS METAURL //
	public function __construct($title,$type,$description,$keywords,$metaURL,$image='http://www.pavanratnakar.com/pavan.jpg')
	{
		$this->title=$title;
		$this->type=$type;
		$this->description=$description;
		$this->keywords=$keywords;
		$this->metaURL=$metaURL;
		$this->image=$image;
	}
	// GETTERS AND SETTERS //
	public function getTitle()
	{
		return $this->title;
	}
	public function getType()
	{
		return $this->type;
	}
	public function getDescription()
	{
		return $this->description;
	}
	public function getKeywords()
	{
		return $this->keywords;
	}
	public function getMetaURL()
	{
		return $this->metaURL;
	}
	public function getImage()
	{
		return $this->image;
	}
	// GETTERS AND SETTERS //
}
?>