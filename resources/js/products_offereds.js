import {core} from './core';
import {generateId} from './tools';
import Multiselect from 'vue-multiselect'

new Vue({
    mixins: [core],
    el: '#app',
    data () {
        return {
            views: {
                list: true,
                new: false,
                needs: false
            },
            item: {
                id: 0,
                name: '',
                details: []
            },
            itemDefault: {
                id: 0,
                name: '',
                details:[]
            },
            det: {
                id: 0,
                name: '',
                measure: '',
                init: 1,
                end: '',
                meeds: []
            },
            detDedault: {
                id: 0,
                name: '',
                measure: '',
                init: 1,
                end: '',
                needs: []
            },
            need: {
                id: 0,
                element: '',
                element_id: 0,
                cant: 0
            },
            needDefault: {
                id: 0,
                element: '',
                element_id: 0,
                cant: 0
            },
            needscant: 0,
            needs: [],
            measures: [],
            elements: [],
            listfield: [{name: 'Codigo', type: 'text', field: 'products_offereds.name'},],
            filters_list: {
                descrip: 'Descripción',
                field: 'products_offereds.name',
                value: ''
            },
            orders_list: {
                field: 'products_offereds.name',
                type: 'asc'
            },
        }
    },
    components: {
        Multiselect
    },
    mounted () {

        this.propertyShowDelObj = 'name';

        this.labeledit = 'Actualizar producto';

        this.labelnew = 'Añadir producto';

        this.patchDelete = 'api/productsoffereds/';

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

                url: urldomine + 'api/productsoffereds/list',

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

                this.elements = res.data.elements;

                this.pager_list.totalpage = Math.ceil(res.data.total / this.pager_list.recordpage)

            }).catch(e => {

                this.spin = false;

                this.$toasted.error(e.response.data)
            })
        },
        save () {

            this.spin = true;

            let itemSendToback = JSON.parse( JSON.stringify( this.item ));

            itemSendToback.details = itemSendToback.details.map(it => {
               return {
                   id: it.id,
                   name: it.name,
                   measure_id: it.measure.id,
                   init: it.init,
                   end: it.end,
                   needs: it.needs.map(ne => {
                       return {
                           id: ne.id,
                           cant: ne.cant,
                           element_id : ne.element.id
                       }
                   })
               }
            });

            axios({

                method: this.act,

                url: urldomine + 'api/productsoffereds' + (this.act === 'post' ? '' : '/' + this.item.id),

                data: itemSendToback

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

            this.item.details = [];

            this.act = 'post';

            this.title = this.labelnew;

            this.det = {...this.detDedault};

            this.det.needs = [];

            this.onviews('new')

        },
        edit (it) {

            this.item = {...it};

            this.act = 'put';

            this.title = this.labeledit;

            this.onviews('new')

        },
        delDetail (id) {

            this.item.details = this.item.details.filter(it => it.id !== id);
        },
        addNew () {

                let foun = this.item.details.find(it => {

                    return  it.id === this.det.id

                });

                if (foun === undefined) {


                    this.det.id = generateId(9);

                    this.item.details.push({...this.det});

                } else {

                    this.item.details = this.item.details.filter(it => it.id !== this.det.id);

                    this.item.details.push({...this.det});
                }

                $('#add_det').modal('hide');

        },
        detEdit(it) {

            this.det = {...it};

            $('#add_det').modal('show');

        },
        pass () {

            let name = this.item.code !== '';

            let list = this.item.details.length > 0;

            return name && list
        },
        showAddDet() {

            this.det = {...this.detDedault};

            $('#add_det').modal('show');
        },
        needsShow (det) {

            this.det = det;

            this.needs = this.det.needs;

            this.needscant = this.needs.length;

            this.onviews('needs')
        },
        delNeed (id) {

            this.needs = this.needs.filter(it => it.id !== id);
        },
        showAddNeed() {

            let foun = this.needs.find(it => {

                return  it.element.id === this.need.element.id

            });

            if (foun === undefined) {

                this.need.id = generateId(9);

                this.needs.push({...this.need});

                this.need = {...this.needDefault}

            } else {

               foun.cant += this.need.cant
            }

        },
        closeNeed () {

            this.det.needs  =  this.needs;

            this.onviews('new')
        },
        passNew () {

            let name = this.det.name !== '';

            let init = this.det.init !== '' && this.det.init > 0;

            let end = this.det.end !== '' && this.det.end > 0;

            return name && init && end
        }
    }
});
