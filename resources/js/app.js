
require('./bootstrap');


const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));


const app = new Vue({
    el: '#notify',
    data () {
        return {
           landscapers: 0,
           quoteconfirm: 0
        }
    },
    mounted () {
        axios.get(urldomine + 'api/notifications/today').then(r => {
            this.landscapers = r.data.landscapers.length;
            this.quoteconfirm = r.data.quoteconfirm.length;
        })
    }
});
