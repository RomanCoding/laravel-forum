<template>
    <div class="alert alert-success alert-flash" role="alert" v-show="visible">
        <strong>Success!</strong> {{ this.body }}
    </div>
</template>

<script>
    export default {
        props: ['message'],
        data() {
            return {
                body: '',
                visible: false
            };
        },
        created() {
            if (this.message) {
                this.flash(this.message);
            }
            window.events.$on('flash', message => {
                this.flash(message);
            });
        },
        methods: {
            flash(message) {
                this.body = message;
                this.visible = true;
                this.hide();
            },
            hide() {
                setTimeout(() => {
                    this.visible = false;
                }, 3000)
            }
        }
    }
</script>

<style>
    .alert-flash {
        position: fixed;
        right: 20px;
        bottom: 20px;
    }
</style>
