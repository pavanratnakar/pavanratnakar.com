// <![CDATA[
/// CLASS DEFINATION ///
/// DEFINE PAVAN VIDEO PLAYER ///
var pavan_videoPlayer =
{
	videoLink : "",
	videoPlayer: function()
	{
		pavan_popup.ps_container.html("<div id='player'></div>");
		$("#player").youTubeEmbed({
            width           : 800,
			video			: this.videoLink,
			progressBar 	: true
		});
        pavan_popup.ps_container.center();
        
	}
}
/// DEFINE PAVAN VIDEO PLAYER ///
/// DEFINE PAVAN FACEBOOK ///
var pavan_facebook =
{
	url:"",
	container:"",
	changeFBLike: function(container,url)
	{
		this.container=container;
		this.url=url;
		$(this.container).html('<fb:like href="'+this.url+'" send="true" layout="button_count" width="400" show_faces="true" colorscheme="dark" font="lucida grande"></fb:like>');
	}
}
/// DEFINE PAVAN FACEBOOK ///
/// DEFINE PAVAN SHARE CLASS ///
var pavan_shareThis =
{
	data:"",
	url:"",
	title:"",
	image:"",
	description:"",
	publisher:"c2dd522f-4617-4a40-9dc2-2d3ad357cab1",
	headerTitle:"Pavan Ratnakar Website",
	theme:"1",
	shareThisMain:'share_this_sharethis',
	shareThisGoogle:'share_this_google',
	shareThisFacebook:'share_this_facebook',
	init: function()
	{
		stLight.options({
		publisher:this.publisher,
		headerTitle:this.headerTitle,
		theme:this.theme
		});
	},
	shareThisModify: function()
	{
		$("#"+this.shareThisMain).html('');
		$("#"+this.shareThisGoogle).html('');
		$("#"+this.shareThisFacebook).html('');
		stWidget.addEntry({
			"service":"sharethis",
			"element":document.getElementById(this.shareThisMain),
			"url":this.url+'/'+pavan_popup.currentId,
			"title":this.title,
			"type":"large",
			"text":"ShareThis" ,
			"image":this.image,
			"summary":this.description
		});
		stWidget.addEntry({
			"service":"fblike",
			"element":document.getElementById(this.shareThisFacebook),
			"url":this.url+'/'+pavan_popup.currentId,
			"title":this.title,
			"type":"hcount",
			"text":"ShareThis" ,
			"image":this.image,
			"summary":this.description
		});
		stWidget.addEntry({
			"service":"plusone",
			"element":document.getElementById(this.shareThisGoogle),
			"url":this.url+'/'+pavan_popup.currentId,
			"title":this.title,
			"type":"button",
			"text":"ShareThis" ,
			"image":this.image,
			"summary":this.description
		});
	}
}
/// DEFINE PAVAN SHARE CLASS ///
var pavan =
{
	init : function()
	{
		/// CHECK IF IE 7 or BELOW ///
		if ($.browser.msie && $.browser.version.substr(0,1)<=7) 
		{
			window.location = "http://www.pavanratnakar.com/compatiblity";
		}
		/// CHECK IF IE 7 or BELOW ///
		/// COMMENT SCROLLAR
		if(this.gup('scrollto'))
		{
			this.goToByScroll(this.gup('scrollto'));
		}
		/// COMMENT SCROLLAR
		/// PANEL INIT ///
		pavan_panel.init();
		/// PANEL INIT ///
		/// LOGOUT EVENTS ///
		$('#facebookLogout').livequery("click", function(e)
		{
			pavan.logout.type=1;
			pavan.logout.logoutUser();
		});
		$('#normalLogout').livequery("click", function(e)
		{
			pavan.logout.type=0;
			pavan.logout.logoutUser();
		});
		if($('#greetingUser').html()=='Hello !')
		{
			pavan.logout.type=1;
			pavan.logout.logoutUser();
			window.location.reload();
		};
		/// LOGOUT EVENTS ///
		/// SHARE THIS ///
		pavan_shareThis.init();
		/// SHARE THIS ///
	},
	gup : function (name)
	{
	  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	  var regexS = "[\\?&]"+name+"=([^&#]*)";
	  var regex = new RegExp( regexS );
	  var results = regex.exec( window.location.href );
	  if( results == null )
		return "";
	  else
		return results[1];
	},
	goToByScroll : function(id)
	{
		if( jQuery('#'+id).get(0) ) 
		{
			var op = jQuery.browser.opera ? jQuery("html") : jQuery("html, body");
			jQuery("#"+id).animate({"opacity": "0.4"}, "fast");
			op.animate({ scrollTop: jQuery("#"+id).offset().top-100}, 3000,function()
			{
				jQuery("#"+id).animate({"opacity": "1"}, "slow");
			});
		}
	},
	logout : {
		type : "",
		logoutUser : function()
		{
			var facebookLogout = $.manageAjax.create('facebookLogout'); 
			facebookLogout.add(
			{
				success: function(html) 
				{
					jQuery.ajax(
					{
						url: "http://www.pavanratnakar.com/include/controller.php?ref=logout&jsoncallback=?",
						dataType: "json",
						cache: true,
						beforeSend: function() {},
						success:function(data)
						{
							if(pavan.logout.type==1)
							{
								FB.logout(function(response) 
								{
									window.location.reload();
								});
							}
							else
							{
								window.location.reload();
							}
						}
					});
				}
			});
		}
	}
}
var pavan_panel = {
	type : "",
	init : function ()
	{
		$("#open").live('click',function()
		{
			pavan_panel.type="open";
			pavan_panel.panelLoad();
		});
		$("#close").live('click',function(){
			$("div#panel").slideUp("slow")
			$(this).hide();
			$(this).prev().show();
		});
		$("#openSlide").live('click',function(){
			if($(this).html()=='Log In | Register')
			{
				$('#registerForm')[0].reset();
				$('#loginForm')[0].reset();
				registerValidator.resetForm();
				loginValidator.resetForm();
			}
			$('html, body').animate({scrollTop:0}, 'slow',function()
			{
				pavan_panel.type="open";
				pavan_panel.panelLoad();
			});
		});
	},
	panelLoad : function()
	{
		var topPanelLoad = $.manageAjax.create('topPanelLoad'); 
		topPanelLoad.add(
		{
			success: function(html) 
			{
				jQuery.ajax(
				{
					url: "http://www.pavanratnakar.com/controller/ajaxController.php?ref=getPanelContent",
					dataType: "html",
					type: "GET",
					cache: true,
					beforeSend: function() {},
					success:function(data1)
					{
						if(pavan_panel.type=="open")
						{
							/// FACEBOOK INTEGRATION
							facebookFunction();
							FB.Event.subscribe('auth.login', function(response) 
							{
								var facebookUserCheck = $.manageAjax.create('facebookUserCheck'); 
								facebookUserCheck.add(
								{
									success: function(html) 
									{
										jQuery.ajax(
										{
											url: "http://www.pavanratnakar.com/include/controller.php?ref=facebookcheck&jsoncallback=?",
											dataType: "json",
											cache: true,
											beforeSend: function() {},
											success:function(data)
											{
												window.location.reload();
											}
										});
									}
								});
							});
							/// FACEBOOK INTEGRATION
							$("div#panel").html(data1);
							$("div#panel").slideDown("slow");
							$("#open").hide();
							$("#open").next().show();
							slider1();
						}
					}
				});
			}
		});
	}
}
/// CLASS DEFINATION ///
var app_id='100184653364726';
var app_secret='58faf0b31b72c3a727fa04de1b53b553';
var tabs = {
	"@tutorialzine" : {
		"feed"		: "http://twitter.com/statuses/user_timeline/140623230.rss",
		"function"	: twitter
	},
	
	"@Buzz"	: {
		"feed"		: "http://buzz.googleapis.com/feeds/105657677244847005118/public/posted",
		"function"	: buzz
	}
}

/// FACEBOOK FUNCTION
function facebookFunction()
{
	//FB.init({appId: '100184653364726', status: true, cookie: true, xfbml: true});
}
/// FACEBOOK FUNCTION
///TWITTER AND BUZZ
function updateAllTabs()
{
	///SOCIAL UPDATES
	jQuery.ajax(
	{
		url: "http://www.pavanratnakar.com/controller/ajaxController.php?ref=footerSocial&jsoncallback=?",
		dataType: "json",
		cache: true,
		success:function(data)
		{
			if(data.facebook_wall.wallArray)
			updateTab(data.facebook_wall.wallArray,'facebookPosts','facebook');
			if(data.twiteer_tweets)
			updateTab(data.twiteer_tweets,'tweets','twitter');
			if(data.comment)
			{
				facebookFunction();
				updateTab(data.comment,'recentComments','recentComments');
			}
		}
	});
	///SOCIAL UPDATES
}
function showTab(data,div,type)
{
	var obj = type;
	if(!obj) return false;
	$('#'+div).empty();
	if(data.length)
	{
		for(var i=0;i<data.length;i++)
		{
			postAnimation('append',div,data[i],obj)
		}
	}
}
function updateTab(data,div,type,obj)
{
	var obj = type;
	if(!obj) return false;
	if(data.length)
	{
		for(var i=(data.length-1);i>-1;i--)
		{
			if($('#'+div+' li').eq(i).attr('id')==data[i].id)
			{
				$('#'+div+' li .postContainer .postTime').eq(i).html(data[i].pubDate).fadeIn('slow');
			}
			else
			{
				$('#'+div+' li').eq(i).animate({"height": "toggle", "opacity": "toggle"}, "slow")
				$('#'+div+' li').eq(i).remove();
				postAnimation('prepend',div,data[i],obj)
			}
		}
	}
}
function postAnimation(type,div,data,obj)
{	
	var lidiv='';
	var height='';
	var stage = $('#'+div);
	if(type=='prepend')
	{
		stage.prepend(window[obj](data));
	}
	else
	{
		stage.append(window[obj](data));
	}
	lidiv=$('#'+div+' li#'+data.id);
	height=lidiv.height();
	lidiv.css({'height':(height)+'px'});
	lidiv.hide();
	lidiv.animate({"height": "toggle", "opacity": "toggle"}, "slow");
}
function twitter(item)
{
	/* Formats the tweets, by turning hashtags, mentions an URLS into proper hyperlinks: */
	return $('<li>').html('<i class="iconsSprite left"></i><div class="postContainer">'
			+formatString(item.description.replace('pavanratnakar: ','') || item.title)+
			'<div class="postTime">'+item.pubDate+'</div><a class="button" href="'+(item.link || item.origLink)+'" target="_blank">read</a></div>'
	).addClass('post').attr({'id':item.id});
}
function facebook(item)
{
	/* Formats the facebook wall */
	var link='http://www.facebook.com/#!/profile.php?id='+item.profile_id+'&v=wall&story_fbid='+item.component_id;
	return $('<li>').html('<i class="iconsSprite left"></i><div class="postContainer">'
			+formatString(item.message)+
			'<div class="postTime">'+item.pubDate+'</div><a class="button" href="'+(link)+'" target="_blank">read</a></div>'
	).addClass('post').attr({'id':item.id});
}
function rss(item)
{
	return $('<li>').html('<i class="iconsSprite left"></i>'+
			formatString(item.title.content || item.title)+
			' <a href="'+(item.origLink || item.link[0].href || item.link)+'" target="_blank">[read]</a>'
	);
}
function buzz(item)
{
	return $('<li>').html('<i class="iconsSprite left"></i><div class="postContainer">'+
			formatString(item.content[0].content || item.title.content || item.title)+
			'<div class="postTime">'+item.pubDate+'</div><a class="button" href="'+(item.origLink || item.link[0].href || item.link)+'" target="_blank">read</a></div>'
	);
}
function recentComments(item)
{
	return $('<li>').html('<i class="iconsSprite left"></i><div class="postContainer">'+
			item.name+' : '+formatString(item.content)+
			'<div class="postTime">'+item.pubDate+'</div><a class="button" href="http://www.pavanratnakar.com/'+(item.link)+'?scrollto=com-'+item.id+'">read</a></div>'
	);
}
function formatString(str)
{
	/* This function was taken from our Twitter Ticker tutorial - http://tutorialzine.com/2009/10/jquery-twitter-ticker/ */
	str = str.replace(/<[^>]+>/ig,'');
	str=' '+str;
	str = str.replace(/((ftp|https?):\/\/([-\w\.]+)+(:\d+)?(\/([\w/_\.]*(\?\S+)?)?)?)/gm,'<a href="$1" target="_blank">$1</a>');
	str = str.replace(/([^\w])\@([\w\-]+)/gm,'$1@<a href="http://twitter.com/$2" target="_blank">$2</a>');
	str = str.replace(/([^\w])\#([\w\-]+)/gm,'$1<a href="http://twitter.com/search?q=%23$2" target="_blank">#$2</a>');
	return str;
}
///TWITTER AND BUZZ
function magicLine()
{
    var $el, leftPos, newWidth,
    $mainNav = $("#navgiationMenu");
    $mainNav.append("<li id='magic_line1' class='magic_line'></li>");
	$mainNav.prepend("<li id='magic_line2' class='magic_line'></li>");
    var $magicLine = $(".magic_line");
	if($(".current_page_item a").position())
	{
		$magicLine
			.width($(".current_page_item").width())
			.css("left", $(".current_page_item a").position().left)
			.data("origLeft", $magicLine.position().left)
			.data("origWidth", $magicLine.width());
		$("#navgiationMenu li").find("a").hover(function() 
		{
			$el = $(this);
			leftPos = $el.position().left;
			newWidth = $el.parent().width();
			$magicLine.stop().animate({
				left: leftPos,
				width: newWidth
			});
		}, function() 
		{
			$magicLine.stop().animate({
				left: $magicLine.data("origLeft"),
				width: $magicLine.data("origWidth")
			});    
		});
	}
	else
	{
		$("#navgiationMenu li").find("a").hover(function() 
		{
			$el = $(this);
			leftPos = $el.position().left;
			newWidth = $el.parent().width();
			$magicLine.stop().animate({
				left: leftPos,
				width: newWidth
			});
		}, function() 
		{
			$magicLine.stop().animate({
				left: "0",
				width: "0"
			});    
		});
	}
}
function slider1()
{
	/// DATETIMEPICKER FOR REGISTRATION
	$( "#registerBirthDate" ).datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: '1900:2011',
		showAnim: 'bounce'
	});
	/// DATETIMEPICKER FOR REGISTRATION
	/// REGISTER VALIDATOR
	var registerValidator=$("#registerForm").validate({
		errorClass: "error",
		rules: {
			firstname: {
				required: true,
				minlength: 2
			},
			lastname: {
				required: true,
				minlength: 2
			},
			password: {
				password: "#firstname"
			},
			email: {
				required: true,
				email: true
			},
			sexSelect: {
				required: true
			},
			registerBirthDate: {
				required: true,
				date: true
			}
		},
		messages: {
			firstname: {
				required: "Please enter a firstname",
				minlength: jQuery.format("Your firstname must consist of at least {0} characters")
			},
			lastname: {
				required: "Please enter a lastname",
				minlength: jQuery.format("Your lastname must consist of at least {0} characters")
			},
			sexSelect: {
				required: "Please select your sex"
			},
			email: "Please enter a valid email address",
			registerBirthDate: {
				required: "Please select your birthday",
				date: "Please enter a valid date"
			}
		},
		errorPlacement: function(error, element) 
		{
			error.appendTo($("#registerStatus"));
		},
		submitHandler: function() 
		{
			var firstname=$('#registerFirstname').val();
			var lastname=$('#registerLastname').val();
			var email=$('#registerEmail').val();
			var password=$('#registerPassword').val();
			var sexSelect=$('#sexSelect').val();
			var birthDate=$('#registerBirthDate').val();
			var registerUser = $.manageAjax.create('registerUser'); 
			registerUser.add(
			{
				success: function(html) 
				{
					jQuery.ajax(
					{
						url: "http://www.pavanratnakar.com/include/controller.php",
						data: "ref=register&firstname="+firstname+"&lastname="+lastname+"&email="+email+"&password="+password+"&sexSelect="+sexSelect+"&birthDate="+birthDate+"&jsoncallback=?",
						dataType: "json",
						type: "POST",
						cache: true,
						beforeSend: function() {},
						success:function(data)
						{
							if(data.status)
							{
								$("#panelRegister").slideUp("slow",function()
								{
									$("#registerForm").empty();
									$("<h2>").html(data.message[0]).prependTo("#panelRegister");
									$("#panelRegister").slideDown("slow");
								});
							}
							else
							{
								$("<label>").attr({"generated":"true","class":"error"}).html(data.message[0]).appendTo("#registerStatus");
							}
						}
					});
				}
			});
		},
		success: function(label) {
			label.html("").addClass("checked");
		}
	});
	/// REGISTER VALIDATOR
	/// LOGIN VALIDATOR
	var loginValidator=$("#loginForm").validate({
		errorClass: "error",
		rules: {
			password: {
				required: true,
				minlength: 5
			},
			email: {
				required: true,
				email: true
			}
		},
		messages: {
			password: {
				required: "Please provide a password",
				minlength: jQuery.format("Your password must be at least {0} characters")
			},
			email: "Please enter a valid email address"
		},
		errorPlacement: function(error, element) 
		{
			error.appendTo($("#loginStatus"));
		},
		submitHandler: function() 
		{
			var email=$('#loginEmail').val();
			var password=$('#loginPassword').val();
			var rememberMe=$('#rememberMe').val();
			var loginUser = $.manageAjax.create('loginUser'); 
			loginUser.add(
			{
				success: function(html) 
				{
					jQuery.ajax(
					{
						url: "http://www.pavanratnakar.com/include/controller.php",
						data: "ref=login&email="+email+"&password="+password+"&rememberMe="+rememberMe+"&jsoncallback=?",
						dataType: "json",
						type: "POST",
						cache: true,
						beforeSend: function() {},
						success:function(data)
						{
							if(data.status)
							{
								registerValidator.resetForm();
								window.location = window.location.href
							}
							else
							{
								$("<label>").attr({"generated":"true","class":"error"}).html(data.message[0]).appendTo("#loginStatus");
							}
						}
					});
				}
			});
		},
		success: function(label) {
			label.html("").addClass("checked");
		}
	});
	/// LOGIN VALIDATOR
}
$(document).ready(function()
{
	pavan.init();
	slider1();
	///SOCIAL UPDATES
	jQuery.ajax(
	{
		url: "http://www.pavanratnakar.com/controller/ajaxController.php?ref=footerSocial&jsoncallback=?",
		dataType: "json",
		cache: true,
		beforeSend: function()
		{
			$(".socialContainer").addClass('loading_new');
		},
		success:function(data)
		{	
			if(data.facebook_wall.wallArray)
			{
				$("#facebookPosts").empty();
				showTab(data.facebook_wall.wallArray,'facebookPosts','facebook');
			}
			else
			{
				$("#facebookPosts").html('<li><i class="iconsSprite left"></i><div class="postContainer">Facebook feed could not load. Please try after sometime.</div></li>')
			}
			if(data.twiteer_tweets)
			{
				$("#tweets").empty();
				showTab(data.twiteer_tweets,'tweets','twitter');
			}
			else
			{
				$("#tweets").html('<li><i class="iconsSprite left"></i><div class="postContainer">Tweets could not load. Please try after sometime.</div></li>')
			}
			if(data.buzz)
			{
				$("#buzz").empty();
				showTab(data.buzz,'buzz','buzz');
			}
			else
			{
				$("#buzz").html('<li><i class="iconsSprite left"></i><div class="postContainer">Buzz feed could not load. Please try after sometime.</div></li>')
			}
			if(data.comment)
			{
				facebookFunction();
				$("#recentComments").empty();
				showTab(data.comment,'recentComments','recentComments');
			}
			else
			{
				$("#recentComments").html('<li><i class="iconsSprite left"></i><div class="postContainer">No Comments Posted Yet.</div></li>')
			}
			$(".socialContainer").removeClass('loading_new');
		}
	});
	///SOCIAL UPDATES
	$('.socialColumn li').livequery("mouseenter", function(e)
	{
		$(this).find("i").animate({"opacity": "1","filter":"alpha(opacity = 100)"}, "slow");
	});
	$('.socialColumn li').livequery("mouseleave", function(e)
	{
		$(this).find("i").animate({"opacity": "0.5","filter":"alpha(opacity = 50)"}, "slow");
	});
	$('.socialIcon').livequery("mouseenter", function(e)
	{
		$(this).find("i").animate({"opacity": "0.5","filter":"alpha(opacity = 50)"}, "slow");	
	});
	$('.socialIcon').livequery("mouseleave", function(e)
	{
		$(this).find("i").animate({"opacity": "1","filter":"alpha(opacity = 100)"}, "slow");	
	});
	$('.contact-widget li').livequery("mouseenter", function(e)
	{
		var image=$(this).find("i");
		image.animate({"opacity": "1","filter":"alpha(opacity = 100)"}, "medium");
	});
	$('.contact-widget li').livequery("mouseleave", function(e)
	{
		var image=$(this).find("i");
		image.animate({"opacity": "0.5","filter":"alpha(opacity = 50)"}, "medium");
	});
	magicLine();
	/// FACEBOOK INTEGRATION

});
/// AUTO REFRESH FUNCTIONS
var auto_refresh = setInterval(
function ()
{
	updateAllTabs();
}, 60000); // refresh every 60000 milliseconds
/// AUTO REFRESH FUNCTIONS
///GOOGLE ANALYTICS CODE///
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-22528464-1']);
_gaq.push(['_setDomainName', '.pavanratnakar.com']);
_gaq.push(['_trackPageview']);
(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
///GOOGLE ANALYTICS CODE///
// ]]>