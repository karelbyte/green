let core = {

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

                recordpage: 10,

                totalpage: 0

            }
        }
    },
    watch: {
        'filters.value': function () {

            this.getlist()
        }
    },
    mounted () {
        this.getlist();
    },
    methods: {
        onview: onviews,

        setfield (f){

            this.filters_list.value = '';

            this.filters_list.descrip = f.name;

            this.filters_list.field = f.field;

            if (f.type === 'select') this.filters_list.options = f.options;

            this.fieldtype = f.type

        },
        add () {
            this.item = {...this.itemDefault};

            this.act = 'post';

            this.title = this.labelnew;

            this.onview('new')

        },
        edit (it) {

            this.item = {...it};

            this.act = 'put';

            this.title = this.labeledit;

            this.onview('new')

        },
        delitem () {

            this.spin = true;

            axios({

                method: 'delete',

                url: urldomine + this.patchDelete +  this.item[this.keyObjDelete]

            }).then(r => {

                this.spin = false;

                $('#modaldelete').modal('hide');

                toastr["success"](r.data);

                this.getlist();

            }).catch(e => {

                this.spin = false;

                toastr["error"](e.response.data)

            })

        },
        showdelete(it) {

            this.item = it;

            this.delobj = it[this.propertyShowDelObj];

            $('#modaldelete').modal('show')

        },
        close () {

            this.getlist();

            this.onview('list');
        }
    }
};
