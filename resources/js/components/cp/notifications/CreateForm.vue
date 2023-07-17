<template>
    <p>TEST</p>
</template>

<!-- <template>
    <div class="max-w-lg mt-2 mx-auto">

        <div class="rounded p-3 lg:px-7 lg:py-5 shadow bg-white">
            <header class="text-center mb-6">
                <h1 class="mb-3">{{ heading }}</h1>
                <p class="text-grey">{{ introduction }}</p>
            </header>
            <div class="mb-5">
                <label class="font-bold text-base mb-sm">{{ __('Title') }}</label>
                <input type="text" v-model="title" class="input-text" autofocus tabindex="1">
                <div class="text-2xs text-grey-60 mt-1 flex items-center" v-if="title_instructions">
                    {{  title_instructions  }}
                </div>
            </div>
            <div class="mb-5">
                <label class="font-bold text-base mb-sm">{{ __('Description') }}</label>
                <input type="textarea" v-model="description" class="input-textarea" tabindex="2">
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
        title_instructions: {
            type: String,
        },
        button_label: {
            type: String,
        }
    },

    data() {
        return {
            title: null,
            description: null,
        }
    },

    computed: {
        canSubmit() {
            return Boolean(this.title);
        },
    },

    methods: {
        submit() {
            this.$axios.post(this.route, {
                title: this.title,
                description: this.description, 
                handle: this.handle
            }).then(response => {
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
</script> -->
