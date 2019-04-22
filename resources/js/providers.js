import {core} from './core';

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
                code: '',
                contact: '',
                email: '',
                movil: '',
                phone: '',
                address: ''
            },
            itemDefault: {
                id: 0,
                name: '',
                code: '',
                contact: '',
                email: '',
                movil: '',
                phone: '',
                address: ''
            },
            listfield: [{name: 'Nombre', type: 'text', field: 'providers.name'}, {name: 'Codigo', type: 'text', field: 'providers.code'}],
            filters_list: {
                descrip: 'Nombre',
                field: 'providers.name',
                value: ''
            },
            orders_list: {
                field: 'providers.name',
                type: 'asc'
            },
        }
    },
    mounted () {

        this.propertyShowDelObj = 'name';

        this.labeledit = 'Actualizar proveedor';

        this.labelnew = 'Añadir proveedor';

        this.patchDelete = 'api/providers/';

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

                url: urldomine + 'api/providers/list',

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

            axios({

                method: this.act,

                url: urldomine + 'api/providers' + (this.act === 'post' ? '' : '/' + this.item.id),

                data: this.item

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

            let name = this.item.name !== '';

            let contact = this.item.contact !== '';

            let code = this.item.code !== '' ;

            let email = /^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,})$/i.test(this.item.email);

            return name && contact && code && email
        }
    }
});
