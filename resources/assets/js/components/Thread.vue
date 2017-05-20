<script>
    import Replies from './Replies.vue';
    import SubscriptionButton from './SubscriptionButton.vue';
    export default {
        props: ['initRepliesCount'],
        components: { Replies, SubscriptionButton },
        data() {
            return {
                repliesCount: this.initRepliesCount
            };
        }
    }
</script>