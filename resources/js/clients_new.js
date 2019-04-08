
new Vue({
    el: '#app',
    data () {
        return {
            spin: false,
            views: {
                list: true,
                new: false,
            },
            item: {
                id: 0,
                name: '',
                code: '',
                contact: '',
                email: '',
                movil: '',
                phone: '',
                address: ''
            },
            itemDefault: {
                id: 0,
                name: '',
                code: '',
                contact: '',
                email: '',
                movil: '',
                phone: '',
                address: ''
            },
            act: 'post'
        }
    },
    mounted () {
        this.add()
    },
    methods: {
        save () {

            this.spin = true;

            axios({

                method: this.act,

                url: urldomine + 'api/clients' + (this.act === 'post' ? '' : '/' + this.item.id),

                data: this.item

            }).then(response => {

                this.spin = false;

                this.$toasted.success(response.data);

                this.add()

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

            })
        },
        pass () {

            let name = this.item.name !== '';

            let contact = this.item.contact !== '';

            let code = this.item.code !== '' ;

            let email = /^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,})$/i.test(this.item.email);

            return name && contact && code && email
        }
    }
});
