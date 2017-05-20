<template>
    <button :class="classes" v-text="text" @click="toggle"></button>
</template>

<script>
    export default {
        props: ['subscribed'],
        computed: {
            classes()  {
                return ['btn', this.active ? 'btn-primary' : 'btn-default'];
            },
            text() {
                return this.active ? 'Unsubscribe' : 'Subscribe';
            }
        },
        data() {
            return {
                active: this.subscribed,
                endpoint: location.pathname + '/subscribe'
            }
        },
        methods: {
            toggle()  {
                this.active ? this.unsubscribe() : this.subscribe();
            },
            subscribe() {
                axios.post(this.endpoint).then(() => {
                    flash('Subscribed!');
                    this.active = true;
                });
            },
            unsubscribe() {
                axios.delete(this.endpoint).then(() => {
                    flash('Unsubscribed!');
                    this.active = false;
                });
            }
        }
    }
</script>