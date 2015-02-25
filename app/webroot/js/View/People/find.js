/**
 * Created by Rod on 2015-02-24.
 */
(function($) {
    $('#autocomplete').autocomplete({
        source: "/People/getWorkEmail.json"
    });
})(jQuery);
