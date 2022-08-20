<template>
    <div>
        <select class="form-select form-select-sm" v-model="fields.operator">
            <option value="is">is visited</option>
            <option value="isnot">is not visited</option>
        </select>
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
