// <![CDATA[
/// DEFINE PAVAN POPUP CLASS ///
var pavan_popup = {
	first : 1,
	hiddenRight : "",
	navR : false,
	navL : false,
	ps_album : $('#ps_albums'),
	ps_slider : $('#ps_slider'),
	ps_container : $('#ps_container'),
	ps_overlay : $('#ps_overlay'),
    ps_ad : $('#ps_ad'),
	ps_close : $('#ps_close'),
	ps_next_photo : $('#ps_next_photo'),
	container : $("#ps_albums .ps_album"),
	positions :	{
	'0'	: 0,
	'1'	: 170,
	'2'	: 340,
	'3'	: 510,
	'4'	: 680
	},
	data: "",
	waveId: "",
	currentId: "",
	init : function()
	{
		/// let's position all the albums on the right side of the window ///
		this.hiddenRight = $(window).width() - this.ps_album.offset().left;
		this.ps_album.children('div').css('left',this.hiddenRight + 'px');
		/// let's position all the albums on the right side of the window ///
		/// move the first 5 albums to the viewport ///
		this.ps_album.children('div:lt(5)').each(function(i)
		{
			$(this).animate({'left': pavan_popup.positions[i] + 'px','opacity':1},800,function()
			{
				if(pavan_popup.ps_album.children().length > 5)
				{
					pavan_popup.enableNavRight();
				}
			});
		});
		/// move the first 5 albums to the viewport ///
		/// NEXT ALBUM ///
		this.ps_slider.find('.next').live('click',function()
		{
			pavan_popup.popUpClickRight.click();
		});
		/// PREVIOUS ALBUM ///
		this.ps_slider.find('.prev').live('click',function()
		{
			pavan_popup.popUpClickLeft.click();
		});
		/// CLOSE POPUP EVENT ///
		this.ps_close.live('click',function()
		{
			pavan_popup.close();
		});
		/// HOVER IMAGE EVENT ///
		this.ps_container.live('mouseenter',function()
		{
			$('#ps_next_photo').show();
		}).live('mouseleave',function()
		{
			$('#ps_next_photo').hide();
		});
		/// GALLERY NAVIGATE EVENT ///
		this.ps_next_photo.live('click',function()
		{
			pavan_gallery.galleryNext();
		});
	},
	gadgetClick : function()
	{
		pavan_videoPlayer.videoPlayer();
		this.popUpShow();
		pavan_shareThis.shareThisModify();
	},
	movieClick : function()
	{
		pavan_movie.data=this.data;
		pavan_movie.changeMovie();
		pavan_comment.commentSectionChange();
		pavan_shareThis.image=this.data.images[0].url;
		pavan_shareThis.description=this.data.overview;
		pavan_facebook.changeFBLike('.movieLike','http://www.pavanratnakar.com/movie/'+this.data.tmdbId);
		pavan_shareThis.shareThisModify();
	},
	popUpClickRight : {
		type : "",
		movieIds: "",
		click : function()
		{
			if(!pavan_popup.ps_album.children('div:eq('+parseInt(pavan_popup.first+5-1)+')').length || !pavan_popup.navR) 
			{
				return;
			}
			this.type=$("#ps_albums").attr('class');
			var i=0;
			var temp="";
			pavan_popup.container=$("#ps_albums .ps_album");
			pavan_popup.container.each(function()
			{
				temp=temp+pavan_popup.container.eq(i).attr('id').replace('tmdb-','');
				if(i<(pavan_popup.container.length-1))
				{
					temp=temp+',';
				}
				i++;
				
			});
			pavan_popup.popUpClickRight.movieIds=temp;
			if(this.type=='movie')
			{
				var nextMovie = $.manageAjax.create('nextMovie'); 
				nextMovie.add(
				{
					success: function(html) 
					{	
						$.ajax({
							url: "http://www.pavanratnakar.com/controller/ajaxController.php",
							data: "ref=nextMovie&movieIds="+pavan_popup.popUpClickRight.movieIds,
							dataType: "json",
							type: "POST",
							cache: true,
							success:function(data)
							{
								pavan_movie.data=data.movieArray;
								pavan_movie.nextMovie();
							}
						})
					}
				});
			}
			pavan_popup.disableNavRight();
			pavan_popup.disableNavLeft();
			pavan_popup.moveRight();
		}
	},
	popUpClickLeft : {
		click : function()
		{		
			if(pavan_popup.first==1  || !pavan_popup.navL) return;
			pavan_popup.disableNavRight();
			pavan_popup.disableNavLeft();
			pavan_popup.moveLeft();
		}
	},
	disableNavRight : function() 
	{
		this.navR = false;
		this.ps_slider.find('.next').addClass('disabled');
	},
	disableNavLeft : function()
	{
		this.navL = false;
		this.ps_slider.find('.prev').addClass('disabled');
	},
	enableNavRight : function() 
	{
		this.navR = true;
		this.ps_slider.find('.next').removeClass('disabled');
	},
	enableNavLeft : function()
	{
		this.navL = true;
		this.ps_slider.find('.prev').removeClass('disabled');
	},	
	moveRight : function()
	{
		var hiddenLeft 	= this.ps_album.offset().left + 163;
		var cnt = 0;
		this.ps_album.children('div:eq('+(pavan_popup.first-1)+')').animate({'left': - hiddenLeft + 'px','opacity':0},500,function()
		{
			pavan_popup.ps_album.children('div').slice(pavan_popup.first,parseInt(pavan_popup.first+4)).each(
			function(i)
			{
				$(this).animate({'left': pavan_popup.positions[i] + 'px'},800,function()
				{
					++cnt;
					if(cnt == 4)
					{
						pavan_popup.ps_album.children('div:eq('+parseInt(pavan_popup.first+5-1)+')').animate({'left': pavan_popup.positions[cnt] + 'px','opacity':1},500,function()
						{
							//$this.hide();
							++pavan_popup.first;
							if(parseInt(pavan_popup.first + 4) < pavan_popup.ps_album.children().length)
							{
								pavan_popup.enableNavRight();
							}
							pavan_popup.enableNavLeft();
						});
					}
			
				});
			});
		});
	},
	moveLeft : function() 
	{
		this.hiddenRight	=	$(window).width() - this.ps_album.offset().left;
		var cnt			=	0;
		var last		=	this.first+4;
		this.ps_album.children('div:eq('+(last-1)+')').animate({'left': this.hiddenRight + 'px','opacity':0},500,function()
		{
			pavan_popup.ps_album.children('div').slice(parseInt(last-5),parseInt(last-1)).each(function(i)
			{
				$(this).animate({'left': pavan_popup.positions[i+1] + 'px'},800,function()
				{
					++cnt;
					if(cnt == 4)
					{
						pavan_popup.ps_album.children('div:eq('+parseInt(last-5-1)+')').animate({'left': pavan_popup.positions[0] + 'px','opacity':1},500,function()
						{
							//$this.hide();
							--pavan_popup.first;
							pavan_popup.enableNavRight();
							if(pavan_popup.first > 1)
							{
								pavan_popup.enableNavLeft();
							}
						});
					}
				});
			});
		});
	},
	popUpShow : function ()
	{
        this.showad();
        this.ps_container.show();
        this.ps_overlay.show();
        this.ps_container.center();
        this.ps_close.show();
	},
    showad : function () {
        if( !this.ps_ad.children('.lazyload_ad').get(0) ) {
            this.ps_ad.html(
                '<div class="lazyload_ad" original="http://pagead2.googlesyndication.com/pagead/show_ads.js">\
                    <code>\
                        <!--\
                        google_ad_client = "ca-pub-7513206858623669";\
                        google_ad_slot = "9844814082";\
                        google_ad_width = 468;\
                        google_ad_height = 60;\
                        //-->\
                    </code>\
                </div>');
            this.ps_ad.children('.lazyload_ad').lazyLoadAd({
                threshold    :  0,      // You can set threshold on how close to the edge ad should come before it is loaded. Default is 0 (when it is visible).
                forceLoad    :  true,   // Ad is loaded even if not visible. Default is false.
                timeout      :  20,      // Timeout ad load
                onLoad       :  false,
                onComplete   :  function() {
                    pavan_popup.ps_ad.children('.lazyload_ad').css({left:(($('body').width() - 468) / 2)+'px'});
                }
            });
        }
        this.ps_ad.show();
    },
	close : function()
	{
		$(".loading").remove();
        this.ps_ad.hide();
		this.ps_container.hide();
		this.ps_close.hide();
		this.ps_overlay.fadeOut(400);
	}
}
/// DEFINE PAVAN POPUP CLASS ///
/// DEFINE PAVAN SLIDER CLASS ///
var pavan_slider =
{
	data : ""
}
/// DEFINE PAVAN SLIDER CLASS ///
$(window).resize(function() 
{
	$("#ps_container").center();
});
$(document).ready(function()
{
	pavan_popup.init();
	
	$('.ps_album').live('click',function()
	{
		var $elem = $(this);
		pavan_popup.waveId=$('#wave').attr('class').replace('wave-','');

		var $loading 	= $('<div />',{className:'loading'});
		var $type=$elem.parent().attr('class');

		pavan_shareThis.url=$("meta[property='og:url']").attr("content");
		pavan_shareThis.title=$("meta[property='og:title']").attr("content")+' : '+$elem.children('.ps_desc').children('h3').html();
		pavan_shareThis.image=$elem.children('img').attr('src')
		pavan_shareThis.description=$elem.children('.ps_desc').children('span').html();

		$elem.append('<div class="loading"></div>');
		if($type=='gallery')
		{
			var album_name = $(this).attr('id');
			pavan_popup.currentId=pavan_popup.currentId.replace('album','');
			var gallery = $.manageAjax.create('gallery');
			gallery.add(
			{
				success: function(html) 
				{
					jQuery.ajax(
					{
						url: "http://www.pavanratnakar.com/controller/ajaxController.php?ref=galleryChange&album_name="+album_name+"&albumId="+pavan_popup.currentId+"&waveId="+pavan_popup.waveId+"&jsoncallback=?",
						dataType: "json",
						type: "GET",
						cache: true,
						beforeSend: function() {},
						success:function(data)
						{
							pavan_gallery.data=data.files;
							pavan_gallery.showGallery();
							pavan_comment.data = data;
							pavan_comment.commentSectionChange();
						}
					})
				}
			});
		}
		else if($type=='gadget')
		{
			pavan_videoPlayer.videoLink= $(this).children('a.trailer_video').html();
			pavan_popup.currentId=$(this).attr('id').replace('gadget','');
			pavan_popup.gadgetClick();
			var gadget_comment = $.manageAjax.create('gadget_comment');
			gadget_comment.add(
			{
				success: function(html) 
				{
					jQuery.ajax(
					{
						url: "http://www.pavanratnakar.com/controller/ajaxController.php?ref=gadgetChange&gadgetId="+pavan_popup.currentId+"&waveId="+pavan_popup.waveId+"&jsoncallback=?",
						dataType: "json",
						type: "GET",
						cache: true,
						beforeSend: function() {},
						success:function(data)
						{
							pavan_comment.data = data;
							pavan_comment.commentSectionChange();
						}
					});
				}
			});
		}
		else if($type=='movie')
		{
			pavan_popup.currentId= $(this).attr('id').replace('tmdb-','');
			var movie = $.manageAjax.create('movie');
			movie.add(
			{
				success: function(html) 
				{
					jQuery.ajax(
					{
						url: "http://www.pavanratnakar.com/controller/ajaxController.php?ref=movieChange&tmdbId="+pavan_popup.currentId+"&waveId="+pavan_popup.waveId+"&jsoncallback=?",
						data: "",
						dataType: "json",
						type: "GET",
						cache: true,
						beforeSend: function() {},
						success:function(data)
						{
							var title=null;
							$(".movieMainSlideshow").empty();
							for(var i=0;i<data.movieArray.images.length;i++)
							{
								$('.movieMainSlideshow').prepend('<img src="'+data.movieArray.images[i].url+'" alt="'+data.movieArray.movie_name+'" height="'+data.movieArray.images[i].height+'" width="'+data.movieArray.images[i].width+'" title="'+data.movieArray.movie_name+'"/>');
							}
							$('.movieMainSlideshow').cycle({
								fx: 'shuffle' // choose your transition type, ex: fade, scrollUp, shuffle, etc...
							});
							slider.data=new Array();
							title =data.movieArray.movie_name;
							first_name=title.substring(0,1);
							second=title.substring(1,title.length);
							slider.data.push({"id":'',"client":title,"desc":data.movieArray.tagline,"liter":first_name,"nav":second});
							slider.init();
							pavan_comment.data = data;
							pavan_popup.data = data.movieArray;
							pavan_popup.movieClick();
							$(".loading").remove();
						}
					})
				}
			});
		}
	});
});
// ]]>