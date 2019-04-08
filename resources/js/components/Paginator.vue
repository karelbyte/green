<template>
    <div>
        <ul v-if="tpage > 1" class="pagination pagination-sm pagination-split pag_fix mouse">
            <li :class="{hide: currentpage === 1}"><a @click = "setpage(1)"> <span class="glyphicon glyphicon-step-backward mousehand " aria-hidden="true"></span></a></li>
            <li :class="{hide: currentpage === 1}"><a @click = "setpage(currentpage - 1)"><span class="glyphicon glyphicon-chevron-left mousehand " aria-hidden="true"></span></a></li>
            <li v-for="pagex in rango(tpage, currentpage)" :key="pagex" :class="{active: currentpage == pagex}" class="mousehand"><a @click = "setpage(pagex)"> {{pagex}}</a></li>
            <li :class="{hide: currentpage === tpage}"><a @click = "setpage(currentpage + 1)"><span class="glyphicon glyphicon-chevron-right mousehand" aria-hidden="true"></span></a></li>
            <li :class="{hide: currentpage === tpage}"><a @click = "setpage(tpage)"><span class="glyphicon glyphicon-step-forward mousehand" aria-hidden="true"></span></a></li>
        </ul>
    </div>
</template>

<script>
    import {rangoutil} from "../tools";

    export default {
        name: 'paginator',
        props: ['tpage', 'pager'],
        data () {
            return {
                pagex: '',
                currentpage: 1,
                recordpage: this.pager.recordpage,
                rango: rangoutil
            }
        },
        methods: {
            setpage (page) {
                this.currentpage = page;
                this.pager.page = page;
                this.$emit('getresult', undefined, undefined, this.pager)
            }
        },
        watch: {
            tpage: function () {
                this.currentpage = 1
            }
        }
    }
</script>

<style scoped>

</style>
