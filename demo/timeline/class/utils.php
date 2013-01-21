<?php
class Utils
{
	private $ajax;
	private $path;
	public function __construct()
	{

	}
	public function checkValues($value)
	{
		$value= nl2br($value);
		$value = trim($value);
		if (get_magic_quotes_gpc()) 
		{
			$value = stripslashes($value);
		}
		$value = strtr($value,array_flip(get_html_translation_table(HTML_ENTITIES)));
		$value = strip_tags($value,'<br>');
		return $value;
	}
	public function ip_address_to_number($IPaddress)
	{
		if ($IPaddress == "") {
			return 0;
		} else 
		{
			return ip2long($IPaddress);
		}
	}
}
?>