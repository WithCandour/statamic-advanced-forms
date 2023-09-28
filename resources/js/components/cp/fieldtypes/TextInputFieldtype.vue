<template>
    <text-input v-model="value" id="field_textInput" :disabled="readOnly" />
</template>
<script>

export default {
    mixins: [Fieldtype],
}

</script>
