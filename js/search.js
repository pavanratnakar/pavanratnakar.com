// <![CDATA[
/// DEFINE PAVAN SEARCH CLASS ///
var pavan_search=
{
	type:"",
	container:"",
	defaultTextContent:"",
	config : function(type,defaultText)
	{
		this.type=type;
		this.container=$('#'+type);
		this.defaultTextContent=defaultText;
	},
	autoCompleteFunction: function()
	{
		pavan_search.container.defaultText(pavan_search.defaultTextContent);
		pavan_search.container.autocomplete({
			source: function(request,response)
			{
				$.ajax({
					url: "http://www.pavanratnakar.com/controller/ajaxController.php?jsoncallback=?",
					dataType: "json",
					type: "POST",
					data: {
						ref: pavan_search.type,
						searchId: pavan_search.container.val()
					},
					success: function(data) 
					{
						response($.map(data.movieArray,function(item) 
						{
							return {
								label: item.movie_name,
								value: item.tmdbId
							}
						}));
					}
				});
			},
			minLength: 2,
			select: function(event,ui) 
			{
				window.location.href='http://www.pavanratnakar.com/movie/'+ui.item.value
			},
			open: function() 
			{
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			},
			close: function() 
			{
				//$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			}
		});
	}
}
/// DEFINE PAVAN SEARCH CLASS ///
// ]]>