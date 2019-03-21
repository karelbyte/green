Vue.config.devtools = true;

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
    methods: {
        save () {

            this.spin = true;

            axios({

                method: this.act,

                url: urldomine + 'api/providers' + (this.act === 'post' ? '' : '/' + this.item.id),

                data: this.item

            }).then(response => {

                this.spin = false;

                toastr["success"](response.data);

                this.item = {...this.itemDefault};

            }).catch(e => {

                this.spin = false;

                toastr["error"](e.response.data);
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
