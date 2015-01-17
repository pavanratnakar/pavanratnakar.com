<?php
	include("html_to_doc.inc.php");
	$htmltodoc= new HTML_TO_DOC();
	$htmltodoc->createDocFromURL("http://www.packelite.com/2d/resume/text.php","Pavan_Ratnakar_Resume");
	$respose=array(
		"status"=>1,
		"text"=>"Word Document Updated"
		);
	echo json_encode($respose);
?>