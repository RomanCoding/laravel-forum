<script>
    export default {
        props: ['reply'],
        data() {
            return {
                editing: false,
                body: this.reply.body,
                initialBody: this.reply.body
            }
        },
        methods: {
            update() {
                axios.patch('/replies/' + this.reply.id, {
                    body: this.body
                }).then(() => {
                    this.editing = false;
                    flash('Reply has been updated!');
                });
            },
            cancel() {
                this.body = this.initialBody;
                this.editing = false;
            },
            destroy() {
                axios.delete('/replies/' + this.reply.id).then(() => {
                    $(this.$el).fadeOut(300, () => {
                        flash('Reply has been deleted!');
                    });
                });
            }
        }
    }
</script>