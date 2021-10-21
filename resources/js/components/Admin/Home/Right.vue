<template>
    <div class="row">
        
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="media">
                        <div class="col-md-2">
                            <img  alt="" class="avatar-sm rounded-circle img-thumbnail img-fluid" style="max-width: 100%; height:auto;">
                        </div>
                        <div class="col-md-9">
                            <div class="text-muted">
                                <h5 class="mb-1 text-truncate">asd</h5>
                                <p class="mb-2 text-truncate">asda</p>
                            </div>
                        </div>      
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Alerts</h5>

                    
                    <div class="chat-leftsidebar-nav">
                        <div class="mt-2" v-for="(event,index) in alerts" v-bind:key="index">
                            <div class="card border shadow-none mb-2">
                                <a href="javascript: void(0);" class="text-body">
                                    <div class="p-2">
                                        <div class="d-flex">
                                            <div class="avatar-xs align-self-center ml-2 mr-3">
                                                <div :class="'avatar-title rounded bg-transparent text-'+event.event.setting.color+' font-size-20'">
                                                        <i :class="'bx bx-tada bx-'+event.event.setting.type"></i>
                                                </div>
                                            </div>

                                            <div class="overflow-hidden mr-auto">
                                                <h5 class="font-size-13 text-truncate mb-1">{{event.event.device.station }}</h5>
                                                <p class="text-muted text-truncate mb-0">
                                                    {{event.event.device.address }}
                                                </p>
                                            </div>

                                            <div class="float-right font-size-16 mt-2 mr-2">
                                                <i :class="'text-'+event.event.setting.color+' bx bxs-x-circle'"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>           
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade exampleModal" id="alert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <admin-alert @status="message" ref="alert"></admin-alert>
        </div>

    </div>
</template>

<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            errors: [],
            alerts : [],
            audio : ''
        }
    },

    created(){
        this.listenForNewEvent();
    },

    methods : {
        listenForNewEvent(){
            Echo.join('public-channel')
            .listen('NotifyEvent', (data) => {
                if(data.event.Gyro > .30 && data.event.Gyro < 1){
                    this.audio = document.getElementById("level1");
                }else if(data.event.Gyro > 1 && data.event.Gyro < 2){
                    this.audio = document.getElementById("level2");
                }else{
                    this.audio = document.getElementById("level3");
                }
                this.audio.play();
                this.alerts.unshift(data);
                this.$refs.alert.set(data);
            });
        },
        
        message(){
            this.stopAudio();
        },

        stopAudio() {
            this.audio.pause();
            this.audio.currentTime = 0;
        }

    }
}
</script>