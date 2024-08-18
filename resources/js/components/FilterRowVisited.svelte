<script>

    export let fields = {
        operator: "is"
    }

</script>

<div>
    <select class="form-select form-select-sm" bind:value={fields.operator}>
        <option value="is">is visited</option>
        <option value="isnot">is not visited</option>
    </select>
</div>
