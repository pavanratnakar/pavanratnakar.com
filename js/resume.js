// <![CDATA[
$(document).ready(function()
{
	$('#resumeContainer dt').live('click',function()
	{
		var dd = $(this).next();
		// If the title is clicked and the dd is not currently animated,
		// start an animation with the slideToggle() method.
		if(!dd.is(':animated')){
			dd.slideToggle();
			$(this).toggleClass('opened');
		}
	});
	$('.expand').click(function(){
		// To expand/collapse all of the FAQs simultaneously,
		// just trigger the click event on the DTs
		if($(this).html()=='Expand All')
		{
			$('dt:not(.opened)').click();
			$(this).html('Collapse All');
		}
		else 
		{
			$('dt.opened').click();
			$(this).html('Expand All');
		}
		return false;
	});
	$(".resumebox").colorbox({scrolling: false});
});
// ]]>