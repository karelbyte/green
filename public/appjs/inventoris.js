Vue.config.devtools = true;

new Vue({
    mixins: [core],
    el: '#app',
    data () {
        return {
            types: [{id: 1,  name: 'MATERIALES'}, {id: 2,  name: 'HERRAMIENTAS'}],
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
            },
            repassword: '',
            listfield: [{name: 'Codigo', type: 'text', field: 'elements.code'}, {name: 'Descripción', type: 'text', field: 'elements.name'}],
            filters_list: {
                descrip: 'Codigo',
                field: 'elements.code',
                value: '',
                type: {id: 1,  name: 'MATERIALES'}
            },
            orders_list: {
                field: 'elements.code',
                type: 'asc'
            },
            roles: [],
        }
    },
    watch: {
      'filters_list.type.id': 'getlist'
    },
    components: {
        Multiselect: window.VueMultiselect.default
    },
    mounted () {

        this.propertyShowDelObj = 'name';

        this.labeledit = 'Actualizar material';

        this.labelnew = 'Añadir material';

        this.patchDelete = 'api/inventoris/';

        this.keyObjDelete = 'id';


    },
    methods: {
        getlist (pFil, pOrder, pPager) {

            this.pager_list.recordpage = 20;

            if (pFil !== undefined) { this.filters = pFil }

            if (pOrder !== undefined) { this.orders = pOrder }

            if (pPager !== undefined) { this.pager = pPager }

            this.spin = true;

            axios({
                method: 'post',

                url: urldomine + 'api/inventoris/list',

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

                toastr["error"](e.response.data);
            })
        },
        pass () {

            let code = this.item.code !== '';

            let name = this.item.name !== '';

            let um = this.value !== '';

            let price = this.item.price > 0;

            return name && code && um
        }
    }
});
