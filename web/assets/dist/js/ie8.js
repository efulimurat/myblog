document.onreadystatechange = function () {
        if (document.readyState === "complete") {
                +function ($) { 'use strict';
                        /*
                         * Hide dasichons.
                         * IE8 can't display it
                         * -----------------------------------------------------
                         */
                        $('#main-content .article-large .icons a:has(.dashicons)').css('display', 'none');
                        
                        /*
                         * Fix vertical center for logo
                         * IE8 doen't support transform
                         */
                        var logo = $('#main-nav .navbar-header .navbar-brand img');
                        logo.css('margin-top', '-' + logo.height() / 2);
                }(jQuery);
        } 
};
