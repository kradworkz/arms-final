<template>
     <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Set Coordinates</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form @submit.prevent="setcoordinates">
                <div class="modal-body">
                    <div class="col-md-12" style="height: 500px;">
                    <LMap 
                        ref="mymap" 
                        style="width: 100%; height: 100%;"
                        :zoom="zoom"
                        :center="center"
                        @click="setMarker"
                    >
                        <LTileLayer :url="url" :attribution="attribution"></LTileLayer>
                      
                        <LMarker :lat-lng="center">
                            <!-- <LIcon
                            class-name="customicon">
                            <img :src="currentUrl+'/images/avatars/marker.png'" style="height: 50px; width: 50px;">
                            </LIcon> -->
                              <!-- <l-icon
                                :icon-size="dynamicSize"
                                :icon-anchor="dynamicAnchor"
                                icon-url="currentUrl+'/images/avatars/marker.png"
                            /> -->
                        </LMarker>
                    </LMap>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>
</template>

<script>
    import L from 'leaflet';
    import { LMap, LTileLayer, LMarker, LIcon } from 'vue2-leaflet';
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                url: "https://{s}.tile.osm.org/{z}/{x}/{y}.png",
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
                zoom: 20,
                center: [6.905508,122.075958],
                confirmed : [],
                staticAnchor: [16, 37],
                customText: "Foobar",
                iconSize: 64 ,
                type: ''
            }
        },

        computed: {
            dynamicSize() {
                return [this.iconSize, this.iconSize * 1.15];
            },
            dynamicAnchor() {
                return [this.iconSize / 2, this.iconSize * 1.15];
            }
        },

        methods : {
            set(type){
                setTimeout(() => {
                    this.$refs.mymap.mapObject.invalidateSize(); 
                }, 500);

                this.type = type;
            },
            
            setCoordinates(latlang){
                this.center = JSON.parse(latlang);
                setTimeout(() => {
                    this.$refs.mymap.mapObject.invalidateSize(); 
                }, 500);
            },

            setMarker(event){
                var latlang = {
                    lng: parseFloat(event.latlng.lng.toFixed(6)),
                    lat: parseFloat(event.latlng.lat.toFixed(6))
                };
                
               this.$parent.setCoor(latlang,this.type);
            }
        },  
        
        components: {LMap,LTileLayer,LMarker, LIcon}
    }
</script>
