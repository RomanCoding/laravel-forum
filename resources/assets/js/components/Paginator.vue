<template>
    <nav aria-label="..." v-if="shouldDisplay">
        <ul class="pager pull-right">
            <li v-if="prevUrl"><a href="#" @click.prevent="page--" rel="prev">&laquo; Prev</a></li>
            <li v-if="nextUrl"><a href="#" @click.prevent="page++" rel="next">Next &raquo;</a></li>
        </ul>
    </nav>
</template>

<script>
    export default {
        props: ['data'],
        data() {
            return {
                page: 1,
                prevUrl: false,
                nextUrl: false,
            }
        },
        computed: {
            shouldDisplay() {
                return !! (this.prevUrl || this.nextUrl);
            }
        },
        watch: {
            page() {
                this.$emit('pageChanged', this.page);
                history.pushState(null, null, '?page=' + this.page);
            },
            data() {
                this.prevUrl = this.data.prev_page_url;
                this.nextUrl = this.data.next_page_url;
                this.page = this.data.current_page;
            }
        }
    }
</script>