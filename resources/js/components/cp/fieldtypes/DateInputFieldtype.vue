<template>
    <text-input v-model="value" id="field_dateInput" :disabled="readOnly" />
</template>
<script>

export default {
    mixins: [Fieldtype],
}

</script>
