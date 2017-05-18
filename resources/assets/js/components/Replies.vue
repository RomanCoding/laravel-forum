<template>
    <div>
        <div v-for="(reply, index) in items">
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>
        <new-reply :endpoint="endpoint" @replied="add"></new-reply>
    </div>
</template>

<script>
    import Reply from './Reply.vue';
    import NewReply from './NewReply.vue';
    export default {
        props: ['data'],
        components: { Reply, NewReply },
        data() {
            return {
                items: this.data,
                endpoint: location.pathname
            }
        },
        methods: {
            remove(id) {
                this.items.splice(id, 1);
                this.$emit('removed');
                flash('Reply has been deleted');
            },
            add(reply) {
                this.items.push(reply);
                this.$emit('added');
            }
        }
    }
</script>