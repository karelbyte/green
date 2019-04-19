import {core} from './core';

import {dateEs, generateId} from './tools';

import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'

import { quillEditor } from 'vue-quill-editor'

import Multiselect from "vue-multiselect";

import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '2px'
});

new Vue({
    mixins: [core],
    el: '#app',
    data () {
        return {
            sendM: false,
            editorOption: {
                theme: 'snow'
            },
            views: {
                list: true,
                newfiles: false,
                newdetails: false,
            },
            item: {
                id: 0,
                moment: '',
                type_quote_id: '',
                status_id: '',
                descrip: '',
                specifications: '',
                type_send_id: 0,
                type_check_id: 0,
                feedback: '',
                notes: [],
                clientemit: 0
            },
            itemDefault: {
                id: 0,
                moment: '',
                descrip: '',
                specifications: '',
                type_quote_id: '',
                status_id: '',
                type_send_id: 0,
                type_check_id: 0,
                feedback: '',
                notes: [],
                clientemit: 0
            },
            repassword: '',
            listfield: [{name: 'Codigo', type: 'text', field: 'quotes.id'}],
            filters_list: {
                descrip: 'Codigo',
                field: 'quotes.id',
                value: ''
            },
            orders_list: {
                field: 'quotes.id',
                type: 'desc'
            },
            doc: {},
            note: '',
            detail: {
                id: 0,
                cant: 0,
                descrip: '',
                price: 0,
                total: () => {
                    return  this.cant * this.price
                }
            },
            detailDefault: {
                id: 0,
                cant: 0,
                descrip: '',
                price: 0,
                total: () => {
                  return  this.cant * this.price
                }
            },
            scrpdf: '',
            TypeShow: '',
            elements: [],
            confircode: 0,
            landscapers: []
        }
    },
    components: {
        Multiselect, quillEditor
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

        this.labeledit = 'Actualizar cliente';

        this.labelnew = 'Añadir cliente';

        this.patchDelete = 'api/clients/';

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

                url: urldomine + 'api/quotes/list',

                data: {

                    start: this.pager_list.page - 1,

                    take: this.pager_list.recordpage,

                    filters: this.filters_list,

                    orders: this.orders_list
                }

            }).then(res => {

                this.spin = false;

                this.lists = res.data.list;

                this.landscapers = res.data.landscapers;

                this.pager_list.totalpage = Math.ceil(res.data.total / this.pager_list.recordpage)

            }).catch(e => {

                this.spin = false;

                this.$toasted.error(e.response.data);
            })
        },
        getType (o) {
           return parseInt(o) === 2 ? 'A DISTANCIA' : 'VISITA A DOMICILIO'
        },

        // DEATALLES DE LA COTIZACION

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

               return a + parseFloat(b.price) * parseFloat(b.cant)

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

            return des && price && cant
        },
        saveDetails () {

            let data = {

              id : this.item.id,

              details : this.item.details,

              descrip: this.item.descrip,

              specifications: this.item.specifications,
            };

            axios.post(urldomine + 'api/quotes/details', data ).then(r => {

                this.onviews('list');

                this.getlist();

                this.$toasted.success(r.data)

            })
        },
        viewpdf (id) {

            this.spin = true;

            axios.get(urldomine + 'api/quotes/pdf/' + id).then(response => {

                this.spin = false;

                this.scrpdf = response.data;

                $('#pdf').modal('show')
            })
        },
        pass () {
            return this.item.details.length > 0 && this.item.descrip !== null && this.item.descrip !== '';
        },
        save () {

            this.spin = true;

            axios({

                method: this.act,

                url: urldomine + 'api/quotes' + (this.act === 'post' ? '' : '/' + this.item.id),

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
        // VERIFICACION DE INFO

        ShowCheckInfo (it) {

            this.item = {...it};

            $('#check').modal('show');
        },
        passCheckSend () {

            return this.item.type_check_id > 0 && this.confircode > 0;
        },

        sendCheckClient () {

            let data = {

                id :  this.item.id,

                code: this.confircode,

                type_check_id: this.item.type_check_id,

                feedback: this.item.feedback,

                clientemit: this.item.clientemit,

                emit: this.item.emit
            };

            axios.post(urldomine + 'api/quotes/checkinfo', data).then(r => {

                this.$toasted.success(r.data);

                this.getlist();

                this.spin = false;

                $('#check').modal('hide');

            }).catch(e => {

                this.spin = false;

                this.$toasted.error(e.response.data)
            })
        },

        // ENVIO DE INFO
        sendInfoClient () {

            this.sendM = true;

            axios.post(urldomine + 'api/quotes/sendinfo', this.item).then(r => {

                this.$toasted.success(r.data);

                this.sendM = false;

                this.getlist();

                $('#sendinfo').modal('hide');

                if (this.item.type_send_id === 1) {

                    document.getElementById('wass').click();

                }

            }).catch(e => {

                this.sendM = false;

                this.$toasted.error(e.response.data)
            })
        },
        passInfoSend () {

            return this.item.type_send_id > 0;
        },
        ShowSendInfo (itm) {

            this.item = itm;

            $('#sendinfo').modal('show')
        },

        // CODIGO DE TRABAJO CON FICHEROS DE LA VISITA

        passVisit () {

            let moment = this.item.globals.landscaper.moment !== '';

            let timer = this.item.globals.landscaper.timer !== '';

            return moment && timer;

        },
        saveInfoVisint () {

            this.spin = true;

            let data = {

                id: this.item.id,

                moment: this.item.globals.landscaper.moment,

                timer: this.item.globals.landscaper.timer,

                user:  this.item.globals.landscaper.user_uid,

                note:  this.item.globals.landscaper.note,

                status_id: this.item.globals.landscaper.status_id

            };

            axios.post(urldomine + 'api/quotes/saveinfo', data).then(r => {

                this.spin = false;

                this.onviews('list');

                this.getlist();

                this.$toasted.success(r.data)
            })
        },
        showFiles(itm) {

            this.item = {...itm};

            this.onviews('newfiles')
        },
        deleteFile(id) {

            this.spin = true;

            axios.get(urldomine + 'api/quotes/file/delete/' + id).then(r => {

                this.item.docs = this.item.docs.filter(it => it.id !== id);

                this.spin = false;
            })
        },
        deleteNote(id) {

            this.spin = true;

            axios.get(urldomine + 'api/quotes/note/delete/' + id).then(r => {

                this.item.notes = this.item.notes.filter(it => it.id !== id);

                this.spin = false;
            })
        },
        showVisor (doc) {

            this.doc = doc;

            $('#repro').modal('show');
        },
        showNote () {

            $('#note').modal('show');
        },
        saveNote () {

           this.spin = true;

           let data = {

               id:  this.item.id,

               note: this.note
           };

           this.item.notes.push({id: generateId(9), note: this.note});

            axios.post(urldomine + 'api/quotes/note/save', data).then(res => {

                axios.get(urldomine + 'api/quotes/notes/' + this.item.id).then(r => {

                    this.spin = false;

                    this.item.notes = r.data.notes
                })
            })
        },
        saveFile(e) {

            this.spin = true;

            let data = new FormData();

            this.picture = e.target.files || e.dataTransfer.files;

            this.$Progress.start();

            if (this.picture.length) {

                data.append('id', this.item.id);

                data.append('file',this.picture[0]);

                axios.post(urldomine + 'api/quotes/file/save', data, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(res => {

                  axios.get(urldomine + 'api/quotes/files/' + this.item.id).then(r => {

                      this.spin = false;

                      this.item.docs = r.data.docs;

                      this.$Progress.finish()

                  }).catch(e => {

                      this.spin = false;

                      this.$Progress.finish();

                      this.$toasted.error(e.response.data)
                  })

                }).catch(e => {

                    this.spin = false;

                    this.$Progress.finish();

                    this.$toasted.error(e.response.data)
                })
            }
        },
        showCamera() {

          $('#file').click()
        }
    }
});
