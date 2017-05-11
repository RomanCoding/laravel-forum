<template>
    <button :class="classes" @click="toggle">
        <span class="glyphicon glyphicon-heart">{{ this.count }}</span>
    </button>
</template>

<script>
    export default {
        props: ['subject'],
        data() {
            return {
                count: this.subject.likesCount,
                isLiked: this.subject.isLiked,
            }
        },
        computed: {
            classes: function() {
                return 'btn btn-xs' + (this.isLiked ? ' btn-primary' : '');
            },
            path: function() {
                return '/likes/' + this.subject.model + '/' + this.subject.id;
            }
        },
        methods: {
            toggle() {
                this.isLiked ? this.unlike() : this.like();
            },
            unlike() {
                axios.delete(this.path).then(() => {
                    this.count--;
                    this.isLiked = false;
                });
            },
            like() {
                axios.post(this.path).then(() => {
                    this.count++;
                    this.isLiked = true;
                });
            },
        }
    }
</script>