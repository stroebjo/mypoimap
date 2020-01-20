<script src="{{ asset('js/easymde.min.js') }}" ></script>

<script>
var easyMDE = new EasyMDE({
    element: document.getElementById('{{ $id }}'),
    shortcuts: {
        drawImage: null // don't overload DevTools shorctus if EasyMDE has focus...
    },
    autoDownloadFontAwesome: false,
    promptURLs: true,
    status: false,
    spellChecker: false
});

</script>
