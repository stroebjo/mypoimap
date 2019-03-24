import Tagify from '@yaireo/tagify';

var input = document.querySelector('input[name=tags]');

if (input) {
    var form = input.form;

    // init Tagify script on the above inputs
    var tagify = new Tagify(input, {
        whitelist : [],
        blacklist : [] // <-- passed as an attribute in this demo
    });

    var controller;

    // listen to any keystrokes which modify tagify's input
    tagify.on('input', onInput);

    function onInput( e ) {
    var value = e.detail;
    tagify.settings.whitelist.length = 0; // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort();
    controller = new AbortController();

    fetch(app.routes.tagsAutocomplete + '?q=' + value, {signal:controller.signal})
        .then(RES => RES.json())
        .then(function(whitelist){
        tagify.settings.whitelist = whitelist;
        tagify.dropdown.show.call(tagify, value); // render the suggestions dropdown
        })
    }

    /**
     * tagify will NOT keep the original input.value intact, but will write
     * JSON stuff into it (https://github.com/yairEO/tagify/issues/197).
     * So we convert the JSON back to a comma-seperated string for spatie-tags on
     * the backend site.
     */
    $(form).on('submit', function(e) {
        var value = JSON.parse(input.value);
        var tags = [];

        value.forEach(function(el) {
            tags.push(el.value);
        })

        input.value = tags.join(',');
    });
}
