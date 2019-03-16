Vue.component('find', {
    props: ['filters', 'filter', 'holder'],
    template:
        `<input type="text" class="form-control input-sm" :placeholder="holder" v-model="find" @keyup="updates()">`,
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
});
