// <![CDATA[
/// DEFINE PAVAN COMMENT CLASS ///
var pavan_comment = {
	data:"",
	commentSectionChange: function () 
	{
		$('#wave').remove();
		$('#commentScript').html('');
		$('#mainContainer').append(this.data.commentArray);
		$('#commentScript').html(this.data.printCommentArray);
		if($("#noComment").length)
		{
		}
		else
		{
			createSlider();
		}
		facebookFunction();
    }
}
/// DEFINE PAVAN COMMENT CLASS ///
$(document).ready(function(){
// Executed once all the page elements are loaded
	lastVal = totHistory;
	// Create the slider:
	if($("#noComment").length)
	{
		
	}
	else
	{
		createSlider();
	}
});
var totHistory=0;
// Holds the number of comments
var positions = new Array();
var lastVal;
function deleteLink()
{
	$(".deleteLink").live('click',function()
	{
		var deleteId= $(this).attr('id').replace('deleteLink-','');
		var deleteComment = $.manageAjax.create('deleteComment'); 
		deleteComment.add(
		{
			success: function(html) 
			{
				jQuery.ajax(
				{
					url: "http://www.pavanratnakar.com/include/controller.php",
					data: "ref=deleteComment&id="+deleteId+"&jsoncallback=?",
					dataType: "json",
					type: "POST",
					cache: true,
					beforeSend: function()
					{
							$("#com-"+deleteId+" .comment").addClass('loading').css({'height':'auto','width':'auto','position':'relative'});
							$("#com-"+deleteId).animate({'opacity':0.5},500);
					},
					success:function(data)
					{
						if(data.status)
						{
							$("#com-"+deleteId).animate({'opacity':0},500,function()
							{
								$("#com-"+deleteId).slideUp('fast',function()
								{
									$("#com-"+deleteId).remove();
								})
							});
							updateAllTabs();
						}
					}
				});
			}
		});
	});
}
function addHistory(obj)
{
	/* Gets called on page load for each comment, and on comment submit */
	totHistory++;
	positions.push(obj.id);
}
function buildQ(from,to)
{
	/* Building a jQuery selector from the begin
		and end point of the slide */
	if(from>to)
	{
		var tmp=to;
		to=from;
		from=tmp;
	}
	from++;
	to++;
	var query='';
	for(var i=from;i<to;i++)
	{
		if(i!=from) query+=',';
		query+='.com-'+positions[i-1];
	}
	/* Each comment has an unique com-(Comment ID) class
		that we are using to address it */
	return query;
}
function addComment(picPath,where,parent)
{
	/*	This functions gets called from both the "Add a comment" button 
		on the bottom of the page, and the add a reply link.
		It shows the comment submition form */
		
	var $el;
	if($('.waveButton').length) return false;
	// If there already is a comment submition form
	// shown on the page, return and exit
	if(!where)
		$el = $('#commentArea');
	else
		$el = $(where).closest('.waveComment');
	if(!parent) parent=0;
	// If we are adding a comment, but there are hidden comments by the slider:
	$('.waveComment').show('slow');
	lastVal = totHistory;
	$('#slider').slider('option','value',totHistory);
	// Move the slider to the end point and show all comments
	if(!picPath)
	{
		facebookFunction();
		picPath='<fb:profile-pic uid="loggedinuser" facebook-logo="true" size="square" linked="true"></fb:profile-pic>'
	}
	else
	{
		picPath='<img src="images/profilePic/small/'+picPath+'" alt="" title=""/>';
	}
	var comment = '<div class="waveComment addComment">\
		\
		<div class="comment">\
			<div class="commentAvatar">\
			'+picPath+'\
			</div>\
			\
			<div class="commentText">\
			\
			<textarea class="textArea" rows="2" cols="70" name="" />\
			<div><input type="button" class="waveButtonMain2 left" value="Add comment" onclick="addSubmit(this,'+parent+')" /> or <a href="" onclick="cancelAdd(this);return false">cancel</a></div>\
			\
			</div>\
		</div>\
	\
	</div>';
	$el.append(comment);
	// Append the form
}
function cancelAdd(el)
{
	$(el).closest('.waveComment').remove();
}
function createSlider()
{
	$("#slider").slider({
		value:totHistory,
		min: 1,
		max: totHistory,
		animate: true,
		slide: function(event, ui) 
		{
			if(lastVal>ui.value)
			$(buildQ(lastVal,ui.value)).hide('fast').find('.addComment').remove();
			// Using buildQ to build the jQuery selector
			// If we are moving the slider backward, hide the previous comment
			else if(lastVal<ui.value)
				$(buildQ(lastVal,ui.value)).show('fast');
			// Otherwise show it
			lastVal = ui.value;
		}
	});
}
function addSubmit(el,parent)
{
	/* Executed when clicking the submit button */
	var cText = $(el).closest('.commentText');
	var text = cText.find('textarea').val();
	var wC = $(el).closest('.waveComment');
	var category =$("#mainContainer").find('#wave').attr('class').replace('wave-','');
	if(text.length<4)
	{
		alert("Your comment is too short!");
		return false;
	}
	$(el).parent().parent().parent().animate({'opacity':0.5},500,function()
	{
		var commentHeight=$(el).parent().parent().parent().children().height();
		$(el).parent().parent().parent().css({'height':commentHeight+'px'})
		$(el).parent().parent().parent().children().hide();
		$(el).parent().parent().parent().children().css;
		$(el).parent().parent().parent().addClass('loading').css({'width':'auto','position':'relative'}).animate({'opacity':0.5},500);
	});
	var addComment = $.manageAjax.create('addComment'); 
	addComment.add(
	{
		success: function(html) 
		{
			$(el).parent().parent().parent().animate({'opacity':1},500);
			jQuery.ajax(
			{
				url: "http://www.pavanratnakar.com/include/controller.php",
				data: "ref=addComment&category="+category+"&comment="+encodeURIComponent(text)+"&parent="+parent+"&jsoncallback=?",
				dataType: "json",
				type: "POST",
				cache: true,
				beforeSend: function()
				{

				},
				success:function(data)
				{
					var ins_id = parseInt(data.commentArray['id']);
					if($("#noComment").length)
					{
						$("#noComment").animate({'opacity':0},500,function()
						{
							createSlider();
							$("#noComment").remove();
						})
					}
					if(ins_id)
					{
						wC.parent().append(data.commentArray['comment'])
						cText.parent().remove();
						addHistory({id:ins_id});
						$('#slider').slider('option', 'max', totHistory).slider('option','value',totHistory);
						lastVal=totHistory;
						deleteLink();
					}
					updateAllTabs();
				}
			});
		}
	});
}
// ]]>