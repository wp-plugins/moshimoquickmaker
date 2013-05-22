var jq = jQuery.noConflict();

///詳細サムネイル
jq(function(){
    jq("img.Itemicon").click(function(){
        var ImgSrc = jq(this).attr("src");
        var ImgAlt = jq(this).attr("alt");
        jq("img#ItemViewPhoto").attr({src:ImgSrc,alt:ImgAlt});
        jq("img#ItemViewPhoto").hide();
        jq("img#ItemViewPhoto").fadeIn("slow");
        return false;
    });
});