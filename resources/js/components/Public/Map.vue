<template>
<div style="height: 100%;">
    <div class="b">
        <ul class="list-inline user-chat-nav text-right mb-0">
            <li class="list-inline-item mr-0">
                <div class="dropdown" data-toggle="tooltip" data-placement="top" title="" data-original-title="Show Stations">
                    <button class="btn nav-btn" type="button">
                        <i class='bx bx-notepad'></i>
                    </button>
                </div>
            </li>
        </ul>
    </div>
    <LMap ref="mymap" style="width: 100%; height: 100%;" :zoom="zoom" :center="center">
        <LTileLayer :url="url" :attribution="attribution"></LTileLayer>
        
        <LMarker v-for="(m, index) in markers" :key="index" :lat-lng="JSON.parse(m.coordinates)" @click="view(m)">
            <l-icon
                :icon-size="iconSize"
                :icon-url="'images/markers/'+m.avatar"
                class-name="blinking"
            /> 
        </LMarker>
        
         <LMarker v-for="(m, index) in stations" :key="'c'+index" :lat-lng="JSON.parse(m.coordinates)" @click="station(m)">
            <l-icon
                :icon-size="iconSize2"
                :icon-url="'images/avatars/'+m.avatar"
                class-name="blinking2"
            /> 
        </LMarker>
    </LMap>
    <public-asset @status="message" ref="assetModal"></public-asset>
    <public-device @status="message" ref="deviceModal"></public-device>
    <public-station @status="message" ref="stationModal"></public-station>
</div>
</template>

<script>
import L from 'leaflet';
import { LMap, LTileLayer, LMarker, LIcon } from 'vue2-leaflet';
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            errors: [],
            url: "https://{s}.tile.osm.org/{z}/{x}/{y}.png",
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
            zoom: 8,
            zoomSnap: 0,
            center: [7.790777061377434, 122.8572650068709],
            confirmed : [],
            customText: "Foobar",
            iconSize: [5,5],
            iconSize2: [10,10],
            markers: [],
            selected: [],
            stations: [],
            type: 'Device'
        }
    },

    created(){
        this.fetchAssets();
    },

    mounted(){
        let map = this.$refs.mymap.mapObject;
        
        map.on('zoomend', function (){
            if(map.getZoom() < 10){
                $('.blinking').css({'width':"5px",'height':"5px",}); 
                $('.blinking2').css({'width':"10px",'height':"10px",}); 
            }

            if(map.getZoom() > 10 && map.getZoom() < 12){
                $('.blinking').css({'width':"15px",'height':"15px",}); 
                $('.blinking2').css({'width':"20px",'height':"20px",}); 
            }

            if(map.getZoom() > 12 && map.getZoom() < 14){
                $('.blinking').css({'width':"20px",'height':"20px",}); 
                $('.blinking2').css({'width':"35px",'height':"35px",}); 
            }
          
            if(map.getZoom() > 14){
                $('.blinking').css({'width':"30px",'height':"30px",}); 
                $('.blinking2').css({'width':"50px",'height':"50px",}); 
            }
        });
    },

    methods : {
        fetchAssets(id){
            this.markers = [];
            this.selected = [];
            this.stations = [];
            let key; let url;
            (id != '' && id != null) ? id = id : id = '-';
            (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';
            (this.type == 'Device') ? url = this.currentUrl + '/pub/devices/'+id+'/'+key : url = this.currentUrl + '/pub/assets/'+id+'/'+key;
            axios.get(url)
            .then(response => {
                this.markers = response.data.data;
                this.selected = response.data.data;
                this.$parent.recount();
            })
            .catch(err => console.log(err));
            setTimeout(() => {
                this.$refs.mymap.mapObject.invalidateSize(); 
            }, 500);
        },

        fetchStations(id){
            axios.get(this.currentUrl + '/pub/stations/lists')
            .then(response => {
                this.stations = response.data.data;
            })
            .catch(err => console.log(err));
            setTimeout(() => {
                this.$refs.mymap.mapObject.invalidateSize(); 
            }, 500);
        },

        filterAssets(id){
            var assetcount = this.markers.filter((item) => item.status.id == id);
            return assetcount.length;
        },

        filter(id,type){
            this.type = type;
            if(id == 'krad') {
                var asset = this.selected;
            }else if(id == 'all'){
                if(this.type == "Station"){
                    this.fetchStations();
                    this.markers = [];
                }else{
                    return this.fetchAssets();
                }
            }else{
                var asset =  this.selected.filter((item) => item.status.id == id);
            }

            if(this.type != "Station"){
                this.markers = asset;
                return asset.length;
            }
        },

        view(marker){
            // this.$refs.mymap.mapObject.on('zoomend', function (){
            //     $("#view").modal('show');
            //     this.iconSize = 40
            // });
            // this.zoomee(15,marker.coordinates)
                (this.type == 'Asset') ? this.$refs.assetModal.open(marker) : this.$refs.deviceModal.open(marker);
         
        },

        station(marker){
            this.zoomee(15,marker.coordinates)
            this.$refs.stationModal.open(marker);
        },

        message({size,coor}){
            this.zoomee(size,coor);
        },

        zoomee(val,coordinates){
            this.$refs.mymap.mapObject.flyTo(JSON.parse(coordinates), val, {
                animate: true,
                duration: 2.0
            });
        }

    }, components: { LMap, LTileLayer,LMarker, LIcon }
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
  width: 200px;
  height: 200px;
    background-color: #fff;
  border-radius: 50px;
  animation: glow2 1s infinite alternate;
}

.blinking {
  width: 100px;
  height: 100px;
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
@keyframes glow2 {
  from {
    box-shadow: 0 0 3px -3px #211900,
                0 0 6px -6px #f0f,
                0 0 9px -9px #0ff;
  }
  to {
    box-shadow: 0 0 3px 3px #211900,
                0 0 6px 6px #f0f,
                0 0 9px 9px #0ff;
  }
}
</style>