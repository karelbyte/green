Vue.config.devtools = true;

new Vue({
    el: '#app',
    mixins: [core],
    data () {
        return {
            item: {
                id: 0,
                name: '',
                permissions: []
            },
            itemDefault: {
                id: 0,
                name: '',
                permissions: []
            },
            filters_list: {
                name: '',
                value: ''
            },
            orders_list: {
                field: 'name',
                type: 'desc'
            },
            views: {
                list: true,
                new: false
            },
            all: false,
            grants: [],
        }
    },
    mounted () {
       this.propertyShowDelObj = 'name';

       this.labeledit = 'Modificar rol';

       this.labelnew = 'Añadir rol';

       this.patchDelete = 'api/roles/';

       this.getlist()
    },
    methods: {
        getlist (pFil, pOrder, pPager) {

            if (pFil !== undefined) { this.filters_list = pFil }

            if (pOrder !== undefined) { this.orders_list = pOrder }

            if (pPager !== undefined) { this.pager_list = pPager }

            this.spin = true;

            axios({

                method: 'post',

                url: urldomine + 'api/roles/list',

                data: {

                    start: this.pager_list.page - 1,

                    take: this.pager_list.recordpage,

                    filters: this.filters_list,

                    orders: this.orders_list
                }

            }).then(response => {

                this.spin = false;

                this.lists = response.data.list;

                this.modules = response.data.permisos;

                this.pager_list.totalpage = Math.ceil(response.data.total / this.pager_list.recordpage)

            }).catch(e => {

                this.spin = false;

                toastr["error"](e.response.data)

            })
        },
        edit (it) {

            this.item = {...it};

            this.act = 'put';

            this.title = 'Actualizar rol: ' + this.item.name;

            this.grants = this.item.permissions.map(it => it.name);

            this.onview('new')

        },
        chekset (rol) {

           if (!this.grants.includes(rol)) {

               this.grants = this.grants.filter(it => it.indexOf(rol) === -1 )
           }
        },
        checkall() {
           this.grants = this.all ? this.modules : []
        },
        save () {

            let datos = {

                'rol': this.item.name,

                'permission': this.grants
            };

            if (datos.permission.length > 0)  {

                this.spin = true;

                axios({

                    method: this.act,

                    url: urldomine + 'api/roles' + (this.act === 'post' ? '' : '/' + this.item.id),

                    data: datos

                }).then(response => {

                    this.spin = false;

                    toastr["success"](response.data);

                    this.getlist();

                    this.onview('list')

                }).catch(e => {

                    this.spin = false;

                    toastr["error"](e.response.data)

                })
            } else {
                toastr["error"]('Tiene que selecionar algun modulo con sus permisos!')
            }

        },
        delitem () {

            this.spin = true;

            axios({

                method: 'delete',

                url: urldomine + 'api/roles/' + this.item.id

            }).then(response => {

                this.spin = false;

                $('#modaldelete').modal('hide');

                toastr["success"](response.data);

                this.getlist();

            }).catch(e => {

                this.spin = false;

                toastr["error"](e.response.data)
            })

        },
        pass () {
            return this.item.name !== '' && this.grants.length > 0
        }
    }
});
