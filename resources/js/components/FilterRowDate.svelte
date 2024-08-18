<script>
    export let fields = {
        operator: "is",
        value: ""
    }
</script>

<div>
    <div class="row">
        <div class="col-6">
            <select class="form-select form-select-sm" bind:value={fields.operator}>
                <option value="is">is</option>
                <option value="less">is less than</option>
                <option value="greater">is greater than</option>
            </select>
        </div>
        <div class="col-6">
            <input bind:value={fields.value} class="form-control form-control-sm" type="date">
        </div>
    </div>
</div>


