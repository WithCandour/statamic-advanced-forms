<template>
    <password-input v-model="value" id="field_passwordInput" :disabled="readOnly" />
</template>
<script>

export default {
    mixins: [Fieldtype],
}

</script>
