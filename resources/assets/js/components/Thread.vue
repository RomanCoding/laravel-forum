<script>
    import Replies from './Replies.vue';
    export default {
        props: ['initRepliesCount'],
        components: { Replies },
        data() {
            return {
                repliesCount: this.initRepliesCount
            };
        }
    }
</script>