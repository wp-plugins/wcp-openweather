(function($) {  
    $(document).ready(function() { 
        $('.agp-color-picker').iris({
            defaultColor: true,
            change: function(event, ui){},
            clear: function() {},
            hide: false,
            palettes: true
        });        
    });
})(jQuery);


