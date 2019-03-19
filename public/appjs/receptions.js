Vue.config.devtools = true;

new Vue({
    mixins: [core],
    el: '#app',
    data () {
        return {
            types: [{id: 1,  name: 'MATERIALES'}, {id: 2,  name: 'HERRAMIENTAS'}],
            elements: [],
            type: '',
            views: {
                list: true,
                new: false,
            },
            item: {
                id: 0,
                code: '',
                type: '',
                moment: '',
                note: '',
                status: '',
            },
            itemDefault: {
                id: 0,
                code: '',
                type: '',
                moment: '',
                note: '',
                status: '',
            },
            details: [],
            ItemForAdd: {
                element: '',
                cant: ''
            },
            ItemForAddDef: {
                element: '',
                cant: ''
            },
            repassword: '',
            listfield: [{name: 'Codigo', type: 'text', field: 'receptions.code'}, {name: 'Fecha', type: 'date', field: 'receptions.moment'}],
            filters_list: {
                descrip: 'Codigo',
                field: 'receptions.moment',
                value: ''
            },
            orders_list: {
                field: 'receptions.moment',
                type: 'desc'
            },
            roles: [],
            value: ''
        }
    },
    components: {
        Multiselect: window.VueMultiselect.default
    },
    watch: {
        'type.id' : 'getItemsForAdd'
    },
    mounted () {

        this.propertyShowDelObj = 'name';

        this.labeledit = 'Actualizar recepción';

        this.labelnew = 'Añadir recepción';

        this.patchDelete = 'api/receptions/';

        this.keyObjDelete = 'id'

    },
    methods: {
        addItem() {

          this.details.push({...this.ItemForAdd});

          $('#newline').modal('hide');

          this.ItemForAdd = {...this.ItemForAddDef}

        },
        getItemsForAdd () {

            if (this.type.id === 1) {

                axios.get( urldomine + 'api/materials/get').then(r => {

                   this.elements = r.data
                })
            } else {

                axios.get( urldomine + 'api/tools/get').then(r => {

                    this.elements = r.data
                })
            }
        },
        deleteItem (code) {

           this.details = this.details.filter(it => it.element.code !== code)

        },
        passItemForAdd () {
            return this.ItemForAdd.cant > 0 && this.ItemForAdd.element !== ''
        },
        showAddLine() {
            $('#newline').modal('show')
        },
        getlist (pFil, pOrder, pPager) {
            if (pFil !== undefined) { this.filters = pFil }

            if (pOrder !== undefined) { this.orders = pOrder }

            if (pPager !== undefined) { this.pager = pPager }

            this.spin = true;

            axios({
                method: 'post',

                url: urldomine + 'api/receptions/list',

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

           this.item.measure_id = this.value.id;

            axios({

                method: this.act,

                url: urldomine + 'api/receptions' + (this.act === 'post' ? '' : '/' + this.item.id),

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

            this.type = '';

            this.onview('new')

        },
        edit (it) {

            this.item = {...it};

            this.act = 'put';

            this.title = this.labeledit;

            this.onview('new')

        },
        pass () {

            let code = this.item.code !== '';

            let moment = this.item.moment !== '';

            let det = this.details.length > 0;

            return moment && code && det
        }
    }
});
