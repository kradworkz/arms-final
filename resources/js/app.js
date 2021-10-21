/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import VueToast from 'vue-toast-notification';
Vue.use(VueToast);
import Vue from 'vue';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('password', require('./components/Password.vue').default);
Vue.component('login', require('./components/Login.vue').default);
Vue.component('set-map', require('./components/Private/Map.vue').default);
Vue.component('track-map', require('./components/Private/Track.vue').default);

/////////////////////////////////////////////////////////////////////////////////////

Vue.component('admin-home-left', require('./components/Admin/Home/Left.vue').default);
Vue.component('admin-home-right', require('./components/Admin/Home/Right.vue').default);
Vue.component('admin-home-bottom', require('./components/Admin/Home/Bottom.vue').default);
Vue.component('admin-view', require('./components/Admin/Home/View.vue').default);
Vue.component('admin-alert', require('./components/Admin/Home/Alert.vue').default);

Vue.component('agency', require('./components/Admin/Agency/Index.vue').default);
Vue.component('agency-create', require('./components/Admin/Agency/Create.vue').default);

Vue.component('lgu', require('./components/Admin/Lgu/Index.vue').default);

Vue.component('staff', require('./components/Admin/Staff/Index.vue').default);
Vue.component('staff-create', require('./components/Admin/Staff/Create.vue').default);

Vue.component('device', require('./components/Admin/Device/Index.vue').default);
Vue.component('device-create', require('./components/Admin/Device/Create.vue').default);
Vue.component('trackers', require('./components/Admin/Device/Tracker.vue').default);

Vue.component('application-setting', require('./components/Admin/Lists/Index.vue').default);
Vue.component('admin-home', require('./components/Admin/Home/Index.vue').default);

////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////
Vue.component('member-home', require('./components/Member/Home/Index.vue').default);
Vue.component('home-left', require('./components/Member/Home/Left.vue').default);
Vue.component('home-right', require('./components/Member/Home/Right.vue').default);
Vue.component('home-bottom', require('./components/Member/Home/Bottom.vue').default);
Vue.component('piechart', require('./components/Member/Home/Piechart.vue').default);

Vue.component('assetslist', require('./components/Member/Asset/Index.vue').default);
Vue.component('asset-create', require('./components/Member/Asset/Create.vue').default);
Vue.component('asset-view', require('./components/Member/Asset/View/Index.vue').default);
Vue.component('asset-header', require('./components/Member/Asset/View/Header.vue').default);
Vue.component('asset-body', require('./components/Member/Asset/View/Body.vue').default);
Vue.component('asset-add', require('./components/Member/Asset/View/Add.vue').default);
Vue.component('asset-set', require('./components/Member/Asset/View/Set.vue').default);

Vue.component('stations', require('./components/Member/Station/Index.vue').default);
Vue.component('station-create', require('./components/Member/Station/Create.vue').default);

Vue.component('search', require('./components/Member/Search/Search.vue').default);
Vue.component('search-view', require('./components/Member/Search/View.vue').default);
Vue.component('search-buttons', require('./components/Member/Search/Buttons.vue').default);


////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////

Vue.component('public-sidebar', require('./components/Public/Sidebar.vue').default);
Vue.component('public-map', require('./components/Public/Map.vue').default);
Vue.component('public-getdata', require('./components/Public/GetData.vue').default);
Vue.component('public-asset', require('./components/Public/Modals/Asset.vue').default);
Vue.component('public-station', require('./components/Public/Modals/Station.vue').default);
Vue.component('public-device', require('./components/Public/Modals/Device.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data(){
        return {
            currentUrl: window.location.origin,
        }
    },
    methods: {
        fetch(id){
            this.$refs.map.fetchAssets(id);
        },
        count(id){
            return this.$refs.map.filterAssets(id);
        },
        filter(id,type){
            return this.$refs.map.filter(id,type);
        },
        zoomee(val){
            return this.$refs.map.zoomee(val);
        },
        recount(){
            this.$refs.sidebar.countStatus();
        },


        //////////////////////////////////
        /////////////////////////////////
        setMap(type){
            $("#setmap").modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
            this.$refs.setmap.set(type);
        },

        setCoor(latlang,type){
            $("#setmap").modal('hide');
            this.$refs[type].$refs.create.populate('['+latlang.lat+','+latlang.lng+']');
        },

        trackMap(coordinates){
            $("#trackmap").modal('show');
            this.$refs.trackmap.track(coordinates);
        },

        trackMapId(id){
            $("#trackmap").modal('show');
            this.$refs.trackmap.trackId(id);
        },

        getData(id){
            $("#getdata").modal('show');
            this.$refs.getdata.fetch(id);
        },
        setForm(latlang){
            this.$refs.setmap.setCoordinates(latlang);
            $("#setmap").modal('show');
        },

        //////////////////////////////////////////////
        ///////////////// LOGIN API //////////////////
        //////////////////////////////////////////////

        validateToken(){
            let toks = localStorage.getItem('api_token');
            if(toks == null){    
                    this.show();
            }else{
                axios.post(this.currentUrl+'/api/check', {
                    toks: toks,
                })
                .then(response => {
                    if(response.data.code == 16){
                        this.show();
                    }else{
                        this.$refs.apiconnection.check(true);
                    }
                })
                .catch(error => {
                    if (error.response.status == 401) {
                        this.show();
                    }
                });
           }
          
        },
        show(){
            $("#loginapi").modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        },

        check(boolean){
            this.$refs.apiconnection.check(boolean);
        },

        login(){
            this.show();
        }
    }
});
