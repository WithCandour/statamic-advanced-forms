<template>
    <div class="flex mt-1 -mx-1">
        <a v-for="file in files" :href="file" :key="file" target="_blank" rel="noopener" class="flex items-center justify-center btn-flat mx-1">
            <svg-icon class="w-5 h-5 mr-1" name="download" />
            <span>Download</span>
        </a>
    </div>
</template>
<script>

export default {
    mixins: [Fieldtype],

    computed: {
        files() {
            const vals = Array.isArray(this.value) ? this.value : [this.value];
            return vals;
        }
    }
}

</script>
