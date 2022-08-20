<template>
    <div>
        <select class="form-select form-select-sm" v-model="fields.operator">
            <option value="is">has a UNESCO World Heritage List link</option>
            <option value="isnot">has no UNESCO World Heritage List link</option>
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
