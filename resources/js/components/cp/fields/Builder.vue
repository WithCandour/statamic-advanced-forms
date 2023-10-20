<template>

    <div class="blueprint-builder">

        <header class="mb-3">
            <div class="flex items-center justify-between">
                <h1 v-text="__('Fields')" />
                <button type="submit" class="btn-primary" @click.prevent="save" v-text="__('Save')" />
            </div>
        </header>

        <div class="content mt-5 mb-2">
            <div class="card p-3 mb-2 flex justify-between items-center">
                <div class="w-2/3">
                    <h3>{{ __('advanced-forms::fields.pagination_enable') }}</h3>
                    <div class="help-block -mt-1 mb-0">
                        {{ __('advanced-forms::fields.pagination_introduction') }}
                    </div>
                </div>
                <div class="w-1/3 flex justify-end">
                    <toggle-fieldtype v-model="blueprint.paginated" />
                </div>
            </div>

            <div v-if="errors.sections">
                <small class="help-block text-red" v-for="(error, i) in errors.sections" :key="i" v-text="error" />
            </div>
        </div>

        <sections
            :initial-sections="blueprint.tabs[0].sections"
            :add-section-text="__('advanced-forms::fields.add_page')"
            :single-section="!blueprint.paginated"
            @updated="sectionsUpdated"
        />

    </div>

</template>

<script>
export default {
    components: {
        Sections: Statamic.$app.components.BlueprintBuilder.components.Tabs.components.TabContent.components.Sections
    },

    props: {
        action: String,
        initialBlueprint: Object,
        initialPaginated: Boolean,
    },

    data() {
        return {
            blueprint: {
                ...this.initializeBlueprint(),
                paginated: this.initialPaginated,
            },
            sections: [],
            errors: {}
        }
    },

    created() {
        this.$keys.bindGlobal(['mod+s'], e => {
            e.preventDefault();
            this.save();
        });

        Statamic.$config.set('isFormBlueprint', true);
        Statamic.$config.set('selectedFormFields', this.initialBlueprint.tabs[0].sections[0].fields);
    },


    watch: {
        sections(sections) {
            this.blueprint.sections = sections;
        },

        blueprint: {
            deep: true,
            handler() {
                this.$dirty.add('blueprints');
            }
        }
    },

    methods: {
        initializeBlueprint() {
            let blueprint = clone(this.initialBlueprint);
            return blueprint;
        },

        sectionsUpdated(sections) {
            this.sections = sections;
        },

        save() {
            this.$axios['patch'](this.action, this.blueprint)
                .then(response => this.saved(response))
                .catch(e => {
                    this.$toast.error(e.response.data.message);
                    this.errors = e.response.data.errors;
                })
        },

        saved(response) {
            this.$toast.success(__('Saved'));
            this.errors = {};
            this.$dirty.remove('blueprints');
        }
    }
}
</script>
