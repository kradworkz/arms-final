<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-xl-6 col-sm-6 form-inline">
                            <form class="float-sm-right form-inline">
                                <div class="search-box">
                                    <div class="position-relative">
                                        <input type="text" class="form-control bg-light border-light rounded" placeholder="Search..." v-model="keyword" @keyup="search()">
                                    <i class='bx bx-search-alt search-icon'></i>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-xl-6 col-sm-6">
                            <ul class="list-inline user-chat-nav text-right mb-0 dropdown">
                                <li class="list-inline-item d-non d-sm-inline-block">
                                    <button @click="check(true)" type="button" class="btn btn-light"><span class="d-none d-sm-inline-block "> <i class='bx bx-refresh'></i></span></button>                                 
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="table-responsive" style="min-height: 230px;">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th class="text-center">Device Code</th>
                                    <th class="text-center">Device Name</th>
                                    <th class="text-center">Last Seen</th>
                                    <th class="text-center">Battery Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(device,index) in devices" v-bind:key="device+index">
                                    <td>{{index+1}}</td>
                                    <td class="text-center"><a class="text-body font-weight-bold">{{device.code}}</a> </td>
                                    <td class="text-center">{{device.name}}</td>
                                    <td class="text-center">{{device.lastseen}}  <span class="font-size-10">({{device.date}})</span></td>
                                    <td :class="'text-center font-size-24 text-'+device.battery_color"><i :class="'bx bxs-'+device.battery_status"></i> ({{device.battery}})</td>
                                </tr>
                                
                            </tbody>
                            
                        </table>
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                keyword: '',
                pagination: {},
                devices: []
            }
        },
        created(){
            this.check(true);
        },
        methods : {
            checkApi(){
                this.$parent.validateToken();
            },
            check(value){
                if(value == true){
                    let toks = localStorage.getItem('api_token');
                    
                    axios.post(this.currentUrl+'/krad/api/devices',{
                        toks : toks
                    })
                    .then(response => {
                        if(response.data.code == 16){
                            this.$parent.login();
                        }else{
                            this.devices = response.data.data;
                            console.log(this.devices);
                        }
                    })
                    .catch(err => console.log(err));
                   
                }
            },
            search(){
                if(this.keyword.length > 0){
                    let toks = localStorage.getItem('api_token');
                    axios.post(this.currentUrl+'/krad/api/device/search',{
                        toks : toks,
                        keyword: this.keyword
                    })
                    .then(response => {
                        if(response.data.code == 16){
                            this.$parent.login();
                        }else{
                            this.devices = response.data.data;
                            console.log(this.devices);
                        }
                    })
                    .catch(err => console.log(err));
                }else{
                    this.check(true);
                }
            }
        }
    }
</script>