<template>
    <div>
        <div class="row">
            <div class="col-4">
                <select class="form-select form-select-sm" v-model="fields.operator">
                    <option value="is">is inside</option>
                    <option value="isnot">is not inisde</option>
                </select>
            </div>
            <div class="col-8">
                <input v-model="fields.value" class="form-control form-control-sm" type="text">
            </div>
            <div class="col-12">
                <small class="text-muted">See this <a href="https://clydedacruz.github.io/openstreetmap-wkt-playground/" target="_blank">WKT editor</a> for creating polygons.</small>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {

            };
        },

        props: ['fields'],

        mounted() {
        }
    }
</script>
