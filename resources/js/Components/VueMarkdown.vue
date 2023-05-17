<script setup>
import { computed } from "vue";
import DOMPurify from "dompurify";

// markdown-it packages
import tocAndAnchor from "markdown-it-toc-and-anchor";
import MarkdownIt from "markdown-it";
import checkbox from "markdown-it-checkbox";
import emoji from "markdown-it-emoji";
import footnote from "markdown-it-footnote";
import container from "markdown-it-container";
import hljs from 'highlight.js';
import 'highlight.js/styles/atom-one-dark.css';

function renderHeadingOpen(tokens, idx) {
    const token = tokens[idx];
    const level = token.tag.slice(1);
    const content = tokens[idx + 1].content;
    if (props.customHeaderRender) {
        return props.customHeaderRender(level, content);
    }
    return `<${token.tag}>`;
}

function renderHeadingClose(tokens, idx) {
    const token = tokens[idx];
    if (props.customHeaderRender) {
        return "";
    }
    return `</${token.tag}>`;
}

const props = defineProps({
    markdown: {
        type: String,
        required: true,
    },
    syntaxStyle: {
        type: String,
        default: "default",
    },
    renderHTML: {
        type: Boolean,
        default: false,
    },
    linkify: {
        type: Boolean,
        default: true,
    },
    customHeaderRender: {
        type: Function,
        default: null,
    },
});

const md = new MarkdownIt({
    html: props.renderHTML,
    linkify: props.linkify,
    highlight: (str, lang) => {
        if (lang && hljs.getLanguage(lang)) {
            try {
                return hljs.highlight(str, { language: lang }).value;
            } catch (err) {
                console.log("Error in highlight.js:", err);
            }
        }
        return ""; // use external default escaping
    },
})
    .use(tocAndAnchor, {
        toc: true,
        anchorLink: true,
    })
    .use(checkbox)
    .use(emoji)
    .use(footnote)
    .use(container, "warning");

md.renderer.rules.heading_open = renderHeadingOpen;
md.renderer.rules.heading_close = renderHeadingClose;

const sanitize = (markdown) => {
    const dirtyHTML = md.render(markdown);
    return DOMPurify.sanitize(dirtyHTML);
};

const sanitizedMarkdown = computed(() => sanitize(props.markdown));

const getMd = () => md;
defineExpose({ getMd });
</script>

<template>
    <div :class="syntaxStyle">
        <div v-html="sanitizedMarkdown"></div>
    </div>
</template>
