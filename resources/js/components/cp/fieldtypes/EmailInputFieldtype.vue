<template>
    <text-input v-model="value" id="field_emailInput" :disabled="readOnly" />
</template>
<script>

export default {
    mixins: [Fieldtype],
}

</script>
