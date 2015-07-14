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
                $(this).on('change', function() {
                    $(this).closest('form').find('.rpw-gm-city-data').val('');
                });
                var autocomplete = new google.maps.places.Autocomplete($(this).get(0), options);           
                autocomplete.rpwOwner = this;
                this.rpwOwner = autocomplete;
                google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    var place = autocomplete.getPlace();
                    if (place.address_components) {
                        city = ''; city_short = '';
                        country = ''; country_short = '';
                        state = ''; state_short = '';
                        
                        for (var i = 0; i < place.address_components.length; i++) {
                            var component = place.address_components[i];
                            if (!city && ($.inArray('locality', component.types) != -1 || $.inArray('administrative_area_level_3', component.types) != -1)) {
                                city = component.long_name;    
                                city_short = component.short_name;    
                            }
                            if ($.inArray('administrative_area_level_1', component.types) != -1) {
                                state = component.long_name;    
                                state_short = component.short_name;    
                            }                            
                            if ($.inArray('country', component.types) != -1) {
                                country = component.long_name;    
                                country_short = component.short_name;    
                            }
                        }
                        
                        $(autocomplete.rpwOwner).closest('form').find('.rpw-gm-city-data').val('');                        
                        
                        if (city) {
                            full_name = city;
                            short_name = city;
                            
                            city_data = 'city=' + city + '&city_short='+city_short;
                            
                            if (state) {
                                full_name = full_name + ', ' + state;
                                city_data = city_data + '&state=' + state + '&state_short='+state_short;
                            }                                                        
                            
                            if (country) {
                                full_name = full_name + ', ' + country;
                                short_name = short_name + ', ' + country_short;
                                city_data = city_data + '&country=' + country + '&country_short='+country_short;
                            }

                            city_data = city_data + '&full_name=' + full_name;
                            city_data = city_data + '&short_name=' + short_name;
                            city_data = city_data + '&lat=' + place.geometry.location.lat();
                            city_data = city_data + '&lng=' + place.geometry.location.lng();
                            
                            $(autocomplete.rpwOwner).val(full_name);
                            $(autocomplete.rpwOwner).closest('form').find('.rpw-gm-city-data').val(city_data);
                        }                                   
                    }
                });                
            }

        });    
    });
})(jQuery);


