import {dateEs} from './tools';

new Vue({
    el: '#app',
    data () {
        return {
            spin: false,
            landscapers: [],
            quoteconfirm: [],
            quotetracing: []
        }
    },
    methods: {
        dateToEs : dateEs,
    },
    mounted () {
      axios.get(urldomine + 'api/notifications/today').then(r => {

          this.landscapers = r.data.landscapers;

          this.quoteconfirm = r.data.quoteconfirm;

          this.quotetracing = r.data.quotetracing

      })
    }
});
