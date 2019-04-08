
import {core} from './core'

new Vue({
    mixins: [core],
    el: '#app',
    data () {
        return {
            views: {
                list: true,
                new: false,
            },
            item: {
                id: 0,
                name: '',
            },
            itemDefault: {
                id: 0,
                name: '',
            },
            repassword: '',
            listfield: [{name: 'Nombre', type: 'text', field: 'measures.name'}],
            filters_list: {
                descrip: 'Nombre',
                field: 'measures.name',
                value: ''
            },
            orders_list: {
                field: 'measures.name',
                type: 'asc'
            },
            roles: [],
            value: ''
        }
    },
    mounted () {

        this.propertyShowDelObj = 'name';

        this.labeledit = 'Actualizar medida';

        this.labelnew = 'Añadir medida';

        this.patchDelete = 'api/measures/';

        this.keyObjDelete = 'id'

    },
    methods: {
        getlist (pFil, pOrder, pPager) {
            if (pFil !== undefined) { this.filters = pFil }

            if (pOrder !== undefined) { this.orders = pOrder }

            if (pPager !== undefined) { this.pager = pPager }

            this.spin = true;

            axios({
                method: 'post',

                url: urldomine + 'api/measures/list',

                data: {

                    start: this.pager_list.page - 1,

                    take: this.pager_list.recordpage,

                    filters: this.filters_list,

                    orders: this.orders_list
                }

            }).then(res => {

                this.spin = false;

                this.lists = res.data.list;

                this.pager_list.totalpage = Math.ceil(res.data.total / this.pager_list.recordpage)

            }).catch(e => {

                this.spin = false;

                this.$toasted.error(e.response.data)
            })
        },
        save () {

            this.spin = true;

            let data = {

                'measures': this.item.name,
            };

            axios({

                method: this.act,

                url: urldomine + 'api/measures' + (this.act === 'post' ? '' : '/' + this.item.id),

                data: data

            }).then(response => {

                this.spin = false;

                this.$toasted.success(response.data);

                this.getlist();

                this.onviews('list');

            }).catch(e => {

                this.spin = false;

                this.$toasted.error(e.response.data)
            })

        },
        pass () {
            return this.item.name !== '';
        }
    }
});
