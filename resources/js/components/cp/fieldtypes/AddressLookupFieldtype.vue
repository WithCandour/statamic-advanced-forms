<template>
    <div class="field-inner w-full">
        <div class="w-full mb-2">
            <label for="field_organisation" class="publish-field-label mb-1" v-text="__('Organisation')"></label>
            <text-input v-model="value.organisation" id="field_organisation" :disabled="readOnly" />
        </div>

        <div class="w-full mb-2">
            <label for="field_address-line-one" class="publish-field-label mb-1" v-text="__('Address')"></label>
            <text-input v-model="value.address_line_one" id="field_address-line-one" class="mb-1" :disabled="readOnly" />
            <text-input v-model="value.address_line_two" id="field_address-line-two" class="mb-1" :disabled="readOnly" />
            <text-input v-model="value.address_line_three" id="field_address-line-three" class="mb-1" :disabled="readOnly" />
        </div>

        <div class="w-full mb-2">
            <label for="field_town" class="publish-field-label mb-1" v-text="__('Town')"></label>
            <text-input v-model="value.posttown" id="field_town" :disabled="readOnly" />
        </div>

        <div class="w-full mb-2">
            <label for="field_postcode" class="publish-field-label mb-1" v-text="__('Postcode')"></label>
            <text-input v-model="value.postcode" id="field_postcode" :disabled="readOnly" />
        </div>
    </div>
</template>

<script>
export default {
    mixins: [Fieldtype],
    data() {
        return {
            //
        }
    }
}

</script>
