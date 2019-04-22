
import {core} from './core'
import Multiselect from 'vue-multiselect'
import {dateEs} from './tools'

new Vue({
    mixins: [core],
    el: '#app',
    data () {
        return {
            types: [{id: 1,  name: 'PRODUCTOS'}, {id: 2,  name: 'HERRAMIENTAS'}],
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
                user_id: parseInt($('#user_id_auth').val())
            },
            itemDefault: {
                id: 0,
                code: '',
                type: '',
                moment: '',
                note: '',
                user_id: parseInt($('#user_id_auth').val())
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
            value: '',
            scrpdf: ''
        }
    },
    components: {
        Multiselect
    },
    watch: {
        'type.id' : 'getItemsForAdd'
    },
    mounted () {

        this.propertyShowDelObj = 'code';

        this.labeledit = 'Actualizar recepción';

        this.labelnew = 'Añadir recepción';

        this.patchDelete = 'api/receptions/';

        this.keyObjDelete = 'id'

    },
    methods: {
        dateToEs : dateEs,
        aplic () {

            this.spin = true;

            axios.post( urldomine + 'api/receptions/aplic', {id: this.item.id}).then( r => {

                $('#aplicar').modal('hide');

                this.spin = false;

                this.$toasted.success(r.data);

                this.getlist()
            })
        },
        showaplic (it) {

            this.item = it;

            $('#aplicar').modal('show');
        },
        backclass(i) {

            return i === 1 ? 'noaplic' : 'aplic'
        },
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

                this.pager_list.totalpage = Math.ceil(res.data.total / this.pager_list.recordpage)

            }).catch(e => {

                this.spin = false;

                this.$toasted.error(e.response.data)
            })
        },
        save () {

           this.spin = true;

           this.item.type = this.type.id;

           delete this.item.user;

           delete this.item.details;

           delete this.item.status;

           let data = {

               'reception' : this.item,

               'details':  this.details.map(it => {

                   return {
                       'item_id': it.element.id,

                       'cant': it.cant,

                       'type': this.item.type
                   }
               })
           };

            axios({

                method: this.act,

                url: urldomine + 'api/receptions' + (this.act === 'post' ? '' : '/' + this.item.id),

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
        add () {
            this.item = {...this.itemDefault};

            this.act = 'post';

            this.title = this.labelnew;

            this.type = '';

            this.details = [];

            this.onviews('new')

        },
        edit (it) {

            this.item = {...it};

            this.act = 'put';

            this.type = this.item.type;

            this.title = this.labeledit;

            this.details = this.item.details.map(it => {
                return {
                    cant: it.cant,
                    element: {
                        id: it.item_id,
                       code: it.element.code,
                       name: it.element.name
                    }
                }
            });

            this.onviews('new')

        },
        pass () {

            let code = this.item.code !== '';

            let moment = this.item.moment !== '';

            let det = this.details.length > 0;

            return moment && code && det
        },
        viewpdf (id) {

            this.spin = true;

            axios.get(urldomine + 'api/receptions/pdf/' + id).then(response => {

                this.spin = false;

                this.scrpdf = response.data;

                window.$('#pdf').modal('show')

            })
        }
    }
});
