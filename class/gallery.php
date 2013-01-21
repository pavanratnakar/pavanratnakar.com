<?php
require_once('xml.php');
require_once('functions.php');
class Gallery
{
	private $specificGalleryArray;
	public function __construct()
	{
	}
	public function showGallery($album_name)
	{
		$location 	= '../albums';
		$files 		= glob($location . '/' . $album_name . '/*.{JPG,jpg,gif,png}', GLOB_BRACE);
		shuffle($files);
		array_splice($files, 5);
		return $files;
	}
	public function getAllGalleries($galleryId=0)
	{
		$xml=new XML();
		$gallery=$xml->readXML('gallery.xml');
		foreach($gallery->gallery as $gallery)
		{
			$gallery_array = array();
			$gallery_array['title'] = $gallery->title;
			$gallery_array['id'] = $gallery->id;
			$gallery_array['description'] = $gallery->description;
			if($gallery_array['id']!=$galleryId)
			{
				
				$galleries[] = $gallery_array;
			}
			else
			{
				$this->specificGalleryArray=$gallery_array;
			}
		}
		return $galleries;
	}
	public function getPageSpecificGalleries($galleryId)
	{
		if($galleryId)
		{
			$function=new Functions();
			$galleryId=$function->checkValues($galleryId);
			$galleries=$this->getAllGalleries($galleryId);
			shuffle($galleries);
			$parameterGallery=$this->specificGalleryArray;
			if($parameterGallery)
			{
				array_unshift($galleries, $parameterGallery);
			}
		}
		else
		{
			$galleries=$this->getAllGalleries();
			shuffle($galleries);
		}
		return $galleries;
	}
}
?>