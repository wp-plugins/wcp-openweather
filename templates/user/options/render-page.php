<?php
$args = $params;
$exlude = RPw()->getCurrentTheme()->getExcludeUserOptions($args->settings->getCurrentTag());

if (!empty($args->fields)):
    $sections = !empty($args->fields['sections']) ? $args->fields['sections'] : array('default' => array());
    $fields = !empty($args->fields['fields']) ? $args->fields['fields'] : NULL;
    
    if (!empty($fields)) :
    
        foreach ($sections as $sk => $sv) :
        ?>
            <div class="wcp-openweather-settings-section wp-open-weather-section<?php echo !empty($sv['class']) ? ' '.$sv['class'] : '';?>">
                <?php if (!empty($sv['label'])) : ?>        
                    <span class="wcp-openweather-settings-section-title"><?php echo $sv['label'] ?></span>
                <?php endif; ?>                
                <?php        
                    foreach ($fields as $fk => $fv) :
                        if (!empty($fv['section']) && $fv['section'] == $sk || $sk == 'default' ) :
                            if (!empty($fv['type'])) :
                                
                            ?>
                            <div class="wcp-openweather-settings-field wp-open-weather-field<?php echo !empty($fv['wrapper_class']) ? ' '.$fv['wrapper_class'] : '';?>"<?php echo in_array($fk, $exlude) || $fv['type'] == 'hidden'  ? ' style="display: none;"' : ''; ?>>
                            <?php
                                $args->field = $fk;
                                echo $args->settings->getParentModule()->getTemplate('user/options/fields/' . $fv['type'] , $args);
                            ?>
                            </div>
                            <?php
                            endif;                    
                        endif;
                    endforeach;                
                ?>
            </div>
        <?php 
        endforeach;        
    endif;
endif;