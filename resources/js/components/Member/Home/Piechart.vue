<template>
    <div class="row">
        <div class="col-md-5">
            <div id="chart">
                <apexchart type="pie" :options="chartOptions" :series="series" ref="piechart"></apexchart>
            </div>
        </div>
        <div class="col-md-7">
            <div class="text-center text-muted">
                <div class="row">
                    <div class="col-3" v-for="(list,index) in reports" v-bind:key="list.id" >
                        <div class="mt-3">
                            <p class="mb-2 text-truncate"><i :class="'bx bxs-circle text-'+list.color+' mr-1'"></i>{{ list.name }}</p>
                            <h5>{{ list.counts }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <hr></hr>
            <div class="d-flex flex-wrap mb-1 mt-5">
                <div class="avatar-sm mr-3">
                    <div class="avatar-title bg-light rounded-circle font-size-20 text-success">
                        <i class="bx bxs-check-circle"></i>
                    </div>
                </div> 
                <h5 class="mb-0 mt-3 text-dark">Operational <span class="text-muted font-16">- {{report.counts }} assets</span></h5>
            </div>
            <div class="table-responsive mt-4">
                <table class="table table-centered table-nowrap">
                    <tbody>
                        <tr v-for="(list) in report.percentage" v-bind:key="list.id">
                            <td style="width: 30%">
                                <p class="mb-0 font-weight-bold">{{list.name}}</p>
                            </td>
                            <td style="width: 25%">
                                <h5 class="mb-0">{{list.count}} <span class="text-muted font-size-11"> ({{list.percentage}}%)</span></h5></td>
                            <td>
                                <div class="progress progress-sm">
                                    <div :class="'progress-bar bg-'+list.color+' rounded'" role="progressbar" :style="'width: '+list.percentage+'%'" :aria-valuenow="list.percentage" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
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
                reports: [],
                report: {},
                series: [],
                chartOptions: {
                    chart: {
                        width: 380,
                        type: 'pie',
                    },
                    labels: [],
                    fill: {
                        colors: ['#34c38f', '#f46a6a','#343a40','#f1b44c']
                    },
                    legend : {
                        show: false,
                    },
                    responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                    }]
                },
            }
        },

        created(){
            this.fetchReports();
        },

        methods : {
            fetchReports(){
                axios.get(this.currentUrl + '/request/dropdowncount/status/asset')
                .then(response => {
                    this.reports = response.data.data;
                    this.report = response.data.data[0];
                    // this.updateSeriesPie();
                     for (let i = 0; i < response.data.data.length; i++) {
                        this.series.push(response.data.data[i].counts);
                        this.chartOptions.labels.push(response.data.data[i].name);
                    }

                })
                .catch(err => console.log(err));
            },

            updateSeriesPie() {
                // console.log(this.reports);
                this.$refs.piechart.updateSeries([{
                   chartOptions : {
                       labels : ['test','test2','test3','test4']
                   },
                }], false, true);
            },
        }, components : {apexchart: VueApexCharts}
    }
</script>