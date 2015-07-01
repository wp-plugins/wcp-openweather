(function($) {  
    $(document).ready(function() { 
        $('.agp-color-picker').iris({
            defaultColor: true,
            change: function(event, ui){},
            clear: function() {},
            hide: false,
            palettes: true
        });        

        
        $('.rpw-gm-city').focus(function() {
            $('.pac-container').css('z-index', '10000');    
        });

        var options = {
          types: ['(cities)']
        };
        
        $('.rpw-gm-city').each(function() {
            if (typeof this.rpwOwner == 'undefined') {
                var autocomplete = new google.maps.places.Autocomplete($(this).get(0), options);           
                autocomplete.rpwOwner = this;
                this.rpwOwner = autocomplete;
                google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    var place = autocomplete.getPlace();
                    if (place.address_components) {
                        city = '';
                        country = '';
                        for (var i = 0; i < place.address_components.length; i++) {
                            var component = place.address_components[i];
                            if ($.inArray('locality', component.types) != -1) {
                                city = component.long_name;    
                            }

                            if ($.inArray('country', component.types) != -1) {
                                country = component.short_name;    
                            }
                        }
                        if (city) {
                            if (country) {
                                city = city + ', ' + country;
                            }
                            $(autocomplete.rpwOwner).val(city);
                        }                    
                    }
                });                
            }

        });    
    });
})(jQuery);


