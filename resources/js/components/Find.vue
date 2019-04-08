<template>
    <div>
        <input type="text" class="form-control input-sm" :placeholder="holder" v-model="find" @keyup="updates()">
    </div>
</template>

<script>
    export default {
        name: 'find',
        props: ['filters', 'filter', 'holder'],
        data () {
            return {
                find: this.filters[this.filter]
            }
        },
        methods: {
            updates () {
                this.filters[this.filter] = this.find;
                this.$emit('getfilter', this.filters, undefined, undefined)
            }
        }
    }
</script>

<style scoped>

</style>


