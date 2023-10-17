<template>
    <div>
        <p>calculator field here</p>
        {{  options  }}
    </div>
</template>

<script>
export default {
    mixins: [Fieldtype],
    data() {
        return {
            //
        }
    },
    computed: {
        options() {
            return this.config.options;
        }
    }   
}

</script>
