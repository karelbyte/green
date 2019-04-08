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
                address: '',
                email: '',
                www: '',
                rfc: '',
                phone1: '',
                phone2: '',
            },
            itemaux: {
            id: 0,
                name: '',
                address: '',
                email: '',
                www: '',
                rfc: '',
                phone1: '',
                phone2: '',
        },
            act: 'post'
        }
    },
    mounted () {
      axios.get(urldomine + 'api/ajustes/company/data').then(r => {
          this.item = r.data ? r.data : this.itemaux
      })
    },
    methods: {
        save () {

            this.spin = true;

            axios({

                method: this.act,

                url: urldomine + 'api/ajustes/company' + (this.act === 'post' ? '' : '/' + this.item.id),

                data: this.item

            }).then(response => {

                this.spin = false;

                this.$toasted.success(response.data)

            }).catch(e => {

                this.spin = false;

                this.$toasted.error(e.response.data)
            })

        },
        pass () {

            let name = this.item.name !== '';

            let contact = this.item.address !== '';

            let code = this.item.rfc !== '' ;

            let email = /^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,})$/i.test(this.item.email);

            return name && contact && code && email
        }
    }
});
