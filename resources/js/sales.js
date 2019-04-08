import {core} from './core';

import {dateEs, generateId} from './tools';

import Multiselect from "vue-multiselect";

new Vue({
    mixins: [core],
    el: '#app',
    data () {
        return {
            views: {
                list: true,
                newdetails: false,
            },
            item: {
                id: 0,
                moment: '',
                status_id: '',
                advance: 0
            },
            itemDefault: {
                id: 0,
                moment: '',
                advance: '',
                status_id: '',
            },
            repassword: '',
            listfield: [{name: 'Codigo', type: 'text', field: 'salesnotes.id'}],
            filters_list: {
                descrip: 'Codigo',
                field: 'salesnotes.id',
                value: ''
            },
            orders_list: {
                field: 'salesnotes.id',
                type: 'desc'
            },
            doc: {},
            note: '',
            detail: {
                id: 0,
                sales_id: 0,
                type_item: 0,
                item: '',
                item_id: 0,
                cant: 0,
                descrip: '',
                price: 0,
            },
            detailDefault: {
                id: 0,
                sales_id: 0,
                type_item: 0,
                item: '',
                item_id: 0,
                cant: 0,
                descrip: '',
                price: 0
            },
            scrpdf: 0,
            find: 0,
            elements: [],
            TypeShow: 'Detalle a añadir'
        }
    },
    components: {
        Multiselect
    },
    watch: {
        'detail.type_item': function () {

            if (this.detail.type_item === 1) {

                this.TypeShow = 'Inventario';

                this.detail.item = '';

                axios.get(urldomine + 'api/inventoris/products').then(res => {

                   this.elements = res.data
                })

            }
            if (this.detail.type_item === 2) {

                this.TypeShow = 'Producto';

                this.detail.item = '';

                axios.get(urldomine + 'api/productsoffereds/products').then(res => {

                    this.elements = res.data
                })

            }
            if (this.detail.type_item === 3){

                this.TypeShow = 'Servicio';

                this.detail.item = '';

                axios.get(urldomine + 'api/servicesoffereds/services').then(res => {

                    this.elements = res.data
                })

            }

            this.detail.descrip = '';

            this.detail.price = '';

            this.detail.cant = '';
        }
    },
    mounted () {

        this.propertyShowDelObj = 'name';

        this.labeledit = 'Actualizar Nota de Venta';

        this.labelnew = 'Añadir Nota de Venta';

        this.patchDelete = 'api/sales/';

        this.keyObjDelete = 'id';

        this.find = parseInt($('#find').val());

        if (this.find > 0) {

            this.filters_list.value = this.find
        }

    },
    methods: {
        dateToEs : dateEs,

        getlist (pFil, pOrder, pPager) {

            if (pFil !== undefined) { this.filters = pFil }

            if (pOrder !== undefined) { this.orders = pOrder }

            if (pPager !== undefined) { this.pager = pPager }

            this.spin = true;

            axios({
                method: 'post',

                url: urldomine + 'api/sales/list',

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

                this.$toasted.error(e.response.data);
            })
        },

        // DEATALLES DE LA NOTA DE VENTA
        updateSelected () {

            if (this.detail.item !== '' && this.detail.item !== null) {

                this.detail.descrip = this.detail.item.name;

                this.detail.price = this.detail.item.price;

                this.detail.item_id = this.detail.item.id;

                this.detail.cant = 1;

            } else {

                this.detail.descrip = '';

                this.detail.price = '';

                this.detail.cant = '';
            }

        },
        getTotalItem (it) {

            return  it.reduce( (a, b) => {

                return a + parseFloat(b.price) * parseFloat(b.cant)

            }, 0).toFixed(2)

        },
        getTotal () {

          return  this.item.details.reduce( (a, b) => {

               return a +  parseFloat(b.price) * parseFloat(b.cant)

          }, 0).toFixed(2)

        },
        edit (it) {

            this.item = {...it};

            this.onviews('newdetails')

        },
        showFormDet() {

          this.detail = {...this.detailDefault};

          $('#new_det').modal('show')

        },
        deleteDet (id) {

          this.item.details = this.item.details.filter(it => it.id !== id)

        },
        saveNewDet() {

          this.detail.id = generateId(9);

          this.item.details.push({...this.detail});

          $('#new_det').modal('hide')

        },
        passNewDet () {

            let des = this.detail.descrip !== '';

            let price = this.detail.price > 0;

            let cant = this.detail.cant > 0;

            let product  =  this.detail.cant <= this.detail.item.cant;

            return des && price && cant && product
        },
        saveDetails () {

            let data = {

              id : this.item.id,

              details : this.item.details,

              advance : this.item.advance,

            };

            axios.post(urldomine + 'api/sales/details', data ).then(r => {

                this.onviews('list');

                this.getlist();

                this.$toasted.success(r.data)

            })
        },
        viewpdf (id) {

            this.spin = true;

            axios.get(urldomine + 'api/sales/pdf/' + id).then(response => {

                this.spin = false;

                this.scrpdf = response.data;

                $('#pdf').modal('show')
            })
        },
        pass () {

            return this.item.details.length > 0 && this.item.descrip !== null && this.item.descrip !== ''
        },
        save () {

            this.spin = true;

            axios({

                method: this.act,

                url: urldomine + 'api/sales' + (this.act === 'post' ? '' : '/' + this.item.id),

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

        }
    }
});
