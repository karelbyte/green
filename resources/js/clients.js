import {core} from './core';
import {dateEs} from './tools';
new Vue({
    mixins: [core],
    el: '#app',
    data () {
        return {
            views: {
                list: true,
                new: false,
                files: false
            },
            scrpdf: '',
            item: {
                id: 0,
                name: '',
                code: '',
                contact: '',
                email: '',
                movil: '',
                phone: '',
                street: '',
                home_number: '',
                colony: '',
                referen: ''
            },
            itemDefault: {
                id: 0,
                name: '',
                code: '',
                contact: '',
                email: '',
                movil: '',
                phone: '',
                street: '',
                home_number: '',
                colony: '',
                referen: ''
            },
            files: {
                cags: [],
                quotes: []
            },
            listfield: [{name: 'Nombre', type: 'text', field: 'clients.name'}, {name: 'Codigo', type: 'text', field: 'clients.code'}],
            filters_list: {
                descrip: 'Nombre',
                field: 'clients.name',
                value: ''
            },
            orders_list: {
                field: 'clients.name',
                type: 'asc'
            },
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
        dateToEs : dateEs,
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
        getlist (pFil, pOrder, pPager) {

            if (pFil !== undefined) { this.filters = pFil }

            if (pOrder !== undefined) { this.orders = pOrder }

            if (pPager !== undefined) { this.pager = pPager }

            this.spin = true;

            axios({
                method: 'post',

                url: urldomine + 'api/clients/list',

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
        save () {

            this.spin = true;

            this.item.register_to = this.user_id_auth;

            axios({

                method: this.act,

                url: urldomine + 'api/clients' + (this.act === 'post' ? '' : '/' + this.item.id),

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
        add () {
          axios.get(urldomine + 'api/clients/get/id').then(r => {

            this.item = {...this.itemDefault};

            this.act = 'post';

            this.item.code = r.data;

            this.title = this.labelnew;

            this.onviews('new')

            })
        },
        pass () {

            let name = this.item.name !== '';

            let contact = this.item.contact !== '';

            let code = this.item.code !== '' ;

            let email = /^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,})$/i.test(this.item.email);

            let street = this.item.street !== '';

            let home_number = this.item.home_number !== '';

            let colony = this.item.colony;

            return name && contact && code && email && street && home_number && colony
        },
        filesGet (item) {
            this.item = item;
            axios.get(urldomine + 'api/clients/files/' + item.id).then(r => {
                this.files = r.data;
                if ( this.files.cags !== null) {
                    this.onviews('files')
                } else {
                    this.$toasted.info('El cliente no cuenta aun con un expediente!')
                }
            })
        },
        showpdfCag(id) {
            this.spin = true;
            axios.get(urldomine + 'api/cags/pdf/' + id).then(response => {
                this.spin = false;
                this.scrpdf = response.data;
                window.$('#pdf').modal('show')
            })
        },
        showpdfsale (id) {
            this.spin = true;
            axios.get(urldomine + 'api/sales/pdf/' + id).then(response => {
                this.spin = false;
                this.scrpdf = response.data;
                $('#pdf').modal('show')
            })
        },
        viewpdfQuote (id) {
            this.spin = true;
            axios.get(urldomine + 'api/quotes/pdf/' + id).then(response => {
                this.spin = false;
                this.scrpdf = response.data;
                $('#pdf').modal('show')
            })
        },
    }
});
