// <![CDATA[	
/// PASSWORD RESET VALIDATION 
$(document).ready(function()
{
	var passwordResetValidation=$("#passwordResetForm").validate({
		errorClass: "error",
		rules: {
			oldPassword: {
				required: true,
				minlength: 5
			},
			reoldPassword: {
				required: true,
				equalTo: "#oldPassword"
			},
			newPassword: {
				password: "#oldPassword"
			},
		},
		messages: {
			oldPassword: {
				required: "Please provide your old password",
				minlength: jQuery.format("Your password must be at least {0} characters")
			},
			reoldPassword: {
				required: "Please repeat your password",
				equalTo: "Please enter the same password as above"
			},
			newPassword: {
				required: "Please provide a new password",
				minlength: jQuery.format("Your password must be at least {0} characters")
			}
		},
		errorPlacement: function(error, element) 
		{
			error.appendTo($("#passwordResetStatus"));
		},
		submitHandler: function() 
		{
			var oldPassword=$('#oldPassword').val();
			var newPassword=$('#newPassword').val();
			var contactButton=$("#contactButtons").html();
			var passwordReset = $.manageAjax.create('passwordReset'); 
			passwordReset.add(
			{
				success: function(html) 
				{
					jQuery.ajax(
					{
						url: "http://www.pavanratnakar.com/include/controller.php",
						data: "ref=passwordReset&oldPassword="+oldPassword+"&newPassword="+newPassword+"&jsoncallback=?",
						dataType: "json",
						type: "POST",
						cache: true,
						beforeSend: function()
						{
							$("#contactButtons").slideUp('medium',function()
							{
								$("#contactButtons").html('&nbsp;');
								$("#contactButtons").addClass('loading').css({'height':'33','width':'auto','position':'relative','margin-top':'10px'});
								$("#contactButtons").css({"margin":"10px 0 0 0"}).slideDown('medium');
							});
						},
						success:function(data)
						{
							if(data.status)
							{
								var topPanelLoad = $.manageAjax.create('topPanelLoad'); 
								topPanelLoad.add(
								{
									success: function(html) 
									{
										jQuery.ajax(
										{
											url: "http://www.pavanratnakar.com/controller/ajaxController.php?ref=resetPanel",
											data: "",
											dataType: "html",
											type: "GET",
											cache: true,
											beforeSend: function()
											{
											},
											success:function(data1)
											{
												$("#contactButtons").animate({'opacity':0},500,function()
												{
													$("#passwordResetForm").slideUp('slow',function()
													{
														$("#passwordResetForm").empty();
														$("<h4>").css({'padding':'0'}).html(data.message[0]).appendTo("#passwordResetForm");
														$("<a>").addClass('open').attr({'src':'javascript:void(0);','id':'openSlide'}).html('Click here to login.').appendTo("#passwordResetForm");
														$("#passwordResetForm").slideDown("slow");
														$("#toppanel").html(data1);
														slider1();
													});
												});
											}
										});
									}
								});
							}
							else
							{
								$("#contactButtons").animate({'opacity':1},500,function()
								{
									$("#contactButtons").removeClass('loading').css({'height':'auto','margin-top':'0'});
									$("#contactButtons").html(contactButton);
									$("<label>").attr({"generated":"true","class":"error"}).html(data.message[0]).appendTo("#passwordResetStatus");
									$('#passwordResetForm')[0].reset();
								});
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
	/// PASSWORD RESET VALIDATION
});
// ]]>