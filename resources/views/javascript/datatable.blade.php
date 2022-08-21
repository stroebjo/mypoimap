
@php

$defaults = [
    'info' => true,
    'paging' => true,
    'searching' => true,
];
if(isset($opts)) {
    $params = array_merge($defaults, $opts);
} else {
    $params = $defaults;
}

@endphp
<script>
window.addEventListener("load", function() {
    $('{{ $el ?? '#datatable' }}').DataTable({
        pageLength: 50,

        bAutoWidth: false,
        responsive: true,

        info: {{ $params['info'] ? 'true' : 'false' }},
        paging: {{ $params['paging'] ? 'true' : 'false' }},
        searching: {{ $params['searching'] ? 'true' : 'false' }},

        columnDefs: [
            { targets: 'no-sort', orderable: false }
        ]

    });
} );
</script>
