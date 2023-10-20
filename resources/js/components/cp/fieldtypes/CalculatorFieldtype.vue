<template>
    <div>
        <span class="font-bold text-sm">Select a shortcode</span>
        <div class="flex flex-wrap items-center justify-start mb-2">
            <div class="mr-2 text-sm cursor-pointer hover:bg-black hover:text-white" v-for="(field, index) in selectableFields" key="index" @click="addShortCodeToValue(field.handle)">
                <code>[{{ field.handle }}]</code>
            </div>
        </div>
        <text-input 
            :value="value"
            @input="updateDebounced"
            @focus="$emit('focus')"
            @blur="$emit('blur')"    
            id="field_calculator">
        </text-input>
    </div>
</template>

<script>
export default {
    mixins: [Fieldtype],
    data() {
        return {
            formFields: [],
        }
    },
    created() {
        this.formFields = Statamic.$config.get('selectedFormFields')
    },
    methods: {
        addShortCodeToValue(field) {
            //this.value = this.value += '[' + field + ']'
            this.update(this.value += '[' + field + ']')
        },
        updateValue() {
            this.$emit('input', this.value)
        }
    },
    computed: {
        options() {
            return this.config.options;
        },
        selectableFields() {
            return this.formFields.filter((field) => { 
                return (field.icon === 'number_input' && field.config.enable_calculations === false ) })
        }
    }   
}

</script>
