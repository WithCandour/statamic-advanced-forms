<template>
    <text-input v-model="value" id="field_monthInput" :disabled="readOnly" />
</template>
<script>

export default {
    mixins: [Fieldtype],
}

</script>
