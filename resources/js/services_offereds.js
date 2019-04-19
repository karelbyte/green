import {core} from './core';

import Multiselect from 'vue-multiselect'

import {generateId} from './tools';

new Vue({
    mixins: [core],
    el: '#app',
    data () {
        return {
            views: {
                list: true,
                new: false,
            },
            item: {
                id: 0,
                name: '',
                details: []
            },
            itemDefault: {
                id: 0,
                name: '',
                details: []
            },
            det: {
                id: 0,
                name: '',
                init: 1,
                end: '',
                price: '',
                measure: ''
            },
            detDedault: {
                id: 0,
                name: '',
                init: 1,
                end: '',
                price: '',
                measure: ''
            },
            repassword: '',
            listfield: [{name: 'Codigo', type: 'text', field: 'services_offereds.name'},],
            filters_list: {
                descrip: 'Descripción',
                field: 'services_offereds.name',
                value: ''
            },
            orders_list: {
                field: 'services_offereds.name',
                type: 'asc'
            },
            measures: []
        }
    },
    components: {
        Multiselect
    },
    mounted () {

        this.propertyShowDelObj = 'name';

        this.labeledit = 'Actualizar servicio';

        this.labelnew = 'Añadir servicio';

        this.patchDelete = 'api/servicesoffereds/';

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

                url: urldomine + 'api/servicesoffereds/list',

                data: {

                    start: this.pager_list.page - 1,

                    take: this.pager_list.recordpage,

                    filters: this.filters_list,

                    orders: this.orders_list
                }

            }).then(res => {

                this.spin = false;

                this.lists = res.data.list;

                this.measures = res.data.measures;

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

                url: urldomine + 'api/servicesoffereds' + (this.act === 'post' ? '' : '/' + this.item.id),

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

            this.onviews('new');

            this.value = this.item.measure;

        },
        pass () {

            let name = this.item.name !== '';

            let init = this.item.details.length > 0;

            return name && init
        },
        delDetail (id) {

            this.item.details = this.item.details.filter(it => it.id !== id);
        },
        addNew() {

            let foun = this.item.details.find(it => {

               return  it.id === this.det.id

            });

            if (foun === undefined) {

                this.det.id = generateId(9);

                this.item.details.push({...this.det});

            } else {

                this.item.details = this.item.details.filter(it => it !== foun);

                this.item.details.push({...this.det});

            }

            $('#add_det').modal('hide');

        },
        showAddDet() {

            this.det = {...this.detDedault};

            $('#add_det').modal('show');
        },
        showEditDet(dt) {

            this.det = {...dt};

            $('#add_det').modal('show');
        },
        passNew () {

            let name = this.det.name !== '';

            let init = this.det.init !== '' && this.det.init > 0;

            let end = this.det.end !== '' && this.det.end > 0;

            return name && init && end
        }
    }
});
