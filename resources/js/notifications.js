import {dateEs} from './tools';

let notifications = new Vue({
    el: '#app',
    data () {
        return {
            user_id_auth: 0,
            spin: false,
            landscapers: [],
            quoteconfirm: [],
            quotetracing: [],
            sale_note_not_close: [],
            quote_local_close: [],
            sale_note_not_payment: [],
            sale_note_not_delivered: [],
            not: 0
        }
    },
    methods: {
        dateToEs : dateEs,
        gotoUrl (id, type) {
            let patch = '';
            switch (type) {
                case 1: // COTIZACION A DOMICIOLIO
                    patch = document.location.origin + '/cotizaciones/' + id;
                    break;
                case 2: // NOTAS DE VENTA
                    patch = document.location.origin + '/notas-de-ventas/' + id;
                    break;
                default:
            }
            return patch ;
        }
    },
    mounted () {
      this.user_id_auth = parseInt($('#user_id_auth').val());

      axios.post(urldomine + 'api/notifications/today', {user_id_auth: this.user_id_auth}).then(r => {

          this.landscapers = r.data.landscapers;

          this.quoteconfirm = r.data.quoteconfirm;

          this.quotetracing = r.data.quotetracing;

          this.sale_note_not_close = r.data.sale_note_not_close;

          this.quote_local_close = r.data.quote_local_close;

          this.sale_note_not_payment = r.data.sale_note_not_payment;

          this.sale_note_not_delivered = r.data.sale_note_not_delivered;

          this.not = this.landscapers.length === 0 && this.quoteconfirm.length === 0
              && this.quotetracing.length === 0 && this.sale_note_not_close.length === 0
              && this.quote_local_close.length === 0 && this.sale_note_not_payment.length
              &&  this.sale_note_not_delivered.length;

      })
    }
});
