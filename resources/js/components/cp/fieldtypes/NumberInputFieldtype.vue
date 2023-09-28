<template>
    <text-input v-model="value" id="field_numberInput" :disabled="readOnly" />
</template>
<script>

export default {
    mixins: [Fieldtype],
}

</script>
