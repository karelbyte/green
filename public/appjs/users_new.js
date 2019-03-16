Vue.config.devtools = true;

new Vue({
    el: '#app',
    data () {
        return {
           spin: false,
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
            roles: [],
            value: '',
            act: 'post'
        }
    },
    components: {
        Multiselect: window.VueMultiselect.default
    },
    mounted () {

        axios.get( urldomine + 'api/roles/get').then(r => {
            this.roles = r.data
        })
    },
    methods: {

        save () {

            this.spin = true;

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

                this.item = {...this.itemDefault};

                this.value = ''

            }).catch(e => {

                this.spin = false;

                toastr["error"](e.response.data);
            })

        },
        pass () {

            let name = this.item.name !== '';

            let password = (this.item.password === this.repassword) && (this.item.password !== '');

            let email = /^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,})$/i.test(this.item.email);

            let rols = this.value !== '';

            return name && password && email && rols
        }
    }
});
