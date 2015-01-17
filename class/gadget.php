<?php
require_once('xml.php');
require_once('functions.php');
class Gadget
{
	private $specificGadgetArray;
	public function __construct()
	{
		
	}
	public function getAllGadgets($gadgetId=0)
	{
		$xml=new XML();
		$gadget=$xml->readXML('gadget.xml');
		foreach($gadget->gadget as $gadget)
		{
			$gadget_array = array();
			$gadget_array['title'] = $gadget->title;
			$gadget_array['id'] = $gadget->id;
			$gadget_array['video'] = $gadget->video;
			$gadget_array['description'] = $gadget->description;
			if($gadget_array['id']!=$gadgetId)
			{
				
				$gadgets[] = $gadget_array;
			}
			else
			{
				$this->specificGadgetArray= $gadget_array;
			}
		}
		return $gadgets;
	}
	public function getPageSpecificGadgets($gadgetId=null)
	{
		if($gadgetId)
		{
			$function=new Functions();
			$gadgetId=$function->checkValues($_REQUEST['gadgetid']);
			$gadgets=$this->getAllGadgets($gadgetId);
			shuffle($gadgets);
			$parameterGadget=$this->specificGadgetArray;
			if($parameterGadget)
			{
				array_unshift($gadgets, $parameterGadget);
			}
		}
		else
		{
			$gadgets=$this->getAllGadgets();
			shuffle($gadgets);
		}
		return $gadgets;
	}
}
?>