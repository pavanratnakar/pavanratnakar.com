// <![CDATA[
$(window).resize(function() 
{
	$("#ps_container").center();
	console.log('RESIZE');
	$("#windowBox").center();
});
jQuery.fn.center = function () 
{
	this.css("position","absolute");
    this.css("top", ( $(window).height() - this.height() ) / 2+$(window).scrollTop() + "px");
    this.css("left", ( $(window).width() - this.width() ) / 2+$(window).scrollLeft() + "px");
    return this;
}
$(document).ready(function(){
	/* This code is executed after the DOM has been completely loaded */
	/* The number of event sections / years with events */
	var tot=$('.event').length;
	$('.eventList li').click(function(e){
			showWindow('<div>'+$(this).find('div.content').html()+'</div>');
	});
	/* Each event section is 123 px wide */
	var timelineWidth = 123*tot;
	var screenWidth = $(document).width();
	$('#timelineScroll').width(timelineWidth);
	/* If the timeline is wider than the screen show the slider: */
	if(timelineWidth > screenWidth)
	{
		$('#scroll,#slider1').show();
		$('#centered,#slider1').width(50*tot);
		/* Making the scrollbar draggable: */
		$('#bar').width((32/123)*screenWidth).draggable({
			containment: 'parent',
			drag: function(e, ui) {
				if(!this.elem)
				{
					/* This section is executed only the first time the function is run for performance */
					this.elem = $('#timelineScroll');
					/* The difference between the slider's width and its container: */
					this.maxSlide = ui.helper.parent().width()-ui.helper.width();
					/* The difference between the timeline's width and its container */
					this.cWidth = this.elem.width()-this.elem.parent().width();
					this.highlight = $('#highlight');
				}
				/* Translating each movement of the slider to the timeline: */
				this.elem.css({marginLeft:'-'+((ui.position.left/this.maxSlide)*this.cWidth)+'px'});
				/* Moving the highlight: */
				this.highlight.css('left',ui.position.left)
				this.highlight.css('top',0)
			}
		});
		$('#highlight').width((32/123)*screenWidth-3);
	}
});
function showWindow1(data)
{
	var $ps_container 	= $('#ps_container');
	var $ps_overlay 	= $('#ps_overlay');
	var $ps_close		= $('#ps_close');
	var title = $('.title',data).text();
	var date = $('.date',data).text();
	var body = $('.body',data).html();
	$('.eventList li').click(function(e){
			/*showWindow('<div>'+$(this).find('div.content').html()+'</div>');*/
			$ps_container.html('<div id="windowBox"><div id="titleDiv">'+title+'</div>'+body+'<div id="date">'+date+'</div></div>');
			$ps_container.show();
			$("#windowBox").center();
			$ps_close.show();
			$ps_overlay.show();
	});

}
function showWindow(data)
{
	/* Each event contains a set of hidden divs that hold
	   additional information about the event: */
	var title = $('.title',data).text();
	var date = $('.date',data).text();
	var body = $('.body',data).html();
	var $ps_overlay 	= $('#ps_overlay');
	var $ps_close		= $('#ps_close');
	$ps_overlay.show();
	$ps_close.show();
	$ps_close.click(function(){
		$(this).hide();
		$('#windowBox').remove();
		$(".loading").remove();
		$ps_close.hide();
		$ps_overlay.fadeOut(400);
	});
	$('body').append('<div id="windowBox"><div id="titleDiv">'+title+'</div><div id="body">'+body+'</div><div id="date">'+date+'</div></div>');
	$('#windowBox').css({
		width:500,
		height:$("#windowBox").height()+parseInt(50),
		left: ($(window).width() - 500)/2,
		top: ($(window).height() - 350)/2
	});
	$("#windowBox").center();
}
// ]]>