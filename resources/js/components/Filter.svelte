<svelte:options
    customElement={{
        tag: "my-filter",
        shadow: 'none',
    }}
/>

<script>
    import { onMount } from 'svelte';

    import FilterRowDate from './FilterRowDate.svelte';
    import FilterRowPriority from './FilterRowPriority.svelte';
    import FilterRowTag from './FilterRowTag.svelte';
    import FilterRowUnesco from './FilterRowUnesco.svelte';
    import FilterRowVisited from './FilterRowVisited.svelte';
    import FilterRowWkt from './FilterRowWkt.svelte';


    export let fields = {
        title: "",
        description: "",
        filters: [],
        filter_operator: 'and',
        visibility: 'private'
    };

    let errors = {};
    let success = false;
    let loaded = true;
    let edit = false;

    let options = [
        { text: 'Tag', value: 'tag' },
        { text: 'Priority', value: 'priority' },
        { text: 'UNESCO', value: 'unesco' },
        { text: 'Geofence (WKT)', value: 'wkt' },
        { text: 'Visited', value: 'visited' },
        { text: 'Creation date', value: 'creation_date' },
        { text: 'Visited date', value: 'visited_date' }
    ];

    onMount(async () => {
        // check for edit form
        if (typeof filter_edit !== "undefined") {
            fields = filter_edit;
            edit = true;
        }
    });

    function submit() {
        if (loaded) {
            loaded = false;
            success = false;
            errors = {};

            if (edit) {
                axios.put('/filter/'+filter_edit.id, fields).then(response => {
                    loaded = true;
                    success = true;
                }).catch(error => {
                    loaded = true;
                    if (error.response.status === 422) {
                        errors = error.response.data.errors || {};
                    }
                });
            } else {
                axios.post('/filter', fields).then(response => {
                    fields = {}; //Clear input fields.
                    loaded = true;
                    success = true;
                }).catch(error => {
                    loaded = true;
                    if (error.response.status === 422) {
                        errors = error.response.data.errors || {};
                    }
                });
            }
        }
    }


    function remove_filter(index) {
        fields.filters.splice(index, 1);
        fields.filters = fields.filters; // svelte binding needs assignment, splice() won't update!
    }

    function add_filter_after(index) {
        fields.filters.splice(index+1, 0, _new_filter());
        fields.filters = fields.filters; // svelte binding needs assignment, splice() won't update!
    }

    function _new_filter() {
        return {
            type: options[0].value,
            fields: {}
        };
    }

</script>

<div class="container">
<form on:submit|preventDefault={submit}>
    <div class="mb-3 row">
        <label for="title" class="col-md-4 col-form-label text-md-right">Title</label>
        <div class="col-md-6">
            <input id="title" type="text" class="form-control" bind:value={fields.title} required>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>

        <div class="col-md-6">
            <textarea rows="8" id="description"  class="form-control" bind:value={fields.description}></textarea>
            <small class="form-text text-muted">You can use Markdown.</small>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="visibility" class="col-md-4 col-form-label text-md-right">Visibility</label>

        <div class="col-md-6">
            <select id="visibility" class="form-select" bind:value={fields.visibility}>
                <option value="private">Private</option>
                <option value="visible_by_link">Public (unlisted)</option>
            </select>
        </div>
    </div>

    <hr>

    <div class="mb-3 row">
        <div class="col-2">
            <select class="form-select form-select-sm" bind:value={fields.filter_operator}>
                <option value="and">All</option>
                <option value="or">Any</option>
            </select>
        </div>
        <div class="col-8">
            of the following are true.
        </div>
        <div class="col-2">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-sm btn-outline-secondary" on:click={() => add_filter_after(0)}>+</button>
            </div>
        </div>
    </div>

    <div class="ms-3">
    {#each fields.filters as filter, index}
        <div class="mb-3 row mb-2">
            <div class="col-md-3">
                <select class="form-select form-select-sm" bind:value={filter.type}>
                    {#each options as option}
                    <option value="{ option.value }">{ option.text }</option>
                    {/each}
                </select>
            </div>
            <div class="col-md-7">

                {#if filter.type == 'visited'}
                    <FilterRowVisited fields={filter.fields}/>
                {:else if filter.type == 'wkt'}
                    <FilterRowWkt fields={filter.fields}/>
                {:else if filter.type == 'unesco'}
                    <FilterRowUnesco fields={filter.fields}/>
                {:else if filter.type == 'tag'}
                    <FilterRowTag fields={filter.fields}/>
                {:else if filter.type == 'priority'}
                    <FilterRowPriority fields={filter.fields}/>
                {:else if filter.type == 'creation_date'}
                    <FilterRowDate fields={filter.fields}/>
                {:else if filter.type == 'visited_date'}
                    <FilterRowDate fields={filter.fields}/>
                {:else}
                    ...
                {/if}

            </div>
            <div class="col-md-2">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-sm btn-outline-danger" on:click={() => remove_filter(index)}>-</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary ms-1" on:click={() => add_filter_after(index)}>+</button>
                </div>
            </div>

        </div>
    {/each}
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
