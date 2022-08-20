import Tagify from '@yaireo/tagify';

var input = document.querySelector('input[name=tags]');

if (input) {
    var form = input.form;

    /**
     * Based on the provided example code for AJAX loaded tag suggestions.
     *
     * @see https://github.com/yairEO/tagify#ajax-whitelist
     *
     */
    var tagify = new Tagify(input, {whitelist:[]}),
      controller; // for aborting the call

    // listen to any keystrokes which modify tagify's input
    tagify.on('input', onInput);

    function onInput(e) {
        var value = e.detail.value;
        tagify.settings.whitelist.length = 0; // reset the whitelist

        // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
        controller && controller.abort();
        controller = new AbortController();

        // show loading animation and hide the suggestions dropdown
        tagify.loading(true).dropdown.hide.call(tagify)

        fetch(app.routes.tagsAutocomplete + '?q=' + value, {signal:controller.signal})
            .then(RES => RES.json())
            .then(function(whitelist) {
                // update inwhitelist Array in-place
                tagify.settings.whitelist.splice(0, whitelist.length, ...whitelist)
                tagify.loading(false).dropdown.show.call(tagify, value); // render the suggestions dropdown
            });
    }

    /**
     * tagify will NOT keep the original input.value intact, but will write
     * JSON stuff into it (https://github.com/yairEO/tagify/issues/197).
     * So we convert the JSON back to a comma-separated string for spatie-tags on
     * the backend site.
     */
    form.addEventListener('submit', function(e) {
        var value = JSON.parse(input.value);
        var tags = [];

        value.forEach(function(el) {
            tags.push(el.value);
        })

        input.value = tags.join(',');
    });
}
