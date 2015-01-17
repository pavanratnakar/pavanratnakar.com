$(document).ready(function()
{
	if ($.browser.msie && $.browser.version.substr(0,1)<=7) 
	{
		/// DO NOTING
	}
	else
	{
		window.location = "home";
	}
});
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-22528464-1']);
_gaq.push(['_setDomainName', '.pavanratnakar.com']);
_gaq.push(['_trackPageview']);
(function() 
{
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();