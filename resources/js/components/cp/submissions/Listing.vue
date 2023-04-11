<template>
    <div>

        <div v-if="initializing" class="card loading">
            <loading-graphic />
        </div>

        <data-list
            v-if="!initializing"
            :columns="columns"
            :rows="items"
            :sort="false"
            :sort-column="sortColumn"
            :sort-direction="sortDirection"
        >
            <div slot-scope="{ hasSelections }">
                <div class="card p-0 relative">

                    <data-list-bulk-actions
                        class="rounded"
                        :url="actionUrl"
                        @started="actionStarted"
                        @completed="actionCompleted"
                    />

                    <data-list-table
                        v-if="items.length"
                        :allow-bulk-actions="true"
                        :allow-column-picker="true"
                        :column-preferences-key="preferencesKey('columns')"
                    >
                        <template slot="cell-date" slot-scope="{ row: submission, value }">
                            <a :href="submission.url" class="text-blue">{{ value }}</a>
                        </template>
                        <template slot="actions" slot-scope="{ row: submission }">
                            <dropdown-list>
                                <dropdown-item :text="__('View')" :redirect="submission.url" />
                                <data-list-inline-actions
                                    :item="submission.id"
                                    :url="actionUrl"
                                    :actions="submission.actions"
                                    @started="actionStarted"
                                    @completed="actionCompleted"
                                />
                            </dropdown-list>
                        </template>
                    </data-list-table>

                </div>
                <data-list-pagination
                    v-if="paginated"
                    class="mt-3"
                    :resource-meta="meta"
                    :per-page="perPage"
                    :show-totals="true"
                    @page-selected="selectPage"
                    @per-page-changed="changePerPage"
                />
            </div>
        </data-list>
    </div>
</template>

<script>
export default {
    mixins: [Listing],

    props: [
        'initialColumns',
        'formId',
        'paginated'
    ],

    data() {
        return {
            columns: this.initialColumns,
            listingKey: 'columns',
            preferencesPrefix: `advanced-forms.${this.formId}`,
            requestUrl: cp_url(`advanced-forms/${this.formId}/submissions`),
        }
    },
}
</script>
