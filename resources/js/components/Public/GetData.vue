<template>
   <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form @submit.prevent="setcoordinates">
                <div class="modal-body">
                    <div class="col-md-12">
                        <div v-if="events.length < 1">
                            <center style="margin-top: 30px; margin-bottom: 30px;">
                                <i class='bx bx-loader bx-flashing bx-rotate-180' style="font-size: 100px;"></i>
                            </center>
                        </div>
                        <div v-else class="table-responsive">
                            <table class="table table-centered table-nowrap mb-0">
                                <thead class="thead-light font-size-11">
                                    <tr class="text-center">
                                        <th>Accelerometer</th>
                                        <th>Gyro</th>
                                        <th>Soil Moisture</th>
                                        <th>Temperature</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(event,index) in events" v-bind:key="index" :class="'text-center font-size-11 bg-soft-'+event.event.setting.color">
                                        <td>{{parseFloat(event.event.aa.Accelerometer).toFixed(2) }}</td>
                                        <td>{{parseFloat(event.event.aa.Gyro).toFixed(2) }}</td>
                                        <td>{{event.event.aa.SoilMoisture }}</td>
                                        <td>{{event.event.aa.Temperature }}</td>
                                        <td><span class="badge badge-primary">{{event.event.setting.date}}</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [], 
                events: [],
            }
        },

        methods : {
            listenForNewEvent(){
                Echo.join('public-channel')
                .listen('SlewsEvent', (data) => {
                    this.events.unshift(data);
                });
            },

            fetch(id){
                axios.get(this.currentUrl + '/request/datalogs/b02fd62ef52074de')
                .then(response => {
                    this.events = response.data.data;
                    console.log( JSON.parse(this.events[0].event.setting))
                })
                this.listenForNewEvent();
            },
            
        }
    }
</script>