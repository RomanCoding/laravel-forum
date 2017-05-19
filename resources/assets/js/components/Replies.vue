<template>
    <div>
        <div v-for="(reply, index) in items">
            <reply :data="reply" :key="reply.id" @deleted="remove(index)"></reply>
        </div>
        <paginator :data="this.dataSet" @pageChanged="fetch"></paginator>
        <new-reply :endpoint="endpoint" @replied="add"></new-reply>
    </div>
</template>

<script>
    import Reply from './Reply.vue';
    import NewReply from './NewReply.vue';
    export default {
        components: { Reply, NewReply },
        data() {
            return {
                dataSet: false,
                items: [],
                endpoint: location.pathname
            }
        },
        created() {
            this.fetch();
        },
        methods: {
            fetch(page) {
                axios.get(this.url(page))
                    .then(this.refresh);
            },
            url(page) {
                if (!page) {
                    let query = location.search.match(/page=(\d+)/);
                    page = query ? query[1] : 1;
                }
                return location.pathname + '/replies?page=' + page;
            },
            refresh(response) {
                this.dataSet = response.data;
                this.items = response.data.data;
            },
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