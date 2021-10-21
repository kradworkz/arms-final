<template>
    <div class="row">
       <div class="col-lg-4" v-for="(list,index) in total" v-bind:key="list.id">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex flex-wrap">
                        <div class="mr-3">
                            <p class="text-muted text-truncate mb-2">{{list.name}}</p>
                            <h5 class="mb-0">{{list.count}}</h5>
                        </div>

                        <div class="avatar-sm ml-auto">
                            <div :class="'avatar-title bg-light rounded-circle text-'+list.color+' font-size-20'">
                                <i :class="'bx '+list.icon+''"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body" style="position: relative; min-height: 360px;">
                    <piechart></piechart>
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
                total: []
            }
        },
        
        created(){
            this.fetchTotal();
        },

        methods : {
            fetchTotal(){
                axios.get(this.currentUrl + '/request/member/totals')
                .then(response => {
                    this.total = response.data[0];
                })
                .catch(err => console.log(err));
            }
        }
    }
</script>