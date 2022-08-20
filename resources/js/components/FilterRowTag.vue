<template>
    <div>
        <div class="row">
            <div class="col-6">
                <select class="form-select form-select-sm" v-model="fields.operator">
                    <option value="has_any">has any</option>
                    <option value="has_all">has all</option>
                </select>
            </div>
            <div class="col-6">
                <input v-model="fields.value" class="form-control form-control-sm" type="text">
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
