import {dateEs, generateId} from './tools';
import * as moment from 'moment';
import Multiselect from "vue-multiselect";

new Vue({
    el: '#app',
    data () {
        return {
            user_id_auth: 0,
            delobj: '',
            keyObjDelete: '',
            propertyShowDelObj: '',
            patchDelete: '',
            title: '',
            labeledit: '',
            labelnew: '',
            lists: [],
            spin: false,
            act: 'post',
            fieldtype: 'text',
            pager_list: {
                page: 1,
                recordpage: 10,
                totalpage: 0
            },
            views: {
                list: true,
                newdetails: false,
            },
            item: {
                id: 0,
                moment: '',
                advance: 0,
                status_id: '',
                paimentdate: '',
                deliberydate: '',
                emailto: '',
                generate_pdf: false,
                details: []
            },
            itemDefault: {
                id: 0,
                moment: '',
                advance: '',
                status_id: '',
                paimentdate: moment().format('YYYY-MM-DD'),
                deliverydate: moment().format('YYYY-MM-DD'),
                emailto: '',
                generate_pdf: false,
                details: []
            },
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
                start: '',
                measure_id: 0,
                measure: {},
                timer: ''
            },
            detailDefault: {
                id: 0,
                sales_id: 0,
                type_item: 0,
                item: '',
                item_id: 0,
                cant: 0,
                descrip: '',
                price: 0,
                start: '',
                measure_id: 0,
                measure: {},
                timer: ''
            },
            scrpdf: 0,
            find: 0,
            users: [],
            elements: [],
            mat: {},
            TypeShow: 'Detalle a añadir',
            elementsAplicClient: [],
            isNotFull: false,
            editItem: false
        }
    },
    components: {
        Multiselect
    },
    directives: {
        focus: {
            inserted: function (el) {
                el.focus()
            }
        },
        numericonly: {
            bind(el) {
                el.addEventListener('keydown', (e) => {
                    if ([46, 8, 9, 27, 13, 110, 190].indexOf(e.keyCode) !== -1 ||
                        // Allow: Ctrl+A
                        (e.keyCode === 65 && e.ctrlKey === true) ||
                        // Allow: Ctrl+C
                        (e.keyCode === 67 && e.ctrlKey === true) ||
                        // Allow: Ctrl+X
                        (e.keyCode === 88 && e.ctrlKey === true) ||
                        // Allow: home, end, left, right
                        (e.keyCode >= 35 && e.keyCode <= 39)) {
                        // let it happen, don't do anything
                        return
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault()
                    }
                })
            }
        }
    },
    watch: {
        'filters_list.value': function () {
            this.getlist()
        },
        'detail.type_item': function () {
            if (!this.editItem) {

                this.getDatas();

                this.detail.descrip = '';

                this.detail.price = '';

                this.detail.cant = '';
            }

        }
    },
    mounted () {

        this.propertyShowDelObj = 'name';

        this.labeledit = 'Actualizar Nota de Venta';

        this.labelnew = 'Añadir Nota de Venta';

        this.patchDelete = 'api/sales/';

        this.keyObjDelete = 'id';

        this.find = parseInt($('#find').val());

        this.user_id_auth = parseInt($('#user_id_auth').val());

        if (this.find > 0) {

            this.filters_list.value = this.find;

        } else {

            this.getlist()
        }

    },
    methods: {
        dateToEs : dateEs,
        getDatas () {
            if (this.detail.type_item === 1) {

                this.TypeShow = 'Inventario';

                this.detail.item = '';

                axios.get(urldomine + 'api/materials/products').then(res => {

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
        },
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

                    orders: this.orders_list,

                    user_id_auth : this.user_id_auth
                }

            }).then(res => {

                this.spin = false;

                this.lists = res.data.list;

                if (this.find > 0 && this.item.details.length === 0) {

                    this.item = {...res.data.list[0]};

                    this.onviews('newdetails')

                }

                this.users = res.data.users;

                this.pager_list.totalpage = Math.ceil(res.data.total / this.pager_list.recordpage)

            }).catch(e => {
                this.spin = false;
                this.$toasted.error(e.response.data);
            })
        },

        // APLICAR NOTA DE VENTA

        confirmNote () {
            this.spin = true;
            let data = {
                id : this.item.id,
                paimentdate: this.item.paimentdate,
                deliverydate: this.item.deliverydate,
                emailto: this.item.emailto,
                generate_pdf: this.item.generate_pdf,
            };
            axios.post(urldomine + 'api/sales/confirm', data).then(r => {
                $('#aplicCLientNote').modal('hide');
                this.getlist();
                this.spin = false;
                if (this.item.generate_pdf) {
                    this.scrpdf = r.data;
                    $('#pdf').modal('show')
                } else {
                    this.$toasted.success(r.data);
                }

            })
        },
        // ENTREGAR PRODUCTO O SERVICIO
        noteDeliverClient (id) {
            axios.get(urldomine + 'api/sales/notedeliverclient/' + id ).then(r => {
               this.$toasted.success(r.data);
               this.getlist();
            }).catch(e => {
                this.$toasted.info(e.response.data);
            })
        },

        showAplic (item) {
            let founInventoriItem = item.details.find (it => {
                return it.type_item === 1
            });
            this.item = item;
            this.item.paimentdate = moment().format('YYYY-MM-DD');
            this.item.deliverydate = moment().format('YYYY-MM-DD');
            axios.get(urldomine + 'api/sales/aplic/' + item.id ).then(r => {
              this.elementsAplicClient = r.data
              let NotFull = this.elementsAplicClient.find(it => {
                  return it.missing > 0
              });
              this.isNotFull = founInventoriItem !== undefined && NotFull !== undefined;
              $('#aplicCLientNote').modal('show');
            })
        },

        // DEATALLES DE LA NOTA DE VENTA

        setMant() {
            this.item.details = this.item.details.filter(it => {
             return it.id !== this.mat.id
            });
            this.item.details.push(this.mat);
            $('#calendar').modal('hide')
        },
        showCalendar (det) {

          this.mat = {...det};

          $('#calendar').modal('show')

        },
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
        showFormDetEdit(it) {

            let response = res => {
                this.elements = res.data;
                this.detail.item = this.elements.find(it => {
                    return it.id === this.detail.item_id
                });
                $('#new_det').modal('show')
            };

            this.editItem = true;

            this.detail = {...it};

            if (this.detail.type_item === 1) {

                this.TypeShow = 'Inventario';

                this.detail.item = '';

                axios.get(urldomine + 'api/materials/products').then(response)

            }
            if (this.detail.type_item === 2) {

                this.TypeShow = 'Producto';

                this.detail.item = '';

                axios.get(urldomine + 'api/productsoffereds/products').then(response)

            }
            if (this.detail.type_item === 3){

                this.TypeShow = 'Servicio';

                this.detail.item = '';

                axios.get(urldomine + 'api/servicesoffereds/services').then(response)
            }


        },
        deleteDet (id) {

          this.item.details = this.item.details.filter(it => it.id !== id)

        },
        saveNewDet() {

          if (this.detail.id !== 0) {
              this.item.details = this.item.details.filter(it => {
                return  it.id !== this.detail.id
              });

              this.detail.measure_id = this.detail.item.measure_id;

              this.detail.measure = this.detail.item.measure;

              this.item.details.push({...this.detail});

          } else {
              this.detail.id = generateId(9);

              this.detail.measure_id = this.detail.item.measure_id;

              this.detail.measure = this.detail.item.measure;

              this.item.details.push({...this.detail});
          }

          this.editItem = false;
          $('#new_det').modal('hide')

        },
        passNewDet () {

            let des = this.detail.descrip !== '';

            let price = this.detail.price > 0;

            let cant = this.detail.cant > 0;

            // let product  =  this.detail.cant <= this.detail.item.cant;

            return des && price && cant //&& product
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

                if (this.find > 0) {

                    this.filters_list.value = '';

                }

                this.onviews('list');

            }).catch(e => {

                this.spin = false;

                this.$toasted.error(e.response.data)
            })

        },
        setfield (f){

            this.filters_list.value = '';

            this.filters_list.descrip = f.name;

            this.filters_list.field = f.field;

            if (f.type === 'select') this.filters_list.options = f.options;

            this.fieldtype = f.type

        },
        add () {
            this.item = JSON.parse( JSON.stringify( this.itemDefault ));

            this.act = 'post';

            this.title = this.labelnew;

            this.onviews('new')

        },
        delitem () {

            this.spin = true;

            axios({

                method: 'delete',

                url: urldomine + this.patchDelete +  this.item[this.keyObjDelete]

            }).then(r => {

                this.spin = false;

                $('#modaldelete').modal('hide');

                this.$toasted.success(r.data);

                this.getlist();

            }).catch(e => {

                this.spin = false;

                this.$toasted.error(e.response.data)

            })

        },
        showdelete(it) {

            this.item = {...it};

            this.delobj = it[this.propertyShowDelObj];

            $('#modaldelete').modal('show')

        },
        close () {

            this.getlist();

            this.onviews('list');
        },
        onviews (pro){

            for (let property in this.views) {

                this.views[property] = property === pro
            }
        }
    }
});
