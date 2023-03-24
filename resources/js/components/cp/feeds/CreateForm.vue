<template>
    <div class="max-w-lg mt-2 mx-auto">

        <div class="rounded p-3 lg:px-7 lg:py-5 shadow bg-white">
            <header class="text-center mb-6">
                <h1 class="mb-3" v-text="heading" />
                <p class="text-grey" v-text="introduction" />
            </header>
            <div class="mb-3">
                <label class="font-bold text-base mb-sm" for="name">{{ __('Title') }}</label>
                <input type="text" v-model="title" class="input-text" autofocus tabindex="1">
            </div>
            <div class="mb-3">
                Feed type: <code>{{ feed_type_name }}</code>
            </div>
        </div>

        <div class="flex justify-center mt-4">
            <button tabindex="4" class="btn-primary mx-auto btn-lg" :disabled="! canSubmit" @click="submit">
                {{ button_label }}
            </button>
        </div>
    </div>
</template>

<script>

export default {

    props: {
        route: {
            type: String
        },
        heading: {
            type: String,
        },
        introduction: {
            type: String,
        },
        button_label: {
            type: String,
        },
        feed_type: {
            type: String
        },
        feed_type_name: {
            type: String
        }
    },

    data() {
        return {
            title: null,
            type: this.feed_type,
        }
    },

    computed: {
        canSubmit() {
            return Boolean(this.title) && Boolean(this.type);
        },
    },

    methods: {
        submit() {
            this.$axios.post(this.route, {title: this.title, type: this.feed_type}).then(response => {
                window.location = response.data.redirect;
            }).catch(error => {
                this.$toast.error(error.response.data.message);
            });
        }
    },

    mounted() {
        this.$keys.bindGlobal(['return'], e => {
            if (this.canSubmit) {
                this.submit();
            }
        });
    }
}
</script>
