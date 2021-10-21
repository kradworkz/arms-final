<template>
<div>
    <div class="chat-leftsidebar-nav mt-3 mb-3">
        <ul class="nav nav-pills nav-justified">
            <li class="nav-item" @click="navigate('Device')">
                <a href="#chat" data-toggle="tab" aria-expanded="true" class="nav-link active">
                    <i class="bx bx-chat font-size-20 d-sm-none"></i>
                    <span class="d-none d-sm-block">Devices</span>
                </a>
            </li>
            <li class="nav-item" @click="navigate('Asset')">
                <a href="#contact" data-toggle="tab" aria-expanded="false" class="nav-link">
                    <i class="bx bx-book-content font-size-20 d-sm-none"></i>
                    <span class="d-none d-sm-block">Assets</span>
                </a>
            </li>
            <li class="nav-item" @click="navigate('Station')">
                <a href="#group" data-toggle="tab" aria-expanded="false" class="nav-link">
                    <i class="bx bx-group font-size-20 d-sm-none"></i>
                    <span class="d-none d-sm-block">Stations</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="chat-leftsidebar-nav">
        <div class="mt-2" v-for="(category,index) in categories" v-bind:key="category.id" @click="show(category)">
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

                            <div class="float-right font-size-16 mt-2 mr-2" v-if="drop == true">
                              <i :class="'text-'+category.color+' bx bxs-x-circle'"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>           
        </div>

        <table  v-if="drop == true"  class="table table-centered table-nowrap mt-4" >
            <tbody>
                <tr v-for="(status,index) in lists" v-bind:key="status.id" style="cursor: pointer;" @click="view(status.id)"  :class="{'table-secondary':selected == status.id}">
                    <td style="width: 50px;">
                        <div :class="'font-size-22 text-'+status.color">
                           <i class='bx bxs-alarm-exclamation' ></i>
                        </div>
                    </td>
                    <td>
                        <div>
                            <h5 class="font-size-12 mb-1">{{ status.name }}</h5>
                        </div>
                    </td>
                    <td>
                        <div class="text-right">
                            <h5 class="font-size-12 text-muted mb-0">({{ status.count }})</h5>
                        </div>
                    </td>
                </tr>
                <tr style="cursor: pointer;" @click="view('krad')"  :class="{'table-secondary':selected == 'krad'}">
                    <td style="width: 50px;">
                        <div class='font-size-22 text-secondary'>
                           <i class='bx bxs-alarm-exclamation' ></i>
                        </div>
                    </td>
                    <td>
                        <div>
                            <h5 class="font-size-12 mb-1">Show All</h5>
                        </div>
                    </td>
                    <td>
                        <div class="text-right">
                            <h5 class="font-size-12 text-muted mb-0">({{this.l}})</h5>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</template>

<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            errors: [],
            pagination: {},
            categories: [],
            statuses: [],
            status: [],
            active: [],
            inactive: [],
            lists: [],
            drop: false,
            selected: '',
            l: 0,
            type: 'Device'
        }
    },

    created(){
        this.fetchDevice();
        this.fetchStatus();
    },

    methods : {

        navigate(type){
            switch(type){
                case 'stations':
                break;
                case 'Device':
                    this.fetchDevice();
                break;
                case 'Asset':
                    this.fetchCategory();
                break;
            }
            this.type = type;
            this.countStatus();
            this.empty();
        },

        fetchCategory(){
            axios.get(this.currentUrl + '/request/dropdowncount/category/-')
            .then(response => {
                this.categories = response.data.data;
                this.inactive = response.data.data;
            })
            .catch(err => console.log(err));
        },

        fetchDevice(){
            axios.get(this.currentUrl + '/request/dropdowncount/device/-')
            .then(response => {
                this.categories = response.data.data;
                this.inactive = response.data.data;
            })
            .catch(err => console.log(err));
        },

        show(category){
            if(this.drop == true){
                this.empty();
            }else{
                if(this.active.length < 1){
                    this.active.push(category);
                    this.categories = this.active;
                    this.drop = true;
                    this.$parent.fetch(category.id);
                    this.lists  = this.status;
                }
            }
        },

        fetchStatus(){
            axios.get(this.currentUrl + '/request/dropdowns/status/-')
            .then(response => {
                this.statuses = response.data.data;
                this.countStatus();
            })
            .catch(err => console.log(err));
        },
    
        countStatus(){
            this.status = this.statuses.filter((item) => item.type == this.type);
            this.l = 0;
            for(var i=0; i < this.status.length; i++){
                if(this.status.length > 0){
                    var total = this.$parent.count(this.status[i].id);
                    this.status[i].count = total;
                    this.l = parseInt(total) + this.l;
                }
            } 
        },

        empty(){
            this.categories = this.inactive;
            this.active = [];
            this.drop = false;
            this.selected = '';
            this.view('all');
        },

        view(id){
            this.selected = id;
            this.$parent.filter(id,this.type);
        }
    }
}
</script>>