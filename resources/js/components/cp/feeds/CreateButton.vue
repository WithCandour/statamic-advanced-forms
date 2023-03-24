<template>
    <dropdown-list class="inline-block" :disabled="!feedTypesAvailable">
        <template v-slot:trigger>
            <button
                :class="[buttonClass, {'flex items-center pr-2': feedTypesAvailable }]"
                :disabled="!feedTypesAvailable"
            >
                {{ text }}
                <svg-icon name="chevron-down-xs" class="w-2 ml-1" v-if="feedTypesAvailable" />
            </button>
        </template>
        <h6 v-text="__('advanced-forms::feeds.choose_type')" class="p-1" />

        <div v-for="feedType in feedTypes" :key="feedType.handle">
            <dropdown-item :text="feedType.title" @click="create(feedType.handle, $event)" />
        </div>
    </dropdown-list>
</template>
<script>
export default {

    props: {
        url: String,
        feedTypes: Array,
        text: {
            type: String,
            default: () => __('advanced-forms::feeds.create'),
        },
        buttonClass: {
            type: String,
            default: 'btn'
        }
    },

    computed: {

        feedTypesAvailable() {
            return this.feedTypes.length > 0;
        }

    },

    methods: {

        create(feedType, $event) {
            const createUrl = `${this.url}?type=${feedType}`;
            $event.metaKey ? window.open(this.create) : window.location = createUrl;
        }

    }
}

</script>
