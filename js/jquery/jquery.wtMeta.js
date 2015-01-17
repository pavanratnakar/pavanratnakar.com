/**
 * Meta plugin for jQuery
 * ---
 * @author Yasar Bayar <yasarbayar@gmail.com>
 * @version 1.0.0
 */

(function($){
    $.wtMeta = function(){
        var $Meta;
        if($('meta[name='+arguments[0]+']').size()>0){
            $Meta=$('meta[name='+arguments[0]+']');
        }else{
            $Meta=$('meta[http-equiv='+arguments[0]+']');
        }

        if(arguments.length==1) return $Meta.attr('content');
        else $Meta.attr('content',arguments[1]);
    };
})(jQuery);
