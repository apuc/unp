(function($){
    $.fn.equalHeights=function(minHeight,maxHeight){
        tallest=(minHeight)?minHeight:0;
        this.each(function(){
            if($(this).height()>tallest){tallest=$(this).height()}
        });
        if((maxHeight)&&tallest>maxHeight) tallest=maxHeight;
        return this.each(function(){$(this).height(tallest)})
    }
})(jQuery)

$(window).on('load', function(){
    equalHeights()
})

$(window).resize(function(){
    $("*[class*='maxheight']").css({height:'auto'});
    equalHeights();
})

function equalHeights()
{
    var boxList = [];

    if($(document).width() > 767) {
        $("*[class*='maxheight']").each(function() {
            var self  = $(this);
            var name  = self.attr('class').match(/(maxheight[0-9]*)/)[0];
            var check = function () {
                for (i in boxList)
                    if (boxList[i] == name)
                        return true;

                return false;
            };

            if (!check())
                boxList.push(name);
        });

        for (i in boxList)
            $('.' + boxList[i]).equalHeights();
    }
}