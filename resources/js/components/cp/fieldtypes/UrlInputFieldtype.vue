<template>
    <text-input v-model="value" id="field_urlInput" :disabled="readOnly" />
</template>
<script>

export default {
    mixins: [Fieldtype],
}

</script>
