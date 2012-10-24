if (!Omeka) {
    var Omeka = {};
}

/**
 * Add the TinyMCE WYSIWYG editor to a page.
 * Default is to add to all textareas.
 *
 * @param {Object} [params] Parameters to pass to TinyMCE, these override the
 * defaults.
 */
Omeka.wysiwyg = function (params) {
    // Default parameters
    initParams = {
        convert_urls: false,
        mode: "textareas", // All textareas
        theme: "advanced",
        theme_advanced_toolbar_location: "top",
        theme_advanced_toolbar_align: "left",
        theme_advanced_buttons1: "bold,italic,underline,|,justifyleft,justifycenter,justifyright,|,bullist,numlist,|,link,formatselect,code",
        theme_advanced_buttons2: "",
        theme_advanced_buttons3: "",
        plugins: "paste,inlinepopups,media",
        media_strict: false,
        width: "100%"
    };

    // Overwrite default params with user-passed ones.
    for (var attribute in params) {
        // Account for annoying scripts that mess with prototypes.
        if (params.hasOwnProperty(attribute)) {
            initParams[attribute] = params[attribute];
        }
    }

    tinyMCE.init(initParams);
};

Omeka.deleteConfirm = function () {
    jQuery('.delete-confirm').click(function () {
        if (jQuery(this).is('input')) {
            var url = jQuery(this).parents('form').attr('action');
        } else if (jQuery(this).is('a')) {
            var url = jQuery(this).attr('href');
        }
        jQuery.post(url, function (response){
            jQuery(response).dialog({modal:true});
        });
        return false;
    });
};

Omeka.saveScroll = function () {
    var $save   = jQuery("#save"),
        $window = jQuery(window),
        offset  = $save.offset(),
        topPadding = 62;
    
    if (document.getElementById("save")) {
        $window.scroll(function() {
            if($window.scrollTop() > offset.top && $window.width() > 767) {
                $save.stop().animate({
                    marginTop: $window.scrollTop() - offset.top + topPadding
                    });
            } else {
                $save.stop().animate({
                    marginTop: 0
                });
            }
        });
    }
};

Omeka.showAdvancedForm = function () {
    if (jQuery("#advanced-form")) {
        jQuery('#search-form input[type=submit]').addClass("blue button with-advanced").after('<a href="#" id="advanced-search" class="blue button">Advanced Search</a>');
        jQuery('#search-form input[type=text]').addClass("blue button with-advanced");
        var $advanced_form = jQuery("#advanced-form");
        jQuery("#advanced-search").click( function(event) {
            event.stopPropagation();
            if($advanced_form.css("display") == "none") {
                $advanced_form.fadeIn();
            } else {
                $advanced_form.fadeOut();
            }
            jQuery("#search-form input[type=text]").click( function(event) {
               event.stopPropagation(); 
            });
            $advanced_form.click( function(event) {
               event.stopPropagation(); 
            });
            jQuery(document).click( function() {
                if($advanced_form.css("display") == "block") {
                    $advanced_form.fadeOut();
                }
            });
            
        });
    } else {
        jQuery('#search-form input[type=submit]').addClass("blue button");
    }
};

Omeka.addReadyCallback = function (callback, params) {
    this.readyCallbacks.push([callback, params]);
};

Omeka.runReadyCallbacks = function () {
    for (var i = 0; i < this.readyCallbacks.length; ++i) {
        this.readyCallbacks[i][0].apply(this, this.readyCallbacks[i][1]);
    }
};

Omeka.readyCallbacks = [
    [Omeka.deleteConfirm, null],
    [Omeka.saveScroll, null],
    [Omeka.showAdvancedForm, null]
];
