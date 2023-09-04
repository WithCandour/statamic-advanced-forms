<template>
    <div>
        <publish-fields-container class="card p-0 mb-3 configure-section">
            <form-group
                handle="title"
                class="border-b"
                :display="__('Title')"
                :errors="errors.title"
                v-model="title"
            />

            <form-group
                handle="expires_entries"
                class="border-b"
                :display="__('Expires Entries')"
                :errors="errors.expires_entries"
                fieldtype="toggle"
                v-model="expiresEntries"
            />

            <form-group
                v-if="expiresEntries === true"
                handle="entry_lifespan"
                class="border-b"
                :display="__('Entry Lifespan')"
                :errors="errors.entry_lifespan"
                v-model="entryLifespan"
            />
        </publish-fields-container>

        <div class="py-2 mt-3 border-t flex justify-between">
            <a :href="indexUrl" class="btn">Cancel</a>
            <button type="submit" class="btn-primary" @click="save">{{ __('Save') }}</button>
        </div>

    </div>
</template>
<script>
export default {
    props: {
        initialTitle: { type: String },
        initialExpires: { type: Boolean, default: false },
        initialLifespan: { type: Number, default: 30 },
        indexUrl: { type: String },
        action: { type: String },
        method: { type: String },
    },

    data() {
        return {
            error: null,
            errors: {},
            title: this.initialTitle,
            expiresEntries: this.initialExpires,
            entryLifespan: this.initialLifespan,
        }
    },

    computed: {
        payload() {
            return {
                title: this.title,
                expiresEntries: this.expiresEntries,
                entryLifespan: this.entryLifespan,
            }
        },
    },

    methods: {
        clearErrors() {
            this.error = null;
            this.errors = {};
        },
        save() {
            this.clearErrors();
            this.$axios[this.method](this.action, this.payload).then(response => {
                window.location = response.data.redirect;
            }).catch(e => {
                if (e.response && e.response.status === 422) {
                    const { message, errors } = e.response.data;
                    this.error = message;
                    this.errors = errors;
                    this.$toast.error(message);
                } else {
                    this.$toast.error(__('Unable to save form'));
                }
            });
        }
    },
}
</script>
