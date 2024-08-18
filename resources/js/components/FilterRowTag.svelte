<script>
    export let fields = {
        operator: "has_any",
        value: ""
    }
</script>
<div>
    <div class="row">
        <div class="col-6">
            <select class="form-select form-select-sm" bind:value={fields.operator}>
                <option value="has_any">has any</option>
                <option value="has_all">has all</option>
            </select>
        </div>
        <div class="col-6">
            <input bind:value={fields.value} class="form-control form-control-sm" type="text">
        </div>
    </div>
</div>
