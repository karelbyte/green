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
            listfield: [ {name: 'Cliente', type: 'text', field: 'clients.name'}, {name: 'CAG', type: 'text', field: 'qualities.cglobal_id'}],
            filters_list: {
                descrip: 'Cliente',
                field: 'clients.name',
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
            this.filters_list.field = 'qualities.id';
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
                this.spin = false;
                this.getlist();
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
        confirmCommend(detail) {
            this.item = detail;
            $('#confirmCommend').modal('show')
        },
        applyCommend () {
            axios.post(urldomine + 'api/qualities/update-commend-client', this.item).then(r => {
                $('#confirmCommend').modal('hide');
                this.spin = false;
                this.getlist();
                this.$toasted.success(r.data);
            })
        },
    }
});
