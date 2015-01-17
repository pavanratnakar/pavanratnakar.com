// <![CDATA[
/// FILE UPLOAD FUNCTION
function createUploader()
{ 
	var uploader = new qq.FileUploader({
	element: document.getElementById('photoUpload_container'),
	action: 'class/fileUpload.php'
	});           
}
window.onload = createUploader;  
/// FILE UPLOAD FUNCTION
jQuery(function($){
    $('p.editableText').editableText({
		newlinesEnabled: false
	});
	$.editableText.defaults.newlinesEnabled = true;
	$('.editableText').change(function()
	{
		var newValue = $(this).html();
		var type= $(this).attr('id');
		var updateProfile = $.manageAjax.create('updateProfile'); 
		updateProfile.add(
		{
			success: function(html) 
			{
				jQuery.ajax(
				{
					url: "include/controller.php",
					data: "ref=updateProfile&type="+type+"&newValue="+newValue+"&jsoncallback=?",
					dataType: "json",
					type: "POST",
					cache: true,
					beforeSend: function()
					{
						
					},
					success:function(data)
					{
						if(data.status)
						{

						}
						else
						{
						}
					}
				});
			}
		});
	});
});
// ]]>