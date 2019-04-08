Vue.config.devtools = true;

new Vue({
    mixins: [core],
    el: '#app',
    data () {
        return {
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
                notes: []
            },
            itemDefault: {
                id: 0,
                moment: '',
                descrip: '',
                specifications: '',
                type_quote_id: '',
                status_id: '',
                notes: []
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
            scrpdf: 0
        }
    },
    mounted () {

        this.propertyShowDelObj = 'name';

        this.labeledit = 'Actualizar cliente';

        this.labelnew = 'Añadir cliente';

        this.patchDelete = 'api/clients/';

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

                this.pager_list.totalpage = Math.ceil(res.data.total / this.pager_list.recordpage)

            }).catch(e => {

                this.spin = false;

                toastr["error"](e.response.data);
            })
        },
        getType (o) {
           return parseInt(o) === 2 ? 'A DISTANCIA' : 'VISITA A DOMICILIO'
        },

        // DEATALLES DE LA COTIZACION
        getTotalItem (it) {

            return  it.reduce( (a, b) => {
                return parseFloat(b.price) * parseFloat(b.cant)
            }, 0).toFixed(2)
        },
        getTotal () {

          return  this.item.details.reduce( (a, b) => {
               return parseFloat(b.price) * parseFloat(b.cant)
          }, 0).toFixed(2)
        },
        edit (it) {

            this.item = {...it};

            this.onview('newdetails')

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

                this.onview('list');

                this.getlist();

                toastr["success"](r.data);

            })
        },
        viewpdf (id) {

            this.spin = true;

            axios.get(urldomine + 'api/quotes/pdf/' + id).then(response => {

                this.spin = false;

                // window.$('#iframe').attr('src', response.data);

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

                toastr["success"](response.data);

                this.getlist();

                this.onview('list');

            }).catch(e => {

                this.spin = false;

                toastr["error"](e.response.data);
            })

        },


        // CODIGO DE TRABAJO CON FICHEROS DE LA VISITA
        showFiles(itm) {

            this.item = {...itm};

            this.onview('newfiles')
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
            axios.post(urldomine + 'api/quotes/note/save', data
            ).then(res => {
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
                      this.item.docs = r.data.docs
                  })
                })
            }
        },
        showCamera() {
          $('#file').click()
        }
    }
});
