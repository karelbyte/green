import Multiselect from 'vue-multiselect'

import {core} from './core'

import {dateEs} from './tools'

new Vue({
    mixins: [core],
    el: '#app',
    data () {
        return {
            clients: [],
            services: [],
            formData: 0,
            file: null,
            views: {
                list: true,
                new: false,
                details: false,
            },
            item: {
                id: 0,
                client: '',
                moment: '',
                service: '',
                start: '',
                status: '',
                details: [],
            },
            itemDefault: {
                id: 0,
                client: '',
                moment: '',
                service: '',
                start: '',
                status: '',
                details: [],
            },
            details: [],
            detail: {
                note_gardener: '',
                note_client: '',
                note_advisor: '',
                visting_time: '',
                accept: 1
            },
            listfield: [{name: 'Cliente', type: 'text', field: 'clients.name'}],
            filters_list: {
                descrip: 'Codigo',
                field: 'clients.name',
                value: ''
            },
            orders_list: {
                field: 'clients.name',
                type: 'desc'
            },
            value: '',
            scrpdf: '',
            aux: {}
        }
    },
    components: {
        Multiselect
    },
    mounted () {

        this.formData = new FormData();

        this.propertyShowDelObj = 'client.name';

        this.labeledit = 'Actualizar mantenimiento';

        this.labelnew = 'Añadir mantenimiento';

        this.patchDelete = 'api/maintenances/';

        this.keyObjDelete = 'id'

    },
    methods: {
        dateToEs : dateEs,
        aplic () {
            this.spin = true;

            axios.get( urldomine + 'api/maintenances/confirm/' + this.aux.id).then( r => {

                $('#confirm').modal('hide');

                this.spin = false;

                this.$toasted.success(r.data);

                axios.get(urldomine + 'api/maintenances/details/' + this.item.id).then(r => {
                    this.details = r.data;
                })
            })
        },
        confirm (it) {

            this.aux = it;

            $('#confirm').modal('show');

        },
        getlist (pFil, pOrder, pPager) {
            if (pFil !== undefined) { this.filters = pFil }

            if (pOrder !== undefined) { this.orders = pOrder }

            if (pPager !== undefined) { this.pager = pPager }

            this.spin = true;

            axios({
                method: 'post',

                url: urldomine + 'api/maintenances/list',

                data: {

                    start: this.pager_list.page - 1,

                    take: this.pager_list.recordpage,

                    filters: this.filters_list,

                    orders: this.orders_list
                }

            }).then(res => {

                this.spin = false;

                this.lists = res.data.list;

                this.clients = res.data.clients;

                this.services = res.data.services;

                this.pager_list.totalpage = Math.ceil(res.data.total / this.pager_list.recordpage)

            }).catch(e => {

                this.spin = false;

                this.$toasted.error(e.response.data)
            })
        },
        save () {
           this.spin = true;
            axios({

                method: this.act,

                url: urldomine + 'api/maintenances' + (this.act === 'post' ? '' : '/' + this.item.id),

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

            this.title = this.labeledit;

            this.onviews('new')

        },
        saveInfo () {
            this.spin = true;
            axios.post(urldomine + 'api/maintenances/update/info',  this.detail).then(r => {
                this.$toasted.success(r.data);
                axios.get(urldomine + 'api/maintenances/details/' + this.item.id).then(r => {
                    this.details = r.data;
                    this.spin = false;
                    $('#retroInfo').modal('hide')
                })
            })
        },
        retroInfo (detail) {
            this.detail = detail;
            $('#retroInfo').modal('show')
        },
        saveDetail () {
            this.spin = true;
            axios.post(urldomine + 'api/maintenances/details/update',  this.detail).then(r => {
                this.$toasted.success(r.data);
                axios.get(urldomine + 'api/maintenances/details/' + this.item.id).then(r => {
                    this.details = r.data;
                    this.spin = false;
                    $('#editItem').modal('hide')
                })
            })
        },
        passCommend () {
           return  this.detail.note_advisor !== '' && this.detail.note_advisor !== null && this.file !== null
        },
        sendCommend () {
            this.spin = true;
            this.formData.append('note', this.detail.note_advisor);
            axios.post(urldomine + 'api/maintenances/commends', this.formData,
                {headers: {'content-type': 'multipart/form-data'}}
                ).then(r => {
                $('#commend').modal('hide');
                axios.get(urldomine + 'api/maintenances/details/' + this.item.id).then(r => {
                    this.details = r.data;
                    this.spin = false;
                    $('#editItem').modal('hide')
                });
                this.$toasted.success(r.data);
            })
        },
        commend (it) {
            this.detail = it;

            this.formData.append('client_id', this.item.client_id);

            this.formData.append('id', it.id);

            $('#commend').modal('show')
        },
        getfile(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length) {
                this.file = null
            } else {
                this.file = files[0];
                this.formData.append('doc', this.file)
            }
        },
        editDetail (it) {
            this.detail = it;
            $('#editItem').modal('show')
        },
        closeForm () {
            axios.get(urldomine + 'api/maintenances/details/' + this.item.id).then(r => {
                this.details = r.data;
                $('#editItem').modal('hide')
            })
        },
        pass () {

            let client = this.item.client !== '';

            let moment = this.item.start !== '';

            let service = this.item.service !== '';

            let timer = this.item.timer !== ' ' && this.item.timer > 0;

            return client && moment && service && timer
        },
        confirmCommend(detail) {
            this.detail = detail;
            $('#confirmCommend').modal('show')
        },
        applyCommend () {
            axios.post(urldomine + 'api/maintenances/update-commend-client', this.detail).then(r => {
                axios.get(urldomine + 'api/maintenances/details/' + this.item.id).then(r => {
                    this.details = r.data;
                    $('#confirmCommend').modal('hide')
                })
            })
        },
        passConfirm () {

            let moment = this.detail.moment !== '';

            let time = this.detail.visiting_time !== '' && this.detail.visiting_time !== null;

            let price = this.detail.price !== '';

            return time && moment && price
        },
        showdetails (item) {
            this.item = item;
            axios.get(urldomine + 'api/maintenances/details/' + item.id).then(r => {
                this.details = r.data
                this.onviews('details')
            });
        },
        viewpdf (id) {

            this.spin = true;

            axios.get(urldomine + 'api/maintenances/pdf/' + id).then(response => {

                this.spin = false;

                this.scrpdf = response.data;

                window.$('#pdf').modal('show')

            })
        }
    }
});
