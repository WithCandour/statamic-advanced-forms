<template>
    <text-input v-model="value" id="field_timeInput" :disabled="readOnly" />
</template>
<script>

export default {
    mixins: [Fieldtype],
}

</script>
