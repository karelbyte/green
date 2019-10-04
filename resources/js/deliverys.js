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
            listfield: [{name: 'Cliente', type: 'text', field: 'clients.name'}, {name: 'Codigo', type: 'text', field: 'salesnotes.id'}],
            filters_list: {
                descrip: 'Cliente',
                field: 'clients.name',
                value: ''
            },
            orders_list: {
                field: 'clients.name',
                type: 'desc'
            },
            value: '',
            scrpdf: '',
            aux: {},
            find: 0
        }
    },
    components: {
        Multiselect
    },
    mounted () {
        this.formData = new FormData();
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
                url: urldomine + 'api/deliverys/list',
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
                this.$toasted.error(e.response.data)
            })
        },
        viewpdf (id) {
            this.spin = true;
            axios.get(urldomine + 'api/deliverys/pdf/' + id).then(response => {
                this.spin = false;
                this.scrpdf = response.data;
                window.$('#pdf').modal('show')
            })
        }
    }
});
