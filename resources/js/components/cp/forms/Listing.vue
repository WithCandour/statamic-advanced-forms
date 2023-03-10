<template>
    <data-list :visible-columns="columns" :columns="columns" :rows="items">
        <div class="card p-0 relative" slot-scope="{ filteredRows: rows }">
            <data-list-bulk-actions
                class="rounded"
                :url="actionUrl"
                @started="actionStarted"
                @completed="actionCompleted"
            />

            <data-list-table :allow-bulk-actions="true">
                <template slot="cell-title" slot-scope="{ row: form }">
                    <a :href="form.show_url">{{ form.title }}</a>
                </template>
                <template slot="actions" slot-scope="{ row: form, index }">
                    <dropdown-list>
                        <data-list-inline-actions
                            :item="form.id"
                            :url="actionUrl"
                            :actions="form.actions"
                            @started="actionStarted"
                            @completed="actionCompleted"
                        />
                    </dropdown-list>
                </template>
            </data-list-table>
        </div>
    </data-list>
</template>

<script>
export default {
    mixins: [Listing],
    props: ['initialColumns'],
    data() {
        return {
            columns: this.initialColumns,
            requestUrl: cp_url('advanced-forms'),
        }
    }
}
</script>
