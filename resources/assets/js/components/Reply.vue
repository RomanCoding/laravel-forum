<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <a href="'/profiles/' + data.owner.id"
               v-text="data.owner.name">

            </a> said {{ data.created_at }}...
        </div>

        <div class="panel-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                    <button class="btn btn-primary btn-xs" @click="update">Update</button>
                    <button class="btn btn-link btn-xs" @click="cancel">Cancel</button>
                </div>
            </div>
            <div v-else v-text="body"></div>
        </div>

        <like :subject="data" subjectType="reply" v-if="authenticated"></like>

        <div v-if="canEdit">
            <button class="btn btn-primary btn-xs" @click="editing=true">Edit</button>
            <button class="btn btn-danger btn-xs" @click="destroy">Delete</button>
        </div>
    </div>
    <!--</reply>-->

</template>

<script>
    import Like from './Like.vue';
    export default {
        props: ['data'],
        components: {Like},
        data() {
            return {
                editing: false,
                body: this.data.body,
                id: this.data.id,
                initialBody: this.data.body
            }
        },
        computed: {
            authenticated() {
                return !!(window.App.auth);
            },
            canEdit() {
                return this.authorize(user => this.data.owner.id == user.id);
            }
        },
        methods: {
            update() {
                axios.patch('/replies/' + this.data.id, {
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
                axios.delete('/replies/' + this.data.id).then(() => {
                    this.$emit('deleted', this.data.id);
                });
            }
        }
    }
</script>