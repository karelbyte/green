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

const CLIENTE_ACEPT_QUOTE = 1;

new Vue({
    el: '#app',
    data () {
        return {
            user_id_auth: 0,
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
                clientemit: 0,
                have_iva: false
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
                clientemit: 0,
                have_iva: false
            },
            listfield: [{name: 'Codigo', type: 'text', field: 'quotes.id'}, {name: 'Cliente', type: 'text', field: 'clients.name'}],
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
                measure_id: 0,
                measure: {},
                total: () => {
                    return  this.cant * this.price
                }
            },
            detailDefault: {
                id: 0,
                cant: 0,
                descrip: '',
                price: 0,
                measure_id: 0,
                measure: {},
                total: () => {
                  return  this.cant * this.price
                }
            },
            scrpdf: '',
            TypeShow: '',
            elements: [],
            confircode: 0,
            landscapers: [],
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
            redirect: {
                patch: '',
                message: ''
            },
            editItem: false
        }
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
    components: {
        Multiselect, quillEditor
    },
    watch: {
        'detail.type_item': function () {
            if (!this.editItem) {
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

                this.detail.descrip = '';

                this.detail.price = '';

                this.detail.cant = '';
            }
        },
        'filters_list.value': function () {
            this.getlist()
        }
    },
    mounted () {

        this.propertyShowDelObj = 'name';

        this.labeledit = 'Actualizar cliente';

        this.labelnew = 'Añadir cliente';

        this.patchDelete = 'api/clients/';

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

                    orders: this.orders_list,

                    user_id_auth : this.user_id_auth
                }

            }).then(res => {

                this.spin = false;

                this.lists = res.data.list;

                this.landscapers = res.data.landscapers;

                this.item = {...res.data.list[0]};

                if (this.find > 0 && this.item.details.length === 0) {

                    this.item = {...res.data.list[0]};

                    this.onviews('newdetails')

                }

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
            let subtotal = 0;
            if (it.details) {
                subtotal = it.details.reduce( (a, b) => {
                    return a + parseFloat(b.price) * parseFloat(b.cant)
                }, 0);
                if (it.have_iva === 1 || it.have_iva === true) {
                    subtotal = (subtotal + (subtotal * .16)).toFixed(2)
                }
            }
            return subtotal;
        },
        getTotal () {
         let iva = 0;
         let subtotal = 0;
         subtotal = this.item.details.reduce( (a, b) => {
               return a + parseFloat(b.price) * parseFloat(b.cant)
          }, 0);
           if (this.item.have_iva === 1 ||  this.item.have_iva === true) {
                iva = this.item.details.reduce( (a, b) => {
                    return a + parseFloat(b.price) * parseFloat(b.cant)
                }, 0) * 0.16;
               subtotal = (subtotal + iva).toFixed(2)
            }
           return subtotal;
        },
        getIva () {
            return  (this.item.details.reduce( (a, b) => {
                return a + parseFloat(b.price) * parseFloat(b.cant)
            }, 0) * 0.16).toFixed(2)
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

                axios.get(urldomine + 'api/materials/products').then(response)

            }
            if (this.detail.type_item === 2) {

                this.TypeShow = 'Producto';

                axios.get(urldomine + 'api/productsoffereds/products').then(response)

            }
            if (this.detail.type_item === 3){

                this.TypeShow = 'Servicio';

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

            return des && price && cant
        },
        saveDetails () {

            let data = {

              id : this.item.id,

              details : this.item.details,

              have_iva : this.item.have_iva,

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

                $('#check').modal('hide');

                if (this.item.clientemit === CLIENTE_ACEPT_QUOTE) {

                    this.redirect.patch = document.location.origin + '/notas-de-ventas/' + r.data;

                    this.redirect.message = 'Se a generado una nota de venta con número: ' +  r.data;

                    $('#redirect').modal({

                        backdrop: 'static',

                        keyboard: false
                    });

                } else {

                    this.$toasted.success(r.data);

                    this.getlist();

                    this.spin = false;

                }


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

            axios.post(urldomine + 'api/quotes/note/save', data).then(() => {

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
                }).then(() => {

                  axios.get(urldomine + 'api/quotes/files/' + this.item.id).then(r => {

                      $('#camera_img').val(null);

                      $('#camera_video').val(null);

                      $('#microphone').val(null);

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
        showCamera_Image() {
          $('#camera_img').click();
        },
        showCamera_Video() {
            $('#camera_video').click();
        },
        showCamera_Audio() {
            $('#microphone').click();
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
