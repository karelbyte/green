import datePicker from 'vue-bootstrap-datetimepicker';
import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
import moment from 'moment'
Vue.use(datePicker);
new Vue({
    el: '#app',
    data () {
        return {
            options: {
                locale: 'es',
                format: 'DD-MM-YYYY HH:mm'
            },
            spin: false,
            users: [],
            filter: {
                user_id: 0,
                star: moment().startOf('month'),
                end: moment().endOf('month')
            },
            dataQuotes: [],
            QuotesCant: 0,
            QuotesAmount: 0,
        }
    },
    mounted () {
        axios.get( urldomine + 'api/users/all').then(r => {
            this.users = r.data;
        });
    },
    methods: {
        showInfoQuote () {
          axios.post(urldomine + 'api/reports/quotes', this.filter).then(r => {
              this.dataQuotes = r.data;
              this.QuotesCant = this.dataQuotes.length;
              let total = 0;
              this.dataQuotes.forEach(item => {
                 let  subtotal = item.details.reduce( (a, b) => {
                      return a + parseFloat(b.price) * parseFloat(b.cant)
                  }, 0);
                  if (item.have_iva === 1 ||item.have_iva === true) {
                    let  iva = item.details.reduce( (a, b) => {
                          return a + parseFloat(b.price) * parseFloat(b.cant)
                      }, 0) * 0.16;
                      subtotal = subtotal + iva
                  }
                  total += subtotal;
              });
              this.QuotesAmount = total
            })
        },
        viewpdfQuote (id) {
            this.spin = true;
            axios.get(urldomine + 'api/quotes/pdf/' + id).then(response => {
                this.spin = false;
                this.scrpdf = response.data;
                $('#pdf').modal('show')
            })
        },
    }
});
