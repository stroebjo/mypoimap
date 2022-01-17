<div id="modal_google_place_id" class="modal" tabindex="-1" role="dialog" aria-labelledby="modal_google_place_id-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_google_place_id-title">{{ __('Google Place ID explanation') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
            </div>
            <div class="modal-body">
                <p>
                    {{ __('The Google Place ID identifies a place for Google. By providing it a link to Google Maps will open with more informatien available (name, reviews, images, etc.). See the following example:') }}
                    <a href="https://www.google.com/maps/search/?api=1&query=33.740938,10.734937&query_place_id=ChIJG78Zd-22qhMRzE1Hdn9kkso" target="_blank" rel="noreferrer">{{ __('With place id')}}</a> /
                    <a href="https://www.google.com/maps/search/?api=1&query=33.740938,10.734937" target="_blank" rel="noreferrer">{{ __('Without')}}</a>
                </p>
                <p>
                    {!! __('Sadly there is no straight forward way to get the Place ID (without the Maps API). You can querry it by location name <a href="https://developers.google.com/places/place-id" rel="noreferrer" target="_blank">here</a>. If it\'s not available you can get some more information <a href="https://www.launch2success.com/guide/find-any-google-id/" rel="noreferrer" target="_blank">here</a>.') !!}</a>
                </p>
            </div>
        </div>
    </div>
</div>
