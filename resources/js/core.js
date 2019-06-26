export const core = {

    data () {
        return {
            delobj: '',

            keyObjDelete: '',

            propertyShowDelObj: '',

            patchDelete: '',

            title: '',

            labeledit: '',

            labelnew: '',

            lists: [],

            spin: false,

            act: 'post',

            fieldtype: 'text',

            pager_list: {

                page: 1,

                recordpage: 39,

                totalpage: 0

            },
            user_id_auth: 0,
            off: false,
            filters_list_aux: {
                descrip: '',
                field: '',
                type: '',
                value: ''
            },
        }
    },
    directives: {
         focus: {
             inserted: function (el) {
                 el.focus()
             }
         },
        numericonly: {
            bind(el) {
                el.addEventListener('keydown', (e) => {
                    if ([46, 8, 9, 27, 13, 110, 190].indexOf(e.keyCode) !== -1 ||
                        // Allow: Ctrl+A
                        (e.keyCode === 65 && e.ctrlKey === true) ||
                        // Allow: Ctrl+C
                        (e.keyCode === 67 && e.ctrlKey === true) ||
                        // Allow: Ctrl+X
                        (e.keyCode === 88 && e.ctrlKey === true) ||
                        // Allow: home, end, left, right
                        (e.keyCode >= 35 && e.keyCode <= 39)) {
                        // let it happen, don't do anything
                        return
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault()
                    }
                })
            }
        }
    },
    watch: {
        'filters_list.value': function () {
            this.getlist()
        }
    },
    mounted () {
        this.user_id_auth = parseInt($('#user_id_auth').val());
       if (!this.off) {this.getlist(); }
    },
    methods: {

        setfield (f){

            this.filters_list = {...this.filters_list_aux};

            this.filters_list.value = '';

            this.filters_list.descrip = f.name;

            this.filters_list.field = f.field;

            this.filters_list.type = f.type;

            if (f.type === 'select') this.filters_list.options = f.options;

            this.fieldtype = f.type

        },
        add () {
            this.item = JSON.parse( JSON.stringify( this.itemDefault ));

            this.act = 'post';

            this.title = this.labelnew;

            this.onviews('new')

        },
        edit (it) {

            this.item = {...it};

            this.act = 'put';

            this.title = this.labeledit;

            this.onviews('new')

        },
        delitem () {

            this.spin = true;

            axios({

                method: 'delete',

                url: urldomine + this.patchDelete +  this.item[this.keyObjDelete]

            }).then(r => {

                this.spin = false;

                $('#modaldelete').modal('hide');

                this.$toasted.success(r.data);

                this.getlist();

            }).catch(e => {

                this.spin = false;

                this.$toasted.error(e.response.data)

            })

        },
        showdelete(it) {

            this.item = {...it};

            this.delobj = it[this.propertyShowDelObj];

            $('#modaldelete').modal('show')

        },
        close () {

            this.getlist();

            this.onviews('list');
        },
        onviews (pro){

            for (let property in this.views) {

                this.views[property] = property === pro
            }
        }
    }
};
