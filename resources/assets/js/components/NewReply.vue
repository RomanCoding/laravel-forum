<template>
    <div v-if="authenticated">
        <div class="form-group">
            <textarea name="body"
                      class="form-control"
                      placeholder="Write you reply here..."
                      v-model="body"></textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary" @click="submit">Reply</button>
        </div>
    </div>
    <p class="text-center" v-else>
        <a href="/login">Sign in</a> to participate in discussion.
    </p>
</template>

<script>
    export default {
        props: ['endpoint'],
        data() {
            return {
                body: ''
            }
        },
        computed: {
            authenticated() {
                return !!window.App.auth;
            }
        },
        methods: {
            submit() {
                axios.post(this.endpoint, {body: this.body})
                    .then(({data}) => {
                        this.body = '';
                        flash('Replied!');
                        this.$emit('replied', data);
                    });
            }
        }
    }
</script>