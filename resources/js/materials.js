import {core} from './core';
import Multiselect from 'vue-multiselect'

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
                code: '',
                name: '',
                price: 0,
                type: 1,
                measure_id: '',
                wholesale_cant: 0,
                wholesale_price: 0
            },
            itemDefault: {
                id: 0,
                code: '',
                price: 0,
                name: '',
                type: 1,
                measure_id: '',
                wholesale_cant: 0,
                wholesale_price: 0
            },
            listfield: [{name: 'Codigo', type: 'text', field: 'elements.code'}, {name: 'Nombre', type: 'text', field: 'elements.name'}],
            filters_list: {
                descrip: 'Codigo',
                field: 'elements.code',
                value: ''
            },
            orders_list: {
                field: 'elements.code',
                type: 'asc'
            },
            value: '',
            measures: []
        }
    },
    components: {
        Multiselect
    },
    mounted () {

        this.propertyShowDelObj = 'name';

        this.labeledit = 'Actualizar producto';

        this.labelnew = 'Añadir producto';

        this.patchDelete = 'api/materials/';

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

                url: urldomine + 'api/materials/list',

                data: {

                    start: this.pager_list.page - 1,

                    take: this.pager_list.recordpage,

                    filters: this.filters_list,

                    orders: this.orders_list
                }

            }).then(res => {

                this.spin = false;

                this.lists = res.data.list;

                this.measures = res.data.measures;

                this.pager_list.totalpage = Math.ceil(res.data.total / this.pager_list.recordpage)

            }).catch(e => {

                this.spin = false;

                this.$toasted.error(e.response.data)
            })
        },
        save () {

            this.spin = true;

            this.item.measure_id = this.value.id;

            axios({

                method: this.act,

                url: urldomine + 'api/materials' + (this.act === 'post' ? '' : '/' + this.item.id),

                data: this.item

            }).then(response => {

                this.spin = false;

                this.$toasted.success(response.data);

                this.getlist();

                this.onviews('list');

            }).catch(e => {

                this.spin = false;

                this.$toasted.error(e.response.data);
            })

        },
        edit (it) {

            this.item = {...it};

            this.act = 'put';

            this.title = this.labeledit;

            this.value = this.measures.find(it => {return it.id = this.item.measure_id});

            this.onviews('new')

        },
        pass () {

            let code = this.item.code !== '';

            let name = this.item.name !== '';

            let um = this.value !== '';

            let price = this.item.price > 0;

            return name && code && um && price
        }
    }
});
