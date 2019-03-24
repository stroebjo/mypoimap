<template>
    <div>
        <div class="row">
            <div class="col-4">
                <select class="form-control form-control-sm" v-model="fields.operator">
                    <option value="is">is</option>
                    <option value="less">is lower</option>
                    <option value="greater">is greater</option>
                </select>
            </div>
            <div class="col-8">
                <select  class="form-control form-control-sm" v-model="fields.value">
                    <option vlaue="5">5</option>
                    <option vlaue="4">4</option>
                    <option vlaue="3">3</option>
                    <option vlaue="2">2</option>
                    <option vlaue="1">1</option>
                </select>
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
