<template>
   <div class="row">
   
       <div class="col-lg-4" v-for="(list,index) in total" v-bind:key="list.id">
            <a @click="view(list)"><div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex flex-wrap">
                        <div class="mr-3">
                            <p class="text-muted text-truncate mb-2">{{list.name}}</p> 
                            <h5 class="mb-0">{{list.count}}</h5>
                        </div>
                        <div class="avatar-sm ml-auto">
                            <div :class="'avatar-title bg-light rounded-circle text-'+list.color+' font-size-20'">
                                <i :class="'bx '+list.icon+''"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div></a>
        </div>

        <div class="col-lg-12">
            <div class="">
                <div class="">
                    <div class="table-responsive">
                        <table class="table project-list-table table-nowrap table-centered table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col">Station</th>
                                    <th class="text-center" scope="col">Device</th>
                                    <th class="text-center" scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(event,index) in alerts" v-bind:key="index" :class="'bg-soft-'+event.event.setting.color">
                                    <td>
                                        <h5 class="text-truncate font-size-14 mb-0"><a class="text-dark">{{event.event.device.station }}</a></h5>
                                        <p class="text-muted mb-0">{{event.event.device.address }}</p>
                                    </td>
                                    <td class="text-center font-size-11">{{event.event.device.type.name }}</td>
                                    <td class="text-center"><span class="badge badge-primary">{{event.event.setting.date}}</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade exampleModal" id="view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <admin-view ref="view"></admin-view>
        </div>

    </div>
</template>

<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            errors: [],
            total: [],
            list: '',
            alerts: []
        }
    },

    created(){
        this.fetchTotal();
         this.listenForNewEvent();
    },

    methods : {
        listenForNewEvent(){
            Echo.join('public-channel')
            .listen('NotifyEvent', (data) => {
                this.alerts.unshift(data);
            });
        },

        fetchTotal(){
            axios.get(this.currentUrl + '/request/admin/totals')
            .then(response => {
                this.total = response.data[0];
            })
            .catch(err => console.log(err));
        },

        view(list){
            this.list = list;
            this.$refs.view.set(list);
            $("#view").modal('show');
        },

        close(){

        }
    }
}
</script>