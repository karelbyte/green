Vue.config.devtools = true;
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
                client: '',
                moment: moment().format('YYYY-MM-DD'),
                user_id: $('#user_id_auth').val(),
                type_contact_id: 0,
                repeater: 0,
               /* type_motive: 0,*/
                landscaper: {
                    moment: '',
                    timer: '',
                    note: '',
                    user_uid: ''
                },
                type_compromise_id: 0,
                required_time: 0,
                note: 0,
                info: [],
                documents: {
                    type_info_id: 0,
                    moment: ''
                }
            },
            itemDefault: {
                id: 0,
                client: '',
                moment: moment().format('YYYY-MM-DD'),
                user_id: $('#user_id_auth').val(),
                type_contact_id: '',
                repeater: 0,
              /*  type_motive: '',*/
                landscaper: {
                    moment: '',
                    timer: '',
                    note: '',
                    user_uid: ''
                },
                type_compromise_id: 0,
                required_time: '',
                note: '',
                info: [],
                documents: {
                    type_info_id: 0,
                    moment: ''
                }
            },
            client: {
                id: 0,
                name: '',
                code: '',
                contact: '',
                email: '',
                movil: '',
                phone: '',
                address: ''
            },
            clientDefault: {
                id: 0,
                name: '',
                code: '',
                contact: '',
                email: '',
                movil: '',
                phone: '',
                address: ''
            },
            repassword: '',
            listfield: [{name: 'Numero', type: 'text', field: 'cglobals.id'}],
            filters_list: {
                descrip: 'Codigo',
                field: 'cglobals.id',
                value: ''
            },
            orders_list: {
                field: 'cglobals.id',
                type: 'desc'
            },
            clients: [],
            type_contacts: [],
            type_infos: [],
            info: '',
            info_det: '',
            info_descrip: '',
            landscapers: ''
        }
    },
    components: {
        Multiselect: window.VueMultiselect.default
    },
    mounted () {

        this.propertyShowDelObj = 'id';

        this.labeledit = 'Actualizar atencion a cliente';

        this.labelnew = 'Añadir atencion a cliente';

        this.patchDelete = 'api/cags/';

        this.keyObjDelete = 'id'

    },
    methods: {
        showSendInfo () {
            $('#sendinfo').modal('show')
        },
        showVisit() {
            $('#visita').modal('show')
        },
        showInfo() {

            $('#info').modal('show')
        },
        deleteInfo (id) {
            this.item.info = this.item.info.filter(it => it.id !== id)
        },
        saveNewInfo () {

            let info = {
                id: generateId(9),

                info: this.info,

                info_det: this.info_det,

                info_descrip: this.info_descrip
            };

            this.item.info.push(info);

            this.info = '';

            this.info_descrip = '';

            $('#info').modal('hide')
        },
        getlist (pFil, pOrder, pPager) {

            if (pFil !== undefined) { this.filters = pFil }

            if (pOrder !== undefined) { this.orders = pOrder }

            if (pPager !== undefined) { this.pager = pPager }

            this.spin = true;

            axios({
                method: 'post',

                url: urldomine + 'api/cags/list',

                data: {

                    start: this.pager_list.page - 1,

                    take: 9,

                    filters: this.filters_list,

                    orders: this.orders_list
                }

            }).then(res => {

                this.spin = false;

                this.lists = res.data.list;

                this.clients = res.data.clients;

                this.type_contacts = res.data.type_contacts;

                this.type_infos = res.data.type_infos;

                this.landscapers = res.data.landscapers;

                this.pager_list.totalpage = Math.ceil(res.data.total / 9)

            }).catch(e => {

                this.spin = false;

                toastr["error"](e.response.data);
            })
        },
        save () {

            this.spin = true;

            axios({

                method: this.act,

                url: urldomine + 'api/cags' + (this.act === 'post' ? '' : '/' + this.item.id),

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
        add () {
           axios.get(urldomine + 'api/cags/get/id').then(r => {

               this.item = {...this.itemDefault};

               this.item.id = r.data;

               this.act = 'post';

               this.title = this.labelnew;

               this.item.info = [];

               this.item.landscaper = {
                   moment: '',
                   timer: '',
                   note: '',
                   user_uid: ''
               };

               this.item.documents.moment = '';

               this.item.documents.type_info_id = 0;

               this.onview('new')

           })
        },
        trait (it) {
            it.landscaper =  it.landscaper !== null ?   it.landscaper : {
                moment: '',
                timer: '',
                note: '',
                user_uid: ''
            };

            return it
        },
        edit (it) {

           this.item.id = it.id;

           this.item.client = it.client;

           this.item.moment = it.moment;

           this.item.user_id = it.user_id;

           this.item.type_contact_id = it.type_contact_id;

           this.item.repeater = it.repeater;

           this.item.landscaper = it.landscaper === null ? {
                moment: '',
                timer: '',
                user_uid: '',
                note: '',
            }: it.landscaper;

           this.item.type_compromise_id = it.type_compromise_id;

           this.item.note = it.note;

           this.item.info = it.info;

           this.item.documents = it.documents === null ? {} : it.documents;

           this.act = 'put';

           this.title = this.labeledit;

           this.onview('new')

        },
        pass () {

            let moment = this.item.moment !== '';

            let client = this.item.client !== '';

            let type = this.item.type_contact !== '';

            let info = this.item.info.length > 0;

            let compromise  = this.item.type_compromise_id > 0;

            return moment && client && type && info && compromise
        },
        showNewClient() {

            this.client = {...this.clientDefault};

            $('#client_new').modal('show')
        },
        passInfoSend () {

            let info = this.item.documents.moment !== '';

            let det = this.item.documents.type_info_id > 0;

            return info && det
        },
        passInfo () {

            let info = this.info !== '';

            let info_det = this.info_det !== '';

            let info_descrip = this.info_descrip !== '' ;

            return info && info_det && info_descrip
        },
        passScaper() {

            let date = this.item.landscaper.moment !== '';

            let time = this.item.landscaper.timer !== '';

            let user  = this.item.landscaper.user_uid !== '' ;

            return date && time && user
        },
        passClient () {

            let name = this.client.name !== '';

            let contact = this.client.contact !== '';

            let code = this.client.code !== '' ;

            let email = /^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,})$/i.test(this.client.email);

            return name && contact && code && email
        },
        saveNewClient () {

            this.spin = true;

            axios({

                method: 'post',

                url: urldomine + 'api/clients/',

                data: this.client

            }).then(response => {

                this.spin = false;

                $('#client_new').modal('hide');

                this.getlist();

                toastr["success"](response.data);

            }).catch(e => {

                this.spin = false;

                toastr["error"](e.response.data);
            })

        }
    }
});
