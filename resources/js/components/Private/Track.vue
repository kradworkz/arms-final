<template>
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Map Track</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12" style="height: 70vh;">
                    <LMap ref="mymap" style="width: 100%; height: 100%;" :zoom="zoom" :center="center">
                        <LTileLayer :url="url" :attribution="attribution"></LTileLayer>
                      
                        <LMarker ref="marker" :lat-lng="center">
                            <l-icon  ref="ic"
                                :icon-size="iconSize"
                                :icon-url="'/images/markers/dark.png'"
                                class-name="blinking"
                            /> 
                        </LMarker>
                        
                    </LMap>
                </div>
            </div>
        </div>
    </div>
</template>

<script> 
import L from 'leaflet';
import { LMap, LTileLayer, LMarker, LIcon, LPopup } from 'vue2-leaflet';
export default {
    props: ['selectedasset'],
    data(){
        return {
            currentUrl: window.location.origin,
            url: "https://{s}.tile.osm.org/{z}/{x}/{y}.png",
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
            zoom: 16,
            center: [6.905508,122.075958],
            content: '',
            confirmed : [],
            staticAnchor: [16, 37],
            customText: "Foobar",
            iconSize: [10,10]
        }
    },

    mounted(){
        let map = this.$refs.mymap.mapObject;
        
        this.$nextTick(() => {
            this.$refs.marker.mapObject.openPopup()
        });
        
        map.on('zoomend', function (){
            if(map.getZoom() < 12){
               $('.blinking').css({'width':"10px",'height':"10px",}); 
            }
             if(map.getZoom() > 12 && map.getZoom() < 16){
               $('.blinking').css({'width':"20px",'height':"20px",}); 
            }
             if(map.getZoom() > 16){
               $('.blinking').css({'width':"30px",'height':"30px",}); 
            }
        });
    },

    methods : {

        listenForNewEvent(){
            Echo.join('public-channel')
            .listen('AssetLocation', (data) => {
                this.center = JSON.parse(data.coordinates);
            });
        },

        track(coor){
            this.center = JSON.parse(coor);
            setTimeout(() => {
                this.$refs.mymap.mapObject.invalidateSize(); 
            }, 500);
        },
        
        trackId(id){
            axios.get(this.currentUrl + '/request/member/coordinates/'+id)
            .then(response => {
                this.center = JSON.parse(response.data.coordinates);
            })
            .catch(err => console.log(err));
            // this.center = JSON.parse(coor);
            setTimeout(() => {
                this.$refs.mymap.mapObject.invalidateSize(); 
            }, 500);

            this.listenForNewEvent();
        },

    },
    components: {
        LMap,
        LTileLayer,
        LMarker, LIcon, LPopup
    }
}

</script>

<style>
div.b {
  position:fixed;
  padding:7px;
  top:50px;
  right:80px;
  max-width:450px;
  z-index:999
} 

@keyframes fade { 
  from { opacity: 0.5; } 
}

.blinking2 {
  width: 100px;
  height: 100px;
  border-radius: 50px;
  animation: glow 1s infinite alternate;
}

.blinking {
  width: 200px;
  height: 200px;
  border-radius: 100px;
  background-color: #fff;
  animation: glow 1s infinite alternate;
}
@keyframes glow {
  from {
    box-shadow: 0 0 3px -3px #fff,
                0 0 6px -6px #f0f,
                0 0 9px -9px #0ff;
  }
  to {
    box-shadow: 0 0 3px 3px #fff,
                0 0 6px 6px #f0f,
                0 0 9px 9px #0ff;
  }
}
</style>