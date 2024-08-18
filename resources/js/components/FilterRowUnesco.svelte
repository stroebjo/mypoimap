<script>
    export let fields = {
        operator: "is"
    }
</script>

<div>
    <select class="form-select form-select-sm" bind:value={fields.operator}>
        <option value="is">has a UNESCO World Heritage List link</option>
        <option value="isnot">has no UNESCO World Heritage List link</option>
    </select>
</div>
