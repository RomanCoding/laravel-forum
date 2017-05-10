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
                    flash('Updated a reply!');
                });
            },
            cancel() {
                this.body = this.initialBody;
                this.editing = false;
            }
        }
    }
</script>