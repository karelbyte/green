import VueCal from 'vue-cal'
import 'vue-cal/dist/vuecal.css'
import Multiselect from 'vue-multiselect'
import datePicker from 'vue-bootstrap-datetimepicker';
import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
import moment from 'moment'
Vue.use(datePicker);
new Vue({
    el: '#app',
    data () {
        return {
           spin: false,
            item: {
                id: 0,
                user_id: 0,
                title: '',
                start: '',
                end: '',
                background: true,
                name: '',
                class: 'user',
                contentFull: '',
                dayoff_id: 0,
                allDay: false,
                user: {
                    name: ''
                }
            },
            datas: [],
            user_id_auth: 0,
            act: 'post',
            options: {
                locale: 'es',
                format: 'DD-MM-YYYY HH:mm'
            },
            users : []
        }
    },
    components: {
        Multiselect, VueCal
    },
    mounted () {
        this.user_id_auth = parseInt($('#user_id_auth').val());
        let date = moment();
        this.getList(date.month() + 1, date.year());
        axios.get( urldomine + 'api/users/all').then(r => {
            this.users = r.data;
        });
    },
    methods: {
       logEvents(event) {
           let date = moment(event.startDate);
           this.getList( date.month() + 1, date.year() );
       },
       dateEstoUs (s) {
            let b = s.split(' ');
            let d = b[0].split('-');
            return d[2] + '-' + d[1] + '-' + d[0] + ' ' + b[1]
        },
        getList(m, y) {
            let data = {
                user_id_auth :  this.user_id_auth,
                month: m,
                year: y
            };
            axios.post( urldomine + 'api/calendars/list',  data).then(r => {
                this.datas = r.data;
            });
        },
        onEventClick (event, e) {
            if (!isNaN(event.id)) {
                this.act = 'put';
                this.item.user_id = event.user_id;
                this.item.allDay = event.allDay;
                this.item.id = event.id;
                this.item.for_user_id = event.for_user_id;
                this.item.start =  new moment(event.start).format('DD-MM-YYYY HH:ss');
                this.item.end = new moment(event.end).format('DD-MM-YYYY HH:ss');
                this.item.title = event.title;
                this.item.contentFull = event.contentFull;
                this.item.cglobal_id = event.cglobal_id;
                this.item.user.name = event.user.name;
                $('#scheduleedit').modal('show');
                e.stopPropagation()
            }  else {
                toastr["info"]('Encuentre el inicio del evento!');
            }
        },
        addEvent() {
           if (this.act === 'post') {
               axios.post( urldomine + 'api/calendars/add', this.item).then(() => {
                   $('#schedule').modal('hide');
                   let date = moment();
                   this.getList( date.month() + 1, date.year());
               });
           } else {
               axios.post( urldomine + 'api/calendars/update', this.item).then(() => {
                   $('#scheduleedit').modal('hide');
                   let date = moment();
                   this.getList( date.month() + 1, date.year());
               });
           }
        },
        clickDay (event) {
            this.act = 'post';
            this.item.user_id  = this.user_id_auth;
            this.item.start =  new moment(event).add(8, 'h').format('DD-MM-YYYY HH:ss');
            this.item.end = new moment(event).add(18, 'h').format('DD-MM-YYYY HH:ss');
            this.item.title = '';
            this.public = false;
            this.item.allDay = false;
            this.item.dayoff_id = 0;
            this.item.contentFull = '';
            $('#schedule').modal('show');
        },
        deleteEvent() {
            axios.post(urldomine + 'api/calendars/eraser', {id : this.item.id}).then((r) => {
                let date = moment();
                this.getList( date.month() + 1, date.year());
                this.$toasted.success(r.data);
                $('#scheduleedit').modal('hide');
            })
        }
    }
});


