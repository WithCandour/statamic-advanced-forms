<template>
    <text-input v-model="value" id="field_colorInput" :disabled="readOnly" />
</template>
<script>

export default {
    mixins: [Fieldtype],
}

</script>
