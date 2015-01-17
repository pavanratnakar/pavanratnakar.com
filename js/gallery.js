// <![CDATA[
/// DEFINE PAVAN GALLERY CLASS ///
var pavan_gallery =
{
	data : "",
	resize : {
		containerwidth : 460,
		containerheight : 330,
		resizeCenterImage : function($image)
		{
			var theImage 	= new Image();
			theImage.src 	= $image.attr("src");
			var imgwidth 	= theImage.width;
			var imgheight 	= theImage.height;
			$($image).ready(function()
			{
				imgwidth = theImage.width;
				imgheight = theImage.height;
				if(imgwidth	> pavan_gallery.resize.containerwidth)
				{
					if((imgheight / (imgwidth / pavan_gallery.resize.containerwidth)) > pavan_gallery.resize.containerheight)
					{
						theImage.width = pavan_gallery.resize.containerwidth/((imgheight / (imgwidth / pavan_gallery.resize.containerwidth))/pavan_gallery.resize.containerheight);
						theImage.height= pavan_gallery.resize.containerheight;
					}
					else
					{
						theImage.width = pavan_gallery.resize.containerwidth;
						theImage.height= imgheight / (imgwidth / pavan_gallery.resize.containerwidth);
					}
				}
				else if(imgheight > pavan_gallery.resize.containerheight)
				{
					if((imgwidth / (imgheight / pavan_gallery.resize.containerheight)) > pavan_gallery.resize.containerwidth)
					{
						theImage.height = pavan_gallery.resize.containerheight/((imgwidth / (imgheight / pavan_gallery.resize.containerheight))/pavan_gallery.resize.containerwidth);
						theImage.width= pavan_gallery.resize.containerwidth;
					}
					else
					{
						theImage.width = imgwidth / (imgheight / pavan_gallery.resize.containerheight);
						theImage.height= pavan_gallery.resize.containerheight;
					}
				}
				$image.css({
					'width'			:theImage.width,
					'height'		:theImage.height,
					'margin-top'	:-(theImage.height/2)-10+'px',
					'margin-left'	:-(theImage.width/2)-10+'px'
				});
			});
		}
	},
	showGallery: function()
	{
		var items_count	= this.data.length;
		var item_source = '';
		var cnt = r = 0;
		pavan_popup.ps_container.find('img').remove();
		for(var i = 0; i < items_count; ++i)
		{
			item_source = this.data[i].replace('../','');
			$('<img />').load(function()
			{
				var $image = $(this);
				++cnt;
				pavan_gallery.resize.resizeCenterImage($image);
				pavan_popup.ps_container.append($image);
				r = Math.floor(Math.random()*41)-20;
				if(cnt < items_count)
				{
					$image.css({
						'-moz-transform'	:'rotate('+r+'deg)',
						'-webkit-transform'	:'rotate('+r+'deg)',
						'transform'			:'rotate('+r+'deg)'
					});
				}
				if(cnt > 1)
				{
					$(".loading").remove();
					pavan_popup.popUpShow();
				}
			}).attr('src',item_source);
		}
		pavan_shareThis.shareThisModify();
	},
	galleryNext : function()
	{
		var $current 	= pavan_popup.ps_container.find('img:last');
		var r			= Math.floor(Math.random()*41)-20;
		var currentPositions = {
			marginLeft	: $current.css('margin-left'),
			marginTop	: $current.css('margin-top')
		}
		var $new_current = $current.prev();
		$current.animate({
			'marginLeft':'250px',
			'marginTop':'-385px'
		},250,function()
		{
			$(this).insertBefore(pavan_popup.ps_container.find('img:first')).css({
				'-moz-transform'	:'rotate('+r+'deg)',
				'-webkit-transform'	:'rotate('+r+'deg)',
				'transform'			:'rotate('+r+'deg)'
			}).animate({
				'marginLeft':currentPositions.marginLeft,
				'marginTop'	:currentPositions.marginTop
			},250,function()
			{
				$new_current.css({
					'-moz-transform'	:'rotate(0deg)',
					'-webkit-transform'	:'rotate(0deg)',
					'transform'			:'rotate(0deg)'
				});
			});
		});
	}
}
/// DEFINE PAVAN GALLERY CLASS ///
// ]]>