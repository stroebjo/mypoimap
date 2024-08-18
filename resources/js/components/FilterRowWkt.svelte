
<script>
    export let fields = {
        operator: "is",
        value: ""
    }
</script>

<div>
    <div class="row">
        <div class="col-4">
            <select class="form-select form-select-sm" bind:value={fields.operator}>
                <option value="is">is inside</option>
                <option value="isnot">is not inisde</option>
            </select>
        </div>
        <div class="col-8">
            <input bind:value={fields.value} class="form-control form-control-sm" type="text">
        </div>
        <div class="col-12">
            <small class="text-muted">See this <a href="https://clydedacruz.github.io/openstreetmap-wkt-playground/" target="_blank">WKT editor</a> for creating polygons.</small>
        </div>
    </div>
</div>
