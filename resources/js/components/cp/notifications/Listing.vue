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
                    <template slot="cell-title" slot-scope="{ row: notification }">
                        <div class="flex items-center">
                            <div class="little-dot mr-1" :class="getEnabledClass(notification)" />
                            <a :href="notification.edit_url">{{ notification.title }}</a>
                        </div>
                    </template>
                    <template slot="actions" slot-scope="{ row: notification }">
                        <dropdown-list>
                            <dropdown-item :text="__('Edit')" :redirect="notification.edit_url" />
                            <data-list-inline-actions
                                :item="notification.id"
                                :url="actionUrl"
                                :actions="notification.actions"
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
            requestUrl: cp_url(`advanced-forms/${this.formId}/notifications`),
        }
    },

    methods: {
        getEnabledClass(notification) {
            return notification.enabled ? 'bg-green' : 'bg-grey-40'
        }
    }
}
</script>
