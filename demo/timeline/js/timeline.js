// <![CDATA[
var pavan_timeline =
{
    popupDiv : '#popup',
    closePopup : '.closePopup',
    postForm : '#postForm',
    timeLineSymbol : ".timeLine_plus",
    timeLineSymbolContainer : '.timeLine_container',
    timeLineSymbolTop : "",
    init : function() {
        this.post.getPosts();
        this.events();
        this.timelineSymbol();
        this.timelineMasonry.init();
        this.sendFormValidate();
    },
    events : function(){
        $(this.closePopup).live('click',function(){
            pavan_timeline.post.deletePost($(this));
        });
        $(this.timeLineSymbolContainer).live('click',function(e)
        {
            pavan_timeline.showPostPopup(e);
        });
        $(this.popupDiv).mouseup(function() 
        {
            return false
        });
        $(document).mouseup(function()
        {
            pavan_timeline.closePostPopup();
        });
    },
    timelineMasonry : {
        container : '#timeLine',
        postContainer : '.timeLinePost',
        timeLineSymbolBar : '.timeLine_bar',
        rightConrner : '.rightCorner',
        leftCorner : '.leftCorner',
        init : function(){
            $(this.container).masonry({itemSelector : this.postContainer,});
            this.arrow();
            this.addCloseButton();
            $(this.timeLineSymbolBar).show();
        },
        reload : function(){
            $(this.container).masonry( 'reload' );
            this.arrow();
        },
        removeItem : function(object){
            $(this.container).masonry( 'remove', object);
        },
        arrow : function(){
            var s = $(this.container).find(this.postContainer);
            $.each(s,function(i,obj){
                var posLeft = $(obj).css('left');
                $(obj).find(pavan_timeline.timelineMasonry.rightConrner).remove();
                $(obj).find(pavan_timeline.timelineMasonry.leftCorner).remove();
                if(posLeft === '0px') {
                    html = "<span class='"+pavan_timeline.timelineMasonry.rightConrner.replace('.','')+"'></span>";
                    $(obj).prepend(html);
                } else {
                    html = "<span class='"+pavan_timeline.timelineMasonry.leftCorner.replace('.','')+"'></span>";
                    $(obj).prepend(html);
                }
            });
        },
        addCloseButton : function(){
            $(this.postContainer).each(function(){
                $(this).prepend("<a href='javascript:void(0);' class='"+pavan_timeline.closePopup.replace('.','')+" right'>X</a>");
            });
        }
    },
    timelineSymbol : function(){
        $(this.timeLineSymbolContainer).mousemove(function(e)
        {
            var offset = $(pavan_timeline.timeLineSymbolContainer).offset();
            pavan_timeline.timeLineSymbolTop= e.pageY - offset.top ;
            $(pavan_timeline.timeLineSymbol).css({"top":pavan_timeline.timeLineSymbolTop +"px"}).show();
        }).mouseout(function()
        {
            $(pavan_timeline.timeLineSymbol).hide();
        });
    },
    showPostPopup : function(e){
        $(this.popupDiv).css({'top':this.timeLineSymbolTop+'px'}).fadeIn();
        $(this.popupDiv+' '+this.timelineMasonry.rightConrner).show();
        $(this.postForm+' textarea').eq(0).focus(); // focus on text area
    },
    closePostPopup : function(){
        $(this.popupDiv+' '+this.timelineMasonry.rightConrner).hide();
        $(this.popupDiv).hide();
    },
    sendFormValidate : function(){
        $(this.postForm).validate({
            rules: {
                postMessage: "required",
            },
            messages: {
                postMessage: "Dont tell me your heart is empty"
            },
            submitHandler: function() {
                pavan_timeline.post.addPost();
                return false;
            }
        });
    
    },
    post : {
        getPosts : function(){
            var getPosts = $.manageAjax.create('getPosts'); 
            getPosts.add({
                success: function(data) {
                    jQuery.ajax({
                        url: "http://www.pavanratnakar.com/demo/timeline/controller/postController.php?ref=getPosts&jsoncallback=?",
                        dataType: "json",
                        type:'get',
                        cache: true,
                        beforeSend: function() {},
                        success:function(data){
                            for(var i=0;i<data.rows.length;i++){
                                $(pavan_timeline.timelineMasonry.container).prepend('<div id="timeLinePost_'+data.rows[i]['post_id']+'" class="'+pavan_timeline.timelineMasonry.postContainer.replace('.','')+'"><a href="javascript:void(0);" class="'+pavan_timeline.closePopup.replace('.','')+' right">X</a><div>'+data.rows[i]['post_message']+'</div></div>');
                            }
                            pavan_timeline.timelineMasonry.reload();
                        }
                    });
                }
            });
        },
        addPost : function(){
            var message=$(pavan_timeline.postForm+' textarea').eq(0).val();
            var addPost = $.manageAjax.create('addPost');
            addPost.add({
                success: function(data) {
                    jQuery.ajax({
                        url: "http://www.pavanratnakar.com/demo/timeline/controller/postController.php",
                        dataType: "json",
                        type:'post',
                        data: 'post_message='+message+'&ref=operation&oper=add&jsoncallback=?',
                        cache: true,
                        beforeSend: function() {},
                        success:function(data){
                            $(pavan_timeline.timelineMasonry.container).prepend('<div class="'+pavan_timeline.timelineMasonry.postContainer.replace('.','')+'"><a href="javascript:void(0);" class="'+pavan_timeline.closePopup.replace('.','')+' right">X</a><div>'+message+'</div></div>');
                            pavan_timeline.timelineMasonry.reload();
                            pavan_timeline.closePostPopup();
                            $(pavan_timeline.postForm+' textarea').eq(0).val('');
                            return false;
                        }
                    });
                }
            });
        },
        deletePost : function(obj){
            if(confirm("Are your sure?")){
                var post_id = obj.parent().attr('id').replace('timeLinePost_','');
                var deletePost = $.manageAjax.create('deletePost');
                deletePost.add({
                    success: function(data) {
                        jQuery.ajax({
                            url: "http://www.pavanratnakar.com/demo/timeline/controller/postController.php",
                            dataType: "json",
                            type:'post',
                            data: 'ref=operation&oper=del&id='+post_id+'&jsoncallback=?',
                            cache: true,
                            beforeSend: function() {},
                            success:function(data){
                                obj.parent().fadeOut('slow');  
                                pavan_timeline.timelineMasonry.removeItem(obj.parent())
                                pavan_timeline.timelineMasonry.reload();
                            }
                        });
                    }
                });
            }
            return false;
        }
    }
}
$(document).ready(function(){
    pavan_timeline.init();
});
// ]]>