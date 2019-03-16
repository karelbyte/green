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
                name: '',
                password: '',
                email: '',
                rol: '',
                active_id: false,
            },
            itemDefault: {
                id: 0,
                name: '',
                password: '',
                email: '',
                rol: '',
                active_id: false,
            },
            repassword: '',
            listfield: [{name: 'Nombre', type: 'text', field: 'users.name'}],
            filters_list: {
                descrip: 'Nombre',
                field: 'users.name',
                value: ''
            },
            orders_list: {
                field: 'users.name',
                type: 'asc'
            },
            roles: [],
            value: ''
        }
    },
    components: {
        Multiselect: window.VueMultiselect.default
    },
    mounted () {

        this.propertyShowDelObj = 'name';

        this.labeledit = 'Actualizar usuario';

        this.labelnew = 'Añadir usuario';

        this.patchDelete = 'api/users/';

        this.keyObjDelete = 'uid'

    },
    methods: {
        getlist (pFil, pOrder, pPager) {
            if (pFil !== undefined) { this.filters = pFil }

            if (pOrder !== undefined) { this.orders = pOrder }

            if (pPager !== undefined) { this.pager = pPager }

            this.spin = true;

            axios({
                method: 'post',

                url: urldomine + 'api/users/list',

                data: {

                    start: this.pager_list.page - 1,

                    take: this.pager_list.recordpage,

                    filters: this.filters_list,

                    orders: this.orders_list
                }

            }).then(res => {

                this.spin = false;

                this.lists = res.data.list;

                this.roles = res.data.roles;

                this.pager_list.totalpage = Math.ceil(res.data.total / this.pager.recordpage)

            }).catch(e => {

                this.spin = false;

                toastr["error"](e.response.data);
            })
        },
        save () {

            this.spin = true;

            delete this.item['status'];

            this.item.rol = this.value;

            let data = {

                'user': this.item,
            };

            axios({

                method: this.act,

                url: urldomine + 'api/users' + (this.act === 'post' ? '' : '/' + this.item.uid),

                data: data

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
        edit (it) {

            this.item = {...it};

            this.act = 'put';

            this.title = this.labeledit;

            this.value = it.roles[0];

            this.onview('new')

        },
        pass () {

            let name = this.item.name !== '';

            let password = this.act === 'put' ? true : (this.item.password === this.repassword) && (this.item.password !== '');

            let email = /^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,})$/i.test(this.item.email);

            let rols = this.value !== '';

            return name && password && email && rols
        }
    }
});
