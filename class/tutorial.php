<?php
require_once('xml.php');
require_once('functions.php');
class Tutorial
{
	private $tutorialId;
	private $subTutorialId;
	private $mainPage;
	public function __construct()
	{
	}
	/* SETTERS AND GETTERS */
	public function setTutorialId($tutorialId)
	{
		$this->tutorialId=$tutorialId;
	}
	public function getTutorialId()
	{
		return $this->tutorialId;
	}
	public function getSubTutorialId()
	{
		return $this->subTutorialId;
	}
	public function setSubTutorialId()
	{
		$this->subTutorialId=$subTutorialId;
	}
	public function setMainPage($mainPage)
	{
		$this->mainPage=$mainPage;
	}
	public function getMainPage()
	{
		return $this->mainPage;
	}
	/* SETTERS AND GETTERS */
	public function getTutorials($tutorialId=null,$subTutorialId=null)
	{
		$xml=new XML();
		$tutorial=$xml->readXML('tutorial.xml');
		foreach($tutorial->category as $tutorial)
		{
			$tutorial_array = array();
			$tutorial_array['id'] = $tutorial->id;
			$tutorial_array['name'] = $tutorial->name;
			$tutorial_array['query'] = $tutorial->query;
			$tutorial_array['subtutorials'] = $this->getSubTutorials($tutorial->subtutorials->tutorial,$subTutorialId);
			if($tutorialId)
			{
				if($tutorialId==$tutorial->id)
				{
					return $tutorial_array;
				}
			}
			else
			{
				$tutorials[] = $tutorial_array;
			}
		}
		return $tutorials;
	}
	public function getSubTutorials($subTutorials,$subTutorialId)
	{
		foreach($subTutorials as $subTutorial)
		{
			$sub_tutorial_array = array();
			$sub_tutorial_array['id'] = $subTutorial->id;
			$sub_tutorial_array['name'] = $subTutorial->name;
			$sub_tutorial_array['query'] = $subTutorial->query;
			$sub_tutorial_array['author'] = $subTutorial->author;
			$sub_tutorial_array['description'] = $subTutorial->description;
			$sub_tutorial_array['keyword'] = $subTutorial->keyword;
			if($subTutorialId)
			{
				if($subTutorialId==$subTutorial->id)
				{
					return $sub_tutorial_array;
				}
			}
			else
			{
				$sub_tutorials[] = $sub_tutorial_array;
			}
		}
		return $subTutorials;
	}
	public function printNode($tutorials,$i)
	{
		$subTutorial='';
		echo '<ul>';
		echo '<li><a href="javascript:void(0);" class="parent">'.$tutorials[$i]['name'].'</a><span></span>';
		echo '<div><ul>';
		for($j=0;$j<sizeof($tutorials[$i]['subtutorials']);$j++)
		{
			$subTutorial=$tutorials[$i]['subtutorials'][$j];
			if($subTutorial->id==0)
			{
				$link="javascript:void(0);";
				$name='To be updated.';
			}
			else
			{
				$link="http://www.pavanratnakar.com/tutorial/".$tutorials[$i]['id']."/".$subTutorial->id;
				$name=$subTutorial->name;
			}
			echo '<li><span></span><a href="'.$link.'" title="'.$name.'">'.$name.'</a></li>';
		}
		echo '</ul></div></li></ul>';
	}
}
?>