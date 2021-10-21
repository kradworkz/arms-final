<template>
    <div class="modal-dialog modal-dialog-centered modal" role="document" style="max-width: 700px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ list.name }}</h5>
                <button type="button" @click="close" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mb-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex flex-wrap mb-3">
                                    <div class="avatar-sm mr-3">
                                        <div class="avatar-title bg-light rounded-circle font-size-20 text-success">
                                            <i class="bx bxs-check-circle"></i>
                                        </div>
                                    </div> 
                                    <h6 class="mb-0 mt-3 text-dark">Available <span class="text-muted font-16">- {{ list.available}} {{list.name}}</span></h6>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex flex-wrap mb-3">
                                    <div class="avatar-sm mr-3">
                                        <div class="avatar-title bg-light rounded-circle font-size-20 text-danger">
                                            <i class="bx bxs-x-circle"></i>
                                        </div>
                                    </div> 
                                    <h6 class="mb-0 mt-3 text-dark">Not Available <span class="text-muted font-16">- {{ list.notavailable}} {{list.name}}</span></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mt-2" v-for="(category,index) in first" v-bind:key="category.id" @click="show(category)">
                            <div class="card border shadow-none mb-2">
                                <a href="javascript: void(0);" class="text-body">
                                    <div class="p-2">
                                        <div class="d-flex">
                                            <div class="avatar-xs align-self-center ml-2 mr-3">
                                                <div :class="'avatar-title rounded bg-transparent text-'+category.color+' font-size-20'">
                                                        <i :class="'bx bx-'+category.type"></i>
                                                </div>
                                            </div>
                                            <div class="overflow-hidden mr-auto">
                                                <h5 class="font-size-13 text-truncate mb-1">{{ category.name }}</h5>
                                                <p class="text-muted text-truncate mb-0">{{category.counts}} Assets</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>           
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-2" v-for="(category,index) in second" v-bind:key="category.id" @click="show(category)">
                            <div class="card border shadow-none mb-2">
                                <a href="javascript: void(0);" class="text-body">
                                    <div class="p-2">
                                        <div class="d-flex">
                                            <div class="avatar-xs align-self-center ml-2 mr-3">
                                                <div :class="'avatar-title rounded bg-transparent text-'+category.color+' font-size-20'">
                                                        <i :class="'bx bx-'+category.type"></i>
                                                </div>
                                            </div>
                                            <div class="overflow-hidden mr-auto">
                                                <h5 class="font-size-13 text-truncate mb-1">{{ category.name }}</h5>
                                                <p class="text-muted text-truncate mb-0">{{category.counts}} Assets</p>
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
    </div>
</template>

<script>
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                list: '',
                categories: [],
                l: '',
                first: [],
                second: []
            }
        },

        methods : {
            set(list){
                this.list = list;
                this.categories = [];
                this.first = [];
                this.second = [];

                if(list.name == "Total Devices"){
                    this.fetchDevice();
                }else if(list.name == "Total Assets"){
                    this.fetchCategory();
                }else{
                   
                }
            },

            close(){

            },

            fetchCategory(){
                axios.get(this.currentUrl + '/request/dropdowncount/category/-')
                .then(response => {
                    this.categories = response.data.data;
                    let c = Math.round(this.categories.length/2);
                    let x;
                    for(x = 0; this.categories.length>x ; x++){
                        if( x > (c-1)){
                            this.second.push(this.categories[x]);
                        }else{
                            this.first.push(this.categories[x]);
                        }
                    }
                })
                .catch(err => console.log(err));
            },

            fetchDevice(){
                axios.get(this.currentUrl + '/request/dropdowncount/device/-')
                .then(response => {
                    this.categories = response.data.data;
                    let c = Math.round(this.categories.length/2);
                    let x;
                    for(x = 0; this.categories.length>x ; x++){
                        if( x > (c-1)){
                            this.second.push(this.categories[x]);
                        }else{
                            this.first.push(this.categories[x]);
                        }
                    }
                })
                .catch(err => console.log(err));
            },

        }
    }
</script>