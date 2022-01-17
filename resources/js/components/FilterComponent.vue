<template>
    <div class="container">
        <form @submit.prevent="submit">
            <div class="mb-3 row">
                <label for="title" class="col-md-4 col-form-label text-md-right">Title</label>

                <div class="col-md-6">
                    <input id="title" type="text" class="form-control" v-model="fields.title" required>

                    <span class="invalid-feedback" role="alert" v-if="errors && errors.title">
                        <strong>{{ errors.name[0] }}</strong>
                    </span>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>

                <div class="col-md-6">
                    <textarea rows="8" id="description"  class="form-control" v-model="fields.description"></textarea>
                    <small class="form-text text-muted">You can use Markdown.</small>

                    <span class="invalid-feedback" role="alert" v-if="errors && errors.description">
                        <strong>{{ errors.description[0] }}</strong>
                    </span>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="visibility" class="col-md-4 col-form-label text-md-right">Visibility</label>

                <div class="col-md-6">

                    <select id="visibility" class="form-control" v-model="fields.visibility">
                        <option value="private">Private</option>
                        <option value="visible_by_link">Public (unlisted)</option>
                    </select>

                    <span class="invalid-feedback" role="alert" v-if="errors && errors.visibility">
                        <strong>{{ errors.visibility[0] }}</strong>
                    </span>
                </div>
            </div>

            <hr>

            <div class="mb-3 row">
                <div class="col-2">
                    <select class="form-control form-control-sm" v-model="fields.filter_operator">
                        <option value="and">All</option>
                        <option value="or">Any</option>
                    </select>
                </div>
                <div class="col-8">
                    of the following are true.
                </div>
                <div class="col-2">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-sm btn-outline-secondary" v-on:click="add_filter_after(0)">+</button>
                    </div>
                </div>
            </div>

            <div class="ms-3" v-for="(filter, index) in fields.filters">

                <div class="mb-3 row mb-2">
                    <div class="col-md-3">
                        <select class="form-control form-control-sm" v-model="filter.type">
                            <option v-for="option in options" v-bind:value="option.value">
                                {{ option.text }}
                            </option>
                        </select>
                    </div>

                    <div class="col-md-7">
                        <div v-if="filter.type == 'tag'">
                            <filterrow-tag v-bind:fields="filter.fields"></filterrow-tag>
                        </div>

                        <div v-if="filter.type == 'priority'">
                            <filterrow-priority v-bind:fields="filter.fields"></filterrow-priority>
                        </div>

                        <div v-if="filter.type == 'unesco'">
                            <filterrow-unesco v-bind:fields="filter.fields"></filterrow-unesco>
                        </div>

                        <div v-if="filter.type == 'wkt'">
                            <filterrow-wkt v-bind:fields="filter.fields"></filterrow-wkt>
                        </div>

                        <div v-if="filter.type == 'visited'">
                            <filterrow-visited v-bind:fields="filter.fields"></filterrow-visited>
                        </div>

                        <div v-if="filter.type == 'creation_date'">
                            <filterrow-date v-bind:fields="filter.fields"></filterrow-date>
                        </div>

                        <div v-if="filter.type == 'visited_date'">
                            <filterrow-date v-bind:fields="filter.fields"></filterrow-date>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-sm btn-outline-danger" v-on:click="remove_filter(index)">-</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary ms-1" v-on:click="add_filter_after(index)">+</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3 row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                fields: {
                    filters: [],
                    filter_operator: 'and',
                    visibility: 'private'
                },
                errors: {},
                success: false,
                loaded: true,
                edit: false,

                options: [
                    { text: 'Tag', value: 'tag' },
                    { text: 'Priority', value: 'priority' },
                    { text: 'UNESCO', value: 'unesco' },
                    { text: 'Geofence (WKT)', value: 'wkt' },
                    { text: 'Visited', value: 'visited' },
                    { text: 'Creation date', value: 'creation_date' },
                    { text: 'Visited date', value: 'visited_date' }
                ]
            };
        },

        methods: {
            submit: function() {
                if (this.loaded) {
                    this.loaded = false;
                    this.success = false;
                    this.errors = {};

                    if (this.edit) {
                        axios.put('/filter/'+filter_edit.id, this.fields).then(response => {
                            this.loaded = true;
                            this.success = true;
                        }).catch(error => {
                            this.loaded = true;
                            if (error.response.status === 422) {
                                this.errors = error.response.data.errors || {};
                            }
                        });
                    } else {
                        axios.post('/filter', this.fields).then(response => {
                            this.fields = {}; //Clear input fields.
                            this.loaded = true;
                            this.success = true;
                        }).catch(error => {
                            this.loaded = true;
                            if (error.response.status === 422) {
                                this.errors = error.response.data.errors || {};
                            }
                        });

                    }
                }
            },

            remove_filter: function(index) {
                this.fields.filters.splice(index, 1);
            },

            add_filter_after: function(index) {
                this.fields.filters.splice(index+1, 0, this._new_filter());
            },

            _new_filter: function() {
                return {
                    type: this.options[0].value,
                    fields: {}
                };
            }
        },

        mounted() {
			// check for edit form
			if (typeof filter_edit !== "undefined") {
                this.fields = filter_edit;
                this.edit = true;
			}
        }
    }
</script>
