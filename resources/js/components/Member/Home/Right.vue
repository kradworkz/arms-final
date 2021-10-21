<template>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="col-md-2">
                        <img :src="currentUrl+'/images/avatars/'+agency.agency.avatar" alt="" class="avatar-sm rounded-circle img-thumbnail img-fluid" style="max-width: 100%; height:auto;">
                    </div>
                     <div class="col-md-9">
                        <div class="text-muted">
                            <h5 class="mb-1 text-truncate">{{agency.agency.name}}</h5>
                            <p class="mb-2 text-truncate">{{agency.address.name}}</p>
                        </div>
                    </div>      
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card" style="min-height: 400px;">
            <div class="card-body">
                <h5 class="card-title mb-4">Categories Count</h5>
                <div class="chat-leftsidebar-nav">
                    <div class="mt-2" v-for="(category,index) in categories" v-bind:key="category.id" @click="show(category)" v-if="index != 0">
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

                                        <div class="float-right font-size-16 mt-2 mr-2">
                                        <i :class="'text-'+category.color+' bx bxs-x-circle'"></i>
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
                errors: [],
                categories: [],
                agency: {
                    agency: {}, address : {}
                }
            }   
        },

        created(){
            this.fetchAgency();
            this.fetchCategory();
        },

        methods : {
            fetchCategory(){
                axios.get(this.currentUrl + '/request/dropdowncount/category/-')
                .then(response => {
                    this.categories = response.data.data;
                    this.inactive = response.data.data;
                })
                .catch(err => console.log(err));
            },

            fetchAgency(){
                axios.get(this.currentUrl + '/request/agency')
                .then(response => {
                    this.agency = response.data[0];
                })
                .catch(err => console.log(err));
            },
        }
    }
</script>