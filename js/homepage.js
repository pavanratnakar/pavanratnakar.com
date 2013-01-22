// <![CDATA[
/// PAVAN HOMEPAGE CLASS ///
var pavan_homepage =
{
	init : function()
	{
		slider.init();
		this.clickBinding();
	},
	clickBinding : function()
	{
		$('p.images img').live('click',function() 
		{
			var newbg = $(this).attr('src').split('bg/bg')[1].split('-thumb')[0];
			$(document.body).css('backgroundImage', 'url(' + _siteRoot + 'galleryImages/bg/bg' + newbg + '.jpg)');
			$(this).parent().find('img').removeClass('on');
			$(this).addClass('on');
			return false;
		});
	}
}
/// PAVAN HOMEPAGE CLASS ///
$(document).ready(function()
{
	pavan_homepage.init();
});
/// SLIDER FUNCTION ///
if(!window.slider) 
{
	var slider={};
}
slider.data=new Array();
var title=null;
for(var i=1;i<=$("#slide-runner a").length;i++)
{
	title = $("#slide-img-"+i+" img").attr('title').split('|');
	first=title[1].substring(0,1);
	second=title[1].substring(1,title[1].length);
	slider.data.push({"id":"slide-img-"+(i),"client":title[0],"desc":$("#slide-img-"+(i)+" img").attr('alt'),"liter":first,"nav":second});
}
/// SLIDER FUNCTION ///
// ]]>