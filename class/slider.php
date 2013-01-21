<?php
include_once('xml.php');
class Slider
{
	private $slider;
	public function __construct()
	{
		$xml=new XML();
		$this->slider=$xml->readXML('slider.xml');
		echo $this->displaySlider($this->gethomeFirstDetails(),1,1);
		echo $this->displaySlider($this->gethomePromotionDetails(),2,2);
		echo $this->displaySlider($this->gethomeGeneralDetails(),3,4);
	}
	public function gethomeFirstDetails()
	{
		foreach($this->slider->home->first->slider as $slider)
		{
			$slider_array = array();
			$slider_array['title'] = $slider->title;
			$slider_array['alt'] = $slider->alt;
			$slider_array['img'] = $slider->img;
			$slider_array['id'] = $slider->id;
			$slider_array['url'] = $slider->url;
			$sliders[] = $slider_array;
		}
		return $sliders;
	}
	public function gethomePromotionDetails()
	{
		foreach($this->slider->home->promotion->slider as $slider)
		{
			$slider_array = array();
			$slider_array['title'] = $slider->title;
			$slider_array['alt'] = $slider->alt;
			$slider_array['img'] = $slider->img;
			$slider_array['id'] = $slider->id;
			$slider_array['url'] = $slider->url;
			$sliders[] = $slider_array;
		}
		return $sliders;
	}
	public function gethomeGeneralDetails()
	{
		foreach($this->slider->home->general->slider as $slider)
		{
			$slider_array = array();
			$slider_array['title'] = $slider->title;
			$slider_array['alt'] = $slider->alt;
			$slider_array['img'] = $slider->img;
			$slider_array['id'] = $slider->id;
			$slider_array['url'] = $slider->url;
			$sliders[] = $slider_array;
		}
		return $sliders;
	}
	public function displaySlider($sliders,$size,$start)
	{
		shuffle($sliders);
		if(sizeof($sliders)>$size)
		{
			$count=$size;
		}
		else
		{
			$count=sizeof($sliders);
		}
		for($i=0;$i<$count;$i++)
		{
			if($sliders[$i]['url']->external==1)
			{
				$external='target="_blank"';
			}
			else
			{
				$external='';
			}
			echo '<a href="'.$sliders[$i]['url']->link.'" '.$external.'>
						<div id="slide-img-'.($i+$start).'">
							<img src="images/slider/'.$sliders[$i]['img'].'" alt="'.$sliders[$i]['alt'].'" class="slide" title="'.$sliders[$i]['title'].'"/>
						</div>
				</a>';
		}
	}
}
?>