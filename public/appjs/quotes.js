Vue.config.devtools = true;

new Vue({
    mixins: [core],
    el: '#app',
    data () {
        return {
            views: {
                list: true,
                newfiles: false,
            },
            item: {
                id: 0,
                moment: '',
                type_quote_id: '',
                status_id: ''
            },
            itemDefault: {
                id: 0,
                moment: '',
                type_quote_id: '',
                status_id: ''
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
                type: 'asc'
            },
            doc: {}
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
        showFiles(itm) {

            this.item = {...itm};

            this.onview('newfiles')
        },
        deleteFile(id) {

            axios.get(urldomine + 'api/quotes/file/delete/' + id).then(r => {

                this.item.docs = this.item.docs.filter(it => it.id !== id)
            })
        },
        showVisor (doc) {
            this.doc = doc;
            $('#repro').modal('show');
        },
        saveFile(e) {
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
                      this.item.docs = r.data.docs
                  })
                })
            }
        },
        add () {
          axios.get(urldomine + 'api/quotes/get/id').then(r => {

            this.item = {...this.itemDefault};

            this.act = 'post';

            this.item.code = r.data;

            this.title = this.labelnew;

            this.onview('new')

            })
        },
        showCamera() {
          $('#file').click()
        },
        pass () {

            let name = this.item.name !== '';

            let contact = this.item.contact !== '';

            let code = this.item.code !== '' ;

            let email = /^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,})$/i.test(this.item.email);

            return name && contact && code && email
        }
    }
});
