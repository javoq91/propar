
isLoadingDefaults = {
    'position': "right",        // right | inside | overlay
    'text': "",                 // Text to display next to the loader
    'class': "fa-refresh",    // loader CSS class
    'tpl': '',
    'disableSource': true,      // true | false
    'disableOthers': []
};

$(function() {

    // Action on Click
    $( "[type=submit]" ).click(function(e) {

        $( this ).isLoading(isLoadingDefaults);

    });

});