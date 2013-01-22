// <![CDATA[
$(document).ready(function()
{
	// TREE MENU
	$('#treeMenu ul li:has("div")').find('span:first').addClass('closed');
	$('#treeMenu ul li:has("div")').find('div').hide();	
	$('.parent').click (function ()
	{ 
		$(this).parent('li').find('span:first').toggleClass('opened');
		$(this).parent('li').find('div:first').slideToggle();
	});
	SyntaxHighlighter.defaults['gutter'] = true;
	SyntaxHighlighter.defaults['smart-tabs'] = true;
	SyntaxHighlighter.defaults['html-script'] = true;
	SyntaxHighlighter.defaults['collapse'] = false;
	SyntaxHighlighter.defaults['toolbar'] = false;
	SyntaxHighlighter.all();
});	
// ]]>