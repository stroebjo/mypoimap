<script>
    export let fields = {
        operator: "is",
        value: 5
    }
</script>

<div>
    <div class="row">
        <div class="col-4">
            <select class="form-select form-select-sm" bind:value={fields.operator}>
                <option value="is">is</option>
                <option value="less">is lower</option>
                <option value="greater">is greater</option>
            </select>
        </div>
        <div class="col-8">
            <select  class="form-select form-select-sm" bind:value={fields.value}>
                <option value="5">5</option>
                <option value="4">4</option>
                <option value="3">3</option>
                <option value="2">2</option>
                <option value="1">1</option>
            </select>
        </div>
    </div>
</div>


