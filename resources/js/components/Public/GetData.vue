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

                     <apexchart class="mt-4" height="240" :options="chartOptions" :series="series" ref="packets"></apexchart>
                        <!--<div v-if="events.length < 1">
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
                        -->

                    </div>
                </div>
            </form>

        </div>
    </div>
</template>

<script>
    import VueApexCharts from 'vue-apexcharts';
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [], 
                events: [],
                series: [{
                    data: [],
                }],
                chartOptions: {
                    chart: {
                        id: 'area-datetime',
                        type: 'area',
                        height: 350,
                        zoom: {
                            autoScaleYaxis: true
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    markers: {
                        size: 0,
                        style: 'hollow',
                    },
                    xaxis: {
                        type: 'datetime',
                        min: new Date('01 May 2021').getTime(),
                        tickAmount: 6,
                    },
                    tooltip: {
                        x: {
                            format: 'dd MMM yyyy'
                        }
                    },
                    stroke: {
                        width: 1.5
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.7,
                            opacityTo: 0.9,
                            stops: [0, 100]
                        }
                    },
                }, 
                selection: 'todayss',
                year: new Date().getFullYear(),
                month: '',
                week: '',
                showyear: false,
                showmonth: false,
                showweek: false,
                type: 'Monthly'
            }
        },

        methods : {
            listenForNewEvent(){
                Echo.join('public-channel')
                .listen('SlewsEvent', (data) => {
                    this.events.unshift(data);
                });
            },

            updateSeriesLine(gyro) {
                this.$refs.packets.updateSeries([{
                    data: this.series[0].data,
                }], false, true);
            },

            fetch(id){
                axios.get(this.currentUrl + '/request/datalogs/b02fd62ef52074de')
                .then(response => {
                    this.series[0].data = response.data.data;
                    this.updateSeriesLine();
                    // this.events = response.data.data;
                    // console.log( JSON.parse(this.events[0].event.setting))
                })
                this.listenForNewEvent();
            },
            
        },  components: { apexchart: VueApexCharts }
    }
</script>