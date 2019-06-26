
require('./bootstrap');


const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));


const app = new Vue({
    el: '#notify',
    data () {
        return {
           user_id_auth: 0,
           landscapers: 0,
           quote_confirm: 0,
           sale_note_not_close: 0,
           quote_local_close: 0,
           sale_note_not_delivered: 0,
           qualities_send_info: 0,
           visit_home_end: 0,
           i: 0
        }
    },
    mounted () {
        this.user_id_auth = parseInt($('#user_id_auth').val());
        axios.post(urldomine + 'api/notifications/today', {user_id_auth: this.user_id_auth}).then(r => {
            this.landscapers = r.data.landscapers.length;
            this.quote_confirm = r.data.quoteconfirm.length + r.data.quotetracing.length;
            this.sale_note_not_close = r.data.sale_note_not_close.length + r.data.sale_note_not_payment.length;
            this.quote_local_close = r.data.quote_local_close.length;
            this.sale_note_not_delivered = r.data.sale_note_not_delivered.length;
            this.qualities_send_info = r.data.qualities_send_info.length + r.data.qualities_send_info_confirm.length;
            this.visit_home_end = r.data.visit_home_end.length;
            // -------------------------------
            if (this.landscapers > 0) {this.i++}
            if (this.quote_confirm > 0) {this.i++}
            if (this.sale_note_not_close > 0) {this.i++}
            if (this.quote_local_close > 0) {this.i++}
            if (this.sale_note_not_delivered > 0) {this.i++}
            if (this.qualities_send_info > 0) {this.i++}
            if (this.visit_home_end > 0) {this.i++}

        })
    }
});
