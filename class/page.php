<?php
require_once('xml.php');
class Page
{
	private $pageDetails;
	public function __construct($fileName="page.xml")
	{
		$xml=new XML();
		$page=$xml->readXML($fileName);
		foreach($page->page as $page)
		{
			$page_array = array();
			$page_array['id'] = $page->id;
			$page_array['name'] = $page->name;
			$page_array['menu'] = $page->menu;
			$page_array['link'] = $page->link;
			$page_array['title'] = $page->title;
			$page_array['author'] = $page->author;
			$page_array['keywords'] = $page->keywords;
			$page_array['description'] = $page->description;
			$page_array['chat'] = $page->chat;
			$pageDetails[] = $page_array;
		}
		$this->pageDetails=$pageDetails;
	}
	/* GETTERS AND SETTERS */
	public function setPageDetails($pageDetails)
	{
		$this->pageDetails=$pageDetails;
	}
	public function getPageDetails()
	{
		return $this->pageDetails;
	}
	/* GETTERS AND SETTERS */
}
?>