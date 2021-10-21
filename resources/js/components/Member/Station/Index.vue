<template>
<div class="d-xl-flex">
    <div class="w-100">
        <div class="card">
            
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-xl-6 col-sm-6 form-inline">
                        <button @click="newloc" type="button" class="btn btn-danger waves-effect waves-light mr-2"><i class='bx bx-plus'></i></button>
                        <form class="float-sm-right form-inline">
                            <div class="search-box">
                                <div class="position-relative">
                                    <input type="text" class="form-control bg-light border-light rounded" placeholder="Search..." v-model="keyword" @keyup="fetch()">
                                   <i class='bx bx-search-alt search-icon'></i>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-xl-6 col-sm-6">
                        <ul class="list-inline user-chat-nav text-right mb-0 dropdown">
                            <li class="list-inline-item d-none d-sm-inline-block font-size-12">{{pagination.current_page}} out of {{pagination.last_page}}</li>
                            <li class="list-inline-item d-none d-sm-inline-block">
                                <a class="btn nav-btn" v-bind:class="[{disabled: !pagination.prev_page_url}]" @click="fetch(pagination.prev_page_url)">
                                    <i class='bx bxs-chevron-left font-size-16'></i>
                                </a>
                            </li>
                            <li class="list-inline-item d-none d-sm-inline-block">
                                <a class="btn nav-btn" v-bind:class="[{disabled: !pagination.next_page_url}]" @click="fetch(pagination.next_page_url)">
                                    <i class='bx bxs-chevron-right font-size-16'></i>
                                </a>
                            </li>
                            <li class="list-inline-item d-non d-sm-inline-block">
                                <button @click="fetch()" type="button" class="btn btn-light"><span class="d-none d-sm-inline-block "> <i class='bx bx-refresh'></i></span></button>                                 
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="table-responsive" data-simplebar style="max-height: calc(100vh - 340px); min-height: calc(100vh - 340px);">
                    <table class="table table-centered table-nowrap">
                        <thead class="thead-light" style="position: sticky; top:0; background-color: white;">
                            <tr>
                                <th></th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Asset Count</th>
                                <th class="text-center">Address</th>
                                <th class="text-center">Contact</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="location in locations" v-bind:key="location.id" @click="view(location.id)" :class="{'table-success':trselected == location.id}">
                                <td>
                                    <div class="avatar-xs"><span class="avatar-title rounded-circle">{{location.name.charAt(0)}}</span></div>
                                </td>
                                <td class="text-center">{{location.name}}</td>
                                <td class="text-center">{{location.assets}}</td>
                                <td class="text-center">{{location.address}}</td>
                                <td class="text-center">{{location.contact_no}}</td>
                                <td class="text-center">
                                    <!--<a :href="'assetlist/'+location.id" class="mr-3 text-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"><i class='bx bx-show'></i></a>-->
                                    <a class="mr-3 text-warning" @click="edit(location)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class='bx bx-edit-alt' ></i></a>
                                    <a  @click="track(location.coordinates)" class="text-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class='bx bxs-map' ></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal fade exampleModal" id="newloc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <station-create @status="message" ref="create"></station-create>
            </div>
            
        </div>
    </div>
</div>
</template>

<script>
import Multiselect from 'vue-multiselect';
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            errors: [],
            pagination: {},
            keyword: '',
            locations: [],
            trselected : '',
            editable: false, 
        }
    },

    created(){
        this.fetch();
    },

    methods : {

        makePagination(meta, links) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev,
                total: meta.total,
            };
            this.pagination = pagination;
        },

        fetch(page_url){
            let vm = this; let key;
            (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';
            page_url = page_url || this.currentUrl + '/request/member/location/lists/'+key;

            axios.get(page_url)
            .then(response => {
                this.locations = response.data.data;
                vm.makePagination(response.data.meta, response.data.links);
            })
            .catch(err => console.log(err));
        },

        track(coordinates){
            if(coordinates != 'n/a'){
                this.$parent.trackMap(coordinates);
            }
        },

        newloc(val){
            $("#newloc").modal('show');
        },

        edit(location){
            $("#newloc").modal('show');
            this.editable = true;
            this.$refs.create.edit(location,true);
        },

        view(id){
            this.trselected = id;
        },

        message(val){
            if(val){
                if(this.editable == true){
                    let page_url = '/request/member/location/lists/-?page=' + this.pagination.current_page;
                    this.fetch(page_url);
                }else{
                    this.fetch();
                }
                $("#newloc").modal('hide');
                this.editable = false;
            }
        }

     }, components: { Multiselect }
}
</script>