import Prism from 'prismjs';

export default {
    methods: {
        highlight() {
            const el = this.$refs.bodyHtml;
            console.log(el);
            if (el) Prism.highlightAllUnder(el);
        }
    }
}
