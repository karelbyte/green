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
                code: '',
                name: '',
            },
            itemDefault: {
                id: 0,
                code: '',
                name: '',
            },
            repassword: '',
            listfield: [{name: 'Codigo', type: 'text', field: 'tools.code'}, {name: 'Nombre', type: 'text', field: 'tools.name'}],
            filters_list: {
                descrip: 'Codigo',
                field: 'tools.code',
                value: ''
            },
            orders_list: {
                field: 'tools.code',
                type: 'asc'
            },
        }
    },
    mounted () {

        this.propertyShowDelObj = 'name';

        this.labeledit = 'Actualizar herramienta';

        this.labelnew = 'Añadir herramienta';

        this.patchDelete = 'api/tools/';

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

                url: urldomine + 'api/tools/list',

                data: {

                    start: this.pager_list.page - 1,

                    take: this.pager_list.recordpage,

                    filters: this.filters_list,

                    orders: this.orders_list
                }

            }).then(res => {

                this.spin = false;

                this.lists = res.data.list;

                this.pager_list.totalpage = Math.ceil(res.data.total / this.pager.recordpage)

            }).catch(e => {

                this.spin = false;

                toastr["error"](e.response.data);
            })
        },
        save () {

            this.spin = true;

            axios({

                method: this.act,

                url: urldomine + 'api/tools' + (this.act === 'post' ? '' : '/' + this.item.id),

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

            let code = this.item.code !== '';

            let name = this.item.name !== '';

            return name && code
        }
    }
});
