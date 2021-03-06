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
    
    $(document).on('click', '.wcp-openweather-settings-submit', function(e) {
        e.preventDefault();
        var data = 'nonce=' + ajax_rpw.ajax_nonce;
        data = data + "&" + $(this).closest('form').serialize();
                        
        jQuery.ajax({
            url: ajax_rpw.ajax_url,
            type: 'POST' ,
            data: data,
            dataType: 'json',
            cache: false,
            success: function(data) {
                if (!!data.status && data.status == 'ok') {
                    //location.href = location.href;
                    window.location.reload();
                }
            },
            error: function (request, status, error) {
            }
        }); 
        
        return false;
    });
    
})(jQuery);


