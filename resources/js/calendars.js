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
                position_id: ''
            },
            itemDefault: {
                id: 0,
                name: '',
                password: '',
                email: '',
                rol: '',
                active_id: false,
                position_id: ''
            },
            datas: [],
            act: 'post'
        }
    },
    components: {
        Multiselect: window.VueMultiselect.default,
        'vue-cal': vuecal
    },
    mounted () {
        axios.post( urldomine + 'api/calendars/list').then(r => {
            this.datas = r.data.data;
        });
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

            let position = this.item.position_id !== '';

            let password = (this.item.password === this.repassword) && (this.item.password !== '');

            let email = /^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,})$/i.test(this.item.email);

            let rols = this.value !== '';

            return name && password && email && rols && position
        }
    }
});


