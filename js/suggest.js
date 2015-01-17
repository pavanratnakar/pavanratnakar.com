// <![CDATA[
$(document).ready(function(){
	var ul = $('ul.suggestions');
	///CAPCTHA
	$('#QapTcha').QapTcha();
	///CAPCTHA
	/// CONTACT FORM SUBMIT ///
	$(".contactSubmit").click(function()
	{
		var contactMeValidation=$("#contactForm").validate({
			errorClass: "error",
			rules: {
				name: {
					required: true,
					minlength: 4
				},
				email: {
					required: true,
					email: true
				},
				subject: {
					required: true
				},
				message: {
					required: true
				}
			},
			messages: {
				name: {
					required: "Please enter a Name",
					minlength: jQuery.format("Your Name must consist of at least {0} characters")
				},
				email: "Please enter a valid email address",
				subject: {
					required: "Please select your subject"
				},
				message: {
					required: "Please enter your message"
				}
			},
			errorPlacement: function(error, element) 
			{
				error.appendTo($("#contactStatus"));
			},
			submitHandler: function() 
			{
				var contantName=$('#contantName').val();
				var contactEmail=$('#contactEmail').val();
				var contactSubject=$('#contactSubject').val();
				var contactMessage=$('#contactMessage').val();
				var contactButtons=$("#contactButtons").html();
				var contactMe = $.manageAjax.create('contactMe'); 
				contactMe.add(
				{
					success: function(html) 
					{
						jQuery.ajax(
						{
							url: "include/controller.php",
							data: "ref=contact&name="+contantName+"&email="+contactEmail+"&subject="+contactSubject+"&message="+contactMessage+"&jsoncallback=?",
							dataType: "json",
							type: "POST",
							cache: true,
							beforeSend: function()
							{
								$("#contactButtons").slideUp('slow',function()
								{
									$("#contactButtons").html('&nbsp;');
									$("#contactButtons").addClass('loading').css({'height':'33','width':'auto','position':'relative','margin-top':'10px'});
									$("#contactButtons").css({"margin":"10px 0 0 0"}).slideDown('slow');
								});
							},
							success:function(data)
							{
								if(data.status)
								{
									$("#contactFormContainer .siteCommonInnterContainer").slideUp("slow",function()
									{
										$("#contactFormContainer .siteCommonInnterContainer").slideUp('slow',function()
										{
											$("#contactFormContainer .siteCommonInnterContainer").empty();
											$("<h3>").html(data.message[0]).prependTo("#contactFormContainer .siteCommonInnterContainer");
											$("#contactFormContainer .siteCommonInnterContainer").slideDown("slow");
										});
									});
								}
								else
								{
									$("<label>").attr({"generated":"true","class":"error"}).html(data.message[0]).appendTo("#contactStatus");
								}
							}
						});
					}
				});
			
			},
			success: function(label) {
			label.html("").addClass("checked");
			}
		})
	});
	/// CONTACT FORM SUBMIT ///
	/// CONTACT FORM RESET
	$(".cancel").click(function(){
		$('#contactForm')[0].reset();
	});
	/// CONTACT FORM RESET
	// Listening of a click on a UP or DOWN arrow:
	$('div.vote span').live('click',function()
	{
		var elem		= $(this),
			parent		= elem.parent(),
			li			= elem.closest('li'),
			ratingDiv	= li.find('.rating'),
			id			= li.attr('id').replace('s',''),
			v			= 1;
		// If the user's already voted:
		if(parent.hasClass('inactive')){
			return false;
		}
		parent.removeClass('active').addClass('inactive');
		if(elem.hasClass('down')){
			v = -1;
		}
		// Incrementing the counter on the right:
		var ratInc=+ratingDiv.text();
		ratingDiv.text(v + ratInc);
		// Turning all the LI elements into an array
		// and sorting it on the number of votes:
		var arr = $.makeArray(ul.find('li')).sort(function(l,r){
			return +$('.rating',r).text() - +$('.rating',l).text();
		});
		// Adding the sorted LIs to the UL
		ul.html(arr);
		// Sending an AJAX request
		var addSuggestionVote = $.manageAjax.create('addSuggestionVote'); 
		addSuggestionVote.add(
		{
			success: function(html) 
			{
				jQuery.ajax(
				{
					url: "include/controller.php",
					data: "ref=addSuggestionVote&vote="+v+"&id="+id+"&jsoncallback=?",
					dataType: "json",
					type: "POST",
					cache: true,
					beforeSend: function()
					{
					},
					success:function(data)
					{
					}
				});
			}
		});
	});
	$('#suggest').submit(function()
	{
		var form		= $(this),
			textField	= $('#suggestionText');
		// Preventing double submits:
		if(form.hasClass('working') || textField.val().length<3){
			return false;
		}
		form.addClass('working');
		var addSuggestion = $.manageAjax.create('addSuggestion'); 
		addSuggestion.add(
		{
			success: function(html) 
			{
				jQuery.ajax(
				{
					url: "include/controller.php",
					data: "ref=addSuggestion&content="+textField.val()+"&jsoncallback=?",
					dataType: "json",
					type: "POST",
					cache: true,
					beforeSend: function()
					{
						
					},
					success:function(data)
					{
						textField.val('');
						form.removeClass('working');
						if(data.html)
						{
							$(data.html).hide().appendTo(ul).slideDown();
						}
					}
				});
			}
		});
		return false;
	});
});
// ]]>