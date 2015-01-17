<?php
require_once('xml.php');
class About
{
	private $aboutMe;
	public function __construct()
	{
		$xml=new XML();
		$about=$xml->readXML('about.xml');
		foreach($about->about as $about)
		{
			$about_array = array();
			$about_array['title'] = $about->title;
			$about_array['id'] = $about->id;
			$about_array['description'] = $about->description;
			$about_array['urlDescription'] = $about->url->description;
			$about_array['link'] = $about->url->link;
			$aboutme[] = $about_array;
		}
		$this->aboutMe=$aboutme;
	}
	/* GETTERS AND SETTERS */
	public function setAboutMe($aboutMe)
	{
		$this->aboutMe=$aboutMe;
	}
	public function getAboutMe()
	{
		return $this->aboutMe;
	}
	/* GETTERS AND SETTERS */
	
	/* PRINT ABOUT ME */
	public function printAboutMe()
	{
		$returnArray='';
		$aboutArray=$this->aboutMe;
		shuffle($aboutArray);
		for($i=0;$i<sizeof($this->aboutMe);$i++)
		{
			$returnString.='
			<div class="sponsor" title="Click to flip">
				<div class="sponsorFlip scroll-pane">
					<img id='.$aboutArray[$i]['title'].' src="images/about/'.strtolower($aboutArray[$i]['title']).'.jpg" height="230" width="230" alt="More about '.$aboutArray[$i]['title'].'" />
				</div>
				<h3>'.$aboutArray[$i]['title'].'</h3>
				<div class="sponsorData">
					<div class="sponsorDescription"><ul>';
					for($j=0;$j<sizeof($aboutArray[$i]['description']);$j++)
					{
						$returnString.='<li>'.$aboutArray[$i]['description'][$j].'</li>';
					}
					$returnString.='</ul>';
					if($aboutArray[$i]['urlDescription'])
					{
						$returnString.='<br/>'.$aboutArray[$i]['urlDescription'].' <a href='.strtolower($aboutArray[$i]['link']).'>'.$aboutArray[$i]['link'].'</a>';
					}
			$returnString.='</div></div></div>';
		}
		return $returnString;
	}
	/* PRINT ABOUT ME */
}
?>