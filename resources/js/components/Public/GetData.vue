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
                        <center style="margin-top: 30px; margin-bottom: 30px;">
                            <i class='bx bx-loader bx-flashing bx-rotate-180' style="font-size: 100px;"></i>
                        </center>

                        {{ events}}

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
                });
            },


            fetch(id){
                this.events = [];
                this.listenForNewEvent();
                this.listenForNewEvent2();
            },
            
        }
    }
</script>