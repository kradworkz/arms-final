<template>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Latest Asset Location</h4>
                    <div class="table-responsive" style="min-height: 230px;">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th class="text-center">Asset Code</th>
                                    <th class="text-center">Coordinates</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(list,index) in lists" v-bind:key="index">
                                    <td>{{index+1}}</td>
                                    <td class="text-center"><a class="text-body font-weight-bold">{{list.code}}</a> </td>
                                    <td class="text-center">{{list.coordinates}}</td>
                                    <td class="text-center">
                                        <span v-if="list.status == 1" class="badge badge-lg badge-success">Serviceable</span>
                                        <span v-else-if="list.status == 0" class="badge badge-lg badge-danger">Non Serviceable</span>
                                        <span v-else class="badge badge-warning">GPS</span>
                                    </td >
                                    <td class="text-center">{{list.created_at}}</td>
                                </tr>
                                
                            </tbody>
                            
                        </table>
                        <div class="col-md-12 align-center" style="margin-top: 50px;" v-if="lists.length == 0">
                            <center>
                            <i class='bx bx-wifi bx-flashing' style="font-size: 100px;"></i>
                            </center>
                        </div>
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Alerts</h4>
                    
                </div>
            </div>
        </div>

        <audio id="level1">
            <source src="assets/musics/alert1.mp3" type="audio/mp3">
        </audio>
        <audio id="level2">
            <source src="assets/musics/alert2.mp3" type="audio/mp3">
        </audio>
            <audio id="level3">
            <source src="assets/musics/alert3.mp3" type="audio/mp3">
        </audio>
    </div>
</template>

<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            errors: [],
            lists: [],
            alerts: [],
        }
    },

    created(){
        this.listenForNewEvent();
        this.listenForNewEvent2();
    },

    methods : {

        listenForNewEvent(){
            Echo.join('public-channel')
            .listen('AssetLocation', (data) => {
                this.lists.unshift(data);
            });
        },

        listenForNewEvent2(){
            Echo.join('public-channel')
            .listen('NotifyEvent', (data) => {
                if(data.event.Gyro > .30 && data.event.Gyro < 1){
                    var audio = document.getElementById("level1");
                }else if(data.event.Gyro > 1 && data.event.Gyro < 2){
                    var audio = document.getElementById("level2");
                }else{
                    var audio = document.getElementById("level3");
                }
                audio.play();
                this.alerts.unshift(data);
            });
        }

    }
}
</script>