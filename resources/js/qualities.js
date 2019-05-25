import {core} from './core';
import {dateEs} from './tools';
new Vue({
    mixins: [core],
    el: '#app',
    data () {
        return {
            formData: 0,
            file: null,
            views: {
                list: true,
                new: false,
            },
            item: {
                id: 0,
                cglobal_id: 0,
                moment: 0,
                confirm: 0,
                url_doc: '',
                client_comment: '',
                status_id: 0
            },
            itemDefault: {
                id: 0,
                cglobal_id: 0,
                moment: 0,
                confirm: 0,
                url_doc: '',
                client_comment: '',
                status_id: 0
            },
            listfield: [{name: 'CAG', type: 'text', field: 'qualities.cglobal_id'}, {name: 'Cliente', type: 'text', field: 'clients.name'}],
            filters_list: {
                descrip: 'CAG',
                field: 'qualities.cglobal_id',
                value: ''
            },
            orders_list: {
                field: 'qualities.cglobal_id',
                type: 'asc'
            },
           find: 0,
           scrpdf: ''
        }
    },
    mounted () {
        this.formData = new FormData();
        this.find = parseInt($('#find').val());
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

                url: urldomine + 'api/qualities/list',

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

                this.pager_list.totalpage = Math.ceil(res.data.total / this.pager_list.recordpage)

            }).catch(e => {

                this.spin = false;

                toastr["error"](e.response.data);
            })
        },
        save () {

            this.spin = true;

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

            return name && contact && code && email
        },
        commend (it) {

            this.item = it;

            this.formData.append('client_id', this.item.global.client_id);

            this.formData.append('id', it.id);

            $('#commend').modal('show')
        },
        sendCommend () {
            this.spin = true;
            axios.post(urldomine + 'api/qualities/commends', this.formData,
                {headers: {'content-type': 'multipart/form-data'}}
            ).then(r => {
                $('#commend').modal('hide');
                axios.get(urldomine + 'api/qualities/details/' + this.item.id).then(r => {
                    this.details = r.data;
                    this.spin = false;
                    $('#editItem').modal('hide')
                });
                this.$toasted.success(r.data);
            })
        },
        passCommend () {
            return  this.file !== null
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
    }
});
