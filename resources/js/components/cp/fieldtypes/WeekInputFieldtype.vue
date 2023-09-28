<template>
    <text-input v-model="value" id="field_weekInput" :disabled="readOnly" />
</template>
<script>

export default {
    mixins: [Fieldtype],
}

</script>
