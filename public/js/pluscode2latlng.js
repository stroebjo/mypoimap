function insertLatLng(lat, lng) {
    $('#lat').val(lat);
    $('#lng').val(lng);

    var href = 'https://www.google.com/maps/search/?q=' + lat + ',' + lng;

    $('.js-plus_code_feedback').empty();
    $('.js-plus_code_feedback').html('<a href="' + href + '" id="plus_code_result" target="_blank">Check coordinates on Maps</a>');
}

$('#plus_code').on('input', function(e) {
    var value = this.value;

    $('.js-plus_code_feedback').empty();
    $('.js-plus_code_feedback').html('<span class="spinner-border spinner-border-sm" role="status"></span> Loading…');


    if (value.indexOf(' ') == -1) {
        // no address => full code
        var code = value;

        if (!OpenLocationCode.isValid(code)) {
            alert('The specified code, `' + code + '`, is not a valid OLC code.');
            return;
        }

        if (!OpenLocationCode.isFull(code)) {
            alert('The specified code, `' + code + '`, is not a valid, full OLC code.');
            return;
        }

        var codeArea = OpenLocationCode.decode(code);
        insertLatLng(codeArea.latitudeCenter.toFixed(6), codeArea.longitudeCenter.toFixed(6));
    } else {
        // => short code, sperate code + address
        var codeFragment = value.substr(0, value.indexOf(' '));
        var address      = value.substr(value.indexOf(' ') + 1);

        if (codeFragment.length > 7) {
            alert('The code, `' + codeFragment + '` is too long. Short codes are a maximum of seven characters long.');
            return;
        }

        if (!OpenLocationCode.isValid(codeFragment)) {
            alert('The code, `' + codeFragment + '`, is not a valid part of an OLC code.');
            return;
        }

        // get lat/lng for address
        // Nominatim Usage Policy: https://operations.osmfoundation.org/policies/nominatim/
        // API Docs: http://nominatim.org/release-docs/latest/api/Search/
        $.getJSON('https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' + address, function(data) {

            if (data.length !== 1) {
                alert('No results from Nominatim API for `' + address + '`.');
                return;
            }

            var lat = data[0].lat;
            var lng = data[0].lon;

            try {
                var fullCode = OpenLocationCode.recoverNearest(codeFragment, lat, lng);
                console.log(fullCode);
            } catch (e) {
                alert('The code, `' + codeFragment + '`, is not a valid part of an OLC code.');
                return;
            }

            var codeArea = OpenLocationCode.decode(fullCode);
            insertLatLng(codeArea.latitudeCenter.toFixed(6), codeArea.longitudeCenter.toFixed(6));
        }).fail(function() {
            alert('Could not reach Nominatim API to translate address part, `' + address + '`, into lat/lng.');
        });
    }
});
