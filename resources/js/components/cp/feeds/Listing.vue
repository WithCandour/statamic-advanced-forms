<template>
    <div>

        <div v-if="initializing" class="card loading">
            <loading-graphic />
        </div>

        <data-list
            v-if="!initializing"
            :visible-columns="columns"
            :columns="columns"
            :rows="items"
        >
            <div class="card p-0 relative">

                <data-list-bulk-actions
                    class="rounded"
                    :url="actionUrl"
                    @started="actionStarted"
                    @completed="actionCompleted"
                />

                <data-list-table :allow-bulk-actions="true">
                    <template slot="cell-title" slot-scope="{ row: feed }">
                        <div class="flex items-center">
                            <div class="little-dot mr-1" :class="getEnabledClass(feed)" />
                            <a :href="feed.edit_url">{{ feed.title }}</a>
                        </div>
                    </template>
                    <template slot="actions" slot-scope="{ row: feed }">
                        <dropdown-list>
                            <dropdown-item :text="__('Edit')" :redirect="feed.edit_url" />
                            <data-list-inline-actions
                                :item="feed.id"
                                :url="actionUrl"
                                :actions="feed.actions"
                                @started="actionStarted"
                                @completed="actionCompleted"
                            />
                        </dropdown-list>
                    </template>
                </data-list-table>
            </div>
        </data-list>
    </div>
</template>

<script>
export default {
    mixins: [Listing],

    props: ['initialColumns', 'formId'],

    data() {
        return {
            columns: this.initialColumns,
            requestUrl: cp_url(`advanced-forms/${this.formId}/feeds`),
        }
    },

    methods: {
        getEnabledClass(feed) {
            return feed.enabled ? 'bg-green' : 'bg-grey-40'
        }
    }
}
</script>
