(function($) {
    'use strict';
    
    // Smooth scroll
    $('a[href^="#"]').on('click', function(e) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            e.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 100
            }, 500);
        }
    });
    
    // Share buttons functionality
    $('.share-button').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var width = 600;
        var height = 400;
        var left = (screen.width - width) / 2;
        var top = (screen.height - height) / 2;
        
        window.open(
            url,
            'share',
            'width=' + width + ',height=' + height + ',left=' + left + ',top=' + top + ',toolbar=0,status=0'
        );
    });
    
})(jQuery);
