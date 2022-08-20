<template>
    <div>
        <div class="row">
            <div class="col-6">
                <select class="form-select form-select-sm" v-model="fields.operator">
                    <option value="is">is</option>
                    <option value="less">is less than</option>
                    <option value="greater">is greater than</option>
                </select>
            </div>
            <div class="col-6">
                <input v-model="fields.value" class="form-control form-control-sm" type="date">
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
