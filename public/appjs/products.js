Vue.config.devtools = true;

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
                init: 1,
                end: '',
            },
            itemDefault: {
                id: 0,
                name: '',
                init: 1,
                end: ''
            },
            repassword: '',
            listfield: [{name: 'Codigo', type: 'text', field: 'products.name'},],
            filters_list: {
                descrip: 'Descripción',
                field: 'products.name',
                value: ''
            },
            orders_list: {
                field: 'products.name',
                type: 'asc'
            },
        }
    },
    mounted () {

        this.propertyShowDelObj = 'name';

        this.labeledit = 'Actualizar producto';

        this.labelnew = 'Añadir producto';

        this.patchDelete = 'api/products/';

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

                url: urldomine + 'api/products/list',

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

                toastr["error"](e.response.data);
            })
        },
        save () {

            this.spin = true;

            axios({

                method: this.act,

                url: urldomine + 'api/products' + (this.act === 'post' ? '' : '/' + this.item.id),

                data: this.item

            }).then(response => {

                this.spin = false;

                toastr["success"](response.data);

                this.getlist();

                this.onview('list');

            }).catch(e => {

                this.spin = false;

                toastr["error"](e.response.data);
            })

        },
        edit (it) {

            this.item = {...it};

            this.act = 'put';

            this.title = this.labeledit;

            this.onview('new')

        },
        pass () {

            let name = this.item.code !== '';

            let init = this.item.init !== '' && this.item.init > 0;

            let end = this.item.end !== '' && this.item.end > 0;

            return name && init && end
        }
    }
});
