// <![CDATA[
/// JQUERY EXTEND FUNCTIONS ///
$.fn.center = function () 
{
	this.css("position","fixed");
    this.css("top", ( $(window).height() - this.height() ) / 2+ "px");
    this.css("left", ( $(window).width() - this.width() ) / 2+ "px");
    return this;
}
$.fn.defaultText = function(value)
{
	var element = this.eq(0);
	element.data('defaultText',value);
	element.focus(function()
	{
		if(element.val() == value){
		
			element.val('').removeClass('defaultText');
		}
	}).blur(function()
	{
		if(element.val() == '' || element.val() == value)
		{
			element.addClass('defaultText').val(value);
		}
	});
	return element.blur();
}
/// JQUERY EXTEND FUNCTIONS ///
// ]]>