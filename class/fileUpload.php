<?php
require_once('db.php');
require_once ('functions.php');
require_once ('user.php');
session_name('pavanLogin');
// Starting the session
session_set_cookie_params(2*7*24*60*60);
// Making the cookie live for 2 weeks
session_start();
/**
 * Handle file uploads via XMLHttpRequest
 */
class qqUploadedFileXhr {
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {    
        $input = fopen("php://input", "r");
        $temp = tmpfile();
        $realSize = stream_copy_to_stream($input, $temp);
        fclose($input);
        if ($realSize != $this->getSize()){            
            return false;
        }
        $target = fopen($path, "w");        
        fseek($temp, 0, SEEK_SET);
        stream_copy_to_stream($temp, $target);
        fclose($target);
        return true;
    }
    function getName() {
		$pieces = explode(".", $_GET['qqfile']);
        return $_SESSION['uid'].date("YmdHis").'.'.$pieces[1];
    }
    function getSize() {
        if (isset($_SERVER["CONTENT_LENGTH"])){
            return (int)$_SERVER["CONTENT_LENGTH"];            
        } else {
            throw new Exception('Getting content length is not supported.');
        }      
    }   
}
/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
class qqUploadedFileForm {
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {
        if(!move_uploaded_file($_FILES['qqfile']['tmp_name'], $path)){
            return false;
        }
        return true;
    }
    function getName() {
		$pieces = explode(".", $_FILES['qqfile']['name']);
        return $_SESSION['uid'].date("YmdHis").'.'.$pieces[1];
    }
    function getSize() {
        return $_FILES['qqfile']['size'];
    }
}
class qqFileUploader {
    private $allowedExtensions = array();
    private $sizeLimit = 2048000;
    private $file;

    function __construct(array $allowedExtensions = array(), $sizeLimit = 2048000)
	{
        $db=new DB();
		$allowedExtensions = array_map("strtolower", $allowedExtensions);
        $this->allowedExtensions = $allowedExtensions;        
        $this->sizeLimit = $sizeLimit;       
        if (isset($_GET['qqfile'])) {
            $this->file = new qqUploadedFileXhr();
        } elseif (isset($_FILES['qqfile'])) {
            $this->file = new qqUploadedFileForm();
        } else {
            $this->file = false; 
        }
    }
    /**
     * Returns array('success'=>true) or array('error'=>'error message')
     */
    function handleUpload($uploadDirectory, $replaceOldFile = FALSE){
        if (!is_writable($uploadDirectory)){
            return array('error' => "Server error. Upload directory isn't writable.");
        }
        if (!$this->file){
            return array('error' => 'No files were uploaded.');
        }
        $size = $this->file->getSize();
        if ($size == 0) {
            return array('error' => 'File is empty');
        }
        if ($size > $this->sizeLimit) {
            return array('error' => 'File is too large');
        }
        $pathinfo = pathinfo($this->file->getName());
        $filename = $pathinfo['filename'];
        //$filename = md5(uniqid());
        $ext = $pathinfo['extension'];
        if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
            $these = implode(', ', $this->allowedExtensions);
            return array('error' => 'File has an invalid extension, it should be one of '. $these . '.');
        }
        if(!$replaceOldFile){
            /// don't overwrite previous files that were uploaded
            while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
                $filename .= rand(10, 99);
            }
        }
        if ($this->file->save($uploadDirectory . $filename . '.' . $ext))
		{
			$user=new User();
			$oldpic=$user->getProfilePic($_SESSION['uid']);
			if($oldpic!='nopic.jpg')
			{
				unlink("../images/profilePic/large/" . $oldpic);
				unlink("../images/profilePic/medium/" . $oldpic);
				unlink("../images/profilePic/small/" . $oldpic);
			}
			$this->reduceImageSize($uploadDirectory . $filename . '.' . $ext,200,200,"../images/profilePic/large/" . $filename . '.' . $ext);
			$this->reduceImageSize($uploadDirectory . $filename . '.' . $ext,100,80,"../images/profilePic/medium/" .  $filename . '.' . $ext);
			$this->reduceImageSize($uploadDirectory . $filename . '.' . $ext,50,50,"../images/profilePic/small/" .  $filename . '.' . $ext);
			unlink($uploadDirectory . $filename . '.' . $ext);
			$result=mysql_query("UPDATE ".USER_TABLE." SET profilepic = '".$filename . '.' . $ext."' WHERE uid='".$_SESSION['uid']."'");
            return array('success'=>true,'filename'=>$filename . '.' . $ext);
        }
		else 
		{
            return array('error'=> 'Could not save uploaded file.' .
                'The upload was cancelled, or server error encountered');
        }
    }
	function reduceImageSize($source_file,$width,$height,$source)
	{
		//To get the image width and height if you want to resize 
		list($img_width,$img_height) = getimagesize($source_file);  
		if($img_width<$width || $img_height<$height)
		{
			$width=$img_width;
			$height=$img_height;
		}
		$ratio_orig = $img_width/$img_height;
		if ($width/$height > $ratio_orig) 
		{
		   $width = $height*$ratio_orig;
		} else 
		{
		   $height = $width/$ratio_orig;
		}
		//Create a new true color image  
		$im = @imagecreatetruecolor($width, $height) or 
		die('Cannot Initialize new GD image stream');
		//Create a new image from file or URL 
		$img_source = imagecreatefromjpeg($source_file);
		//Copy and resize part of an image with resampling 
		imagecopyresampled($im, $img_source, 0, 0, 0, 0, $width, $height,$img_width, $img_height);
		//Output image to browser or file 
		imagejpeg($im,$source, 90);
		//Destroy an image 
		imagedestroy($im);  
		imagedestroy($img_source);
	}
}
// list of valid extensions, ex. array("jpeg", "xml", "bmp")
$allowedExtensions = array("jpeg", "jpg", "png" , "gif" , "bmp");
// max file size in bytes
$sizeLimit = 2048000;
$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
$result = $uploader->handleUpload('../images/profilePic/tmp/');
// to pass data through iframe you will need to encode all html tags
echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);