(function($) {
    'use strict';
    
    // Czekaj aż Customizer będzie gotowy
    wp.customize.bind('ready', function() {
        console.log('Fotka Customizer: Ready');
        
        // Social Links Repeater
        $(document).on('click', '.fotka-add-social-link', function(e) {
            e.preventDefault();
            console.log('Fotka: Adding social link');
            
            var $list = $(this).siblings('.fotka-social-links-list');
            var $template = $('#tmpl-fotka-social-link-item');
            var index = $list.children().length;
            
            var html = $template.html().replace(/\{\{data\.index\}\}/g, index);
            $list.append(html);
            
            updateSocialLinksValue($list);
        });
        
        $(document).on('click', '.fotka-remove-social-link', function(e) {
            e.preventDefault();
            console.log('Fotka: Removing social link');
            var $item = $(this).closest('.fotka-social-link-item');
            var $list = $item.closest('.fotka-social-links-list');
            $item.remove();
            updateSocialLinksValue($list);
        });
        
        $(document).on('change', '.fotka-social-platform, .fotka-social-url', function() {
            console.log('Fotka: Social link changed');
            var $list = $(this).closest('.fotka-social-links-list');
            updateSocialLinksValue($list);
        });
        
        function updateSocialLinksValue($list) {
            var data = [];
            $list.find('.fotka-social-link-item').each(function() {
                var platform = $(this).find('.fotka-social-platform').val();
                var url = $(this).find('.fotka-social-url').val();
                
                if (platform && url) {
                    data.push({
                        platform: platform,
                        url: url
                    });
                }
            });
            
            var $control = $list.closest('.fotka-social-links-repeater');
            var $input = $control.find('.fotka-social-links-value');
            var settingId = $input.attr('data-customize-setting-link');
            
            console.log('Fotka: Input element:', $input[0]);
            console.log('Fotka: All attributes:', {
                'data-customize-setting-link': $input.attr('data-customize-setting-link'),
                'id': $input.attr('id'),
                'class': $input.attr('class')
            });
            
            console.log('Fotka: Updating social links', {
                settingId: settingId,
                data: data,
                hasCustomize: typeof wp.customize !== 'undefined',
                hasSetting: settingId && wp.customize.has(settingId)
            });
            
            if (settingId && wp.customize.has(settingId)) {
                // Użyj oficjalnego API WordPress Customizer
                wp.customize(settingId).set(data);
                console.log('Fotka: Social links value set successfully');
            } else {
                console.error('Fotka: Setting not found', settingId);
            }
        }
        
        // Share Platforms
        $(document).on('change', '.fotka-share-checkbox', function() {
            console.log('Fotka: Share checkbox changed');
            var $container = $(this).closest('.fotka-share-platforms');
            var $input = $container.find('.fotka-share-platforms-value');
            var values = [];
            
            $container.find('.fotka-share-checkbox:checked').each(function() {
                values.push($(this).val());
            });
            
            var settingId = $input.attr('data-customize-setting-link');
            
            console.log('Fotka: Updating share platforms', {
                settingId: settingId,
                values: values,
                hasCustomize: typeof wp.customize !== 'undefined',
                hasSetting: settingId && wp.customize.has(settingId)
            });
            
            if (settingId && wp.customize.has(settingId)) {
                // Użyj oficjalnego API WordPress Customizer
                wp.customize(settingId).set(values);
                console.log('Fotka: Share platforms value set successfully');
            } else {
                console.error('Fotka: Setting not found', settingId);
            }
        });
        
    });
    
})(jQuery);
