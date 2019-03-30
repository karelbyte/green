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
                price: '',
                measure: ''
            },
            itemDefault: {
                id: 0,
                name: '',
                init: 1,
                end: '',
                price: '',
                measure: ''
            },
            repassword: '',
            listfield: [{name: 'Codigo', type: 'text', field: 'services.name'},],
            filters_list: {
                descrip: 'Descripción',
                field: 'services.name',
                value: ''
            },
            orders_list: {
                field: 'services.name',
                type: 'asc'
            },
            measures: []
        }
    },
    components: {
        Multiselect: window.VueMultiselect.default
    },
    mounted () {

        this.propertyShowDelObj = 'name';

        this.labeledit = 'Actualizar servicio';

        this.labelnew = 'Añadir servicio';

        this.patchDelete = 'api/services/';

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

                url: urldomine + 'api/services/list',

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
        save () {

            this.item.measure_id = this.item.measure.id;

            this.spin = true;

            axios({

                method: this.act,

                url: urldomine + 'api/services' + (this.act === 'post' ? '' : '/' + this.item.id),

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
        add () {
            this.item = {...this.itemDefault};

            this.act = 'post';

            this.title = this.labelnew;

            this.onview('new');

            this.value = this.item.measure;

        },
        pass () {

            let name = this.item.code !== '';

            let init = this.item.init !== '' && this.item.init > 0;

            let end = this.item.end !== '' && this.item.end > 0;

            let price = this.item.price !== '' && this.item.price > 0;

            return name && init && end && price
        }
    }
});
