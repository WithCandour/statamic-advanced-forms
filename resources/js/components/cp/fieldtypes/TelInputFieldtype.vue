<template>
    <text-input v-model="value" id="field_telInput" :disabled="readOnly" />
</template>
<script>

export default {
    mixins: [Fieldtype],
}

</script>
