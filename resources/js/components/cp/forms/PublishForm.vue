<template>
    <div>

        <publish-fields-container class="card p-0 mb-3 configure-section">
                <form-group
                    handle="title"
                    class="border-b"
                    :display="__('Title')"
                    :errors="errors.title"
                    v-model="title"
                    :focus="true"
                />
        </publish-fields-container>

        <div class="py-2 mt-3 border-t flex justify-between">
            <a :href="indexUrl" class="btn" v-text="__('Cancel') "/>
            <button type="submit" class="btn-primary" @click="save">{{ __('Save') }}</button>
        </div>

    </div>
</template>
<script>
export default {
    props: {
        initialTitle: String,
        indexUrl: String,
        action: String,
        method: String,
    },

    data() {
        return {
            error: null,
            errors: {},
            title: this.initialTitle,
        }
    },

    computed: {
        payload() {
            return {
                title: this.title,
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
