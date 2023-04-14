<template>
    <div class="advanced-forms-note py-2">
        <div class="mb-1">
            <h3 class="flex items-center">
                <span :class="badgeClasses(type)" v-text="type"></span>
                <span v-text="title"></span>
            </h3>
            <p class="text-xs" v-text="date"></p>
        </div>
        <div class="advanced-forms-note__note p-2 rounded" v-html="renderMarkdownAndLinks(note)"></div>
    </div>
</template>
<style>
.advanced-forms-note {
    border-style: solid;
    border-color: #19292f;
    border-width: 1px 0 0;
}

.advanced-forms-note__note {
    background-color: #eef2f6;
}
</style>
<script>
import { marked } from 'marked';

export default {
    props: {
        title: String,
        date: String,
        type: String,
        note: String,
    },

    methods: {
        renderMarkdownAndLinks(text) {
            var renderer = new marked.Renderer();

            renderer.link = function(href, title, text) {
                var link = marked.Renderer.prototype.link.call(this, href, title, text);
                return link.replace("<a","<a target='_blank' ");
            };

            marked.setOptions({
                renderer: renderer
            });

            return marked(text);
        },
        badgeClasses(noteType) {
            let classes = 'badge-sm mr-1';

            switch(noteType) {
                case 'SUCCESS':
                    classes += ' bg-green';
                    break;
                case 'INFO':
                    classes += ' bg-blue-light';
                    break;
                case 'WARNING':
                    classes += ' bg-orange';
                    break;
                case 'ERROR':
                    classes += ' bg-red';
                    break;
            }

            return classes;
        }
    }
}
</script>
