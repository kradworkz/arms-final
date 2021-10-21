<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body" v-if="addnew == false">
                    <div class="row mb-3">
                        <div class="col-xl-6 col-sm-6 form-inline">
                             <button type="button" @click="newasset" class="btn btn-danger waves-effect waves-light mr-2"><i class='bx bx-plus'></i></button>
                            <form class="form-inline">
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
                            </ul>
                        </div>
                    </div>

                    <div class="table-responsive" data-simplebar style="max-height: calc(100vh - 340px); min-height: calc(100vh - 340px);">
                        <table class="table table-centered table-nowrap">
                            <thead class="thead-light" style="position: sticky; top:0; background-color: white;">
                                <tr>
                                    <th></th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Location</th>
                                    <th class="text-center">Availability</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="asset in assets" v-bind:key="asset.id" @click="view(asset.id)" :class="{'table-success':trselected == asset.id}">
                                    <td>
                                        <div class="avatar-xs"><span class="avatar-title rounded-circle">{{asset.name.charAt(0)}}</span></div>
                                    </td>
                                    <td class="text-center">{{asset.name}}</td>
                                    <td class="text-center">{{asset.location}}</td>
                                    <td class="text-center">{{asset.available}} out of {{asset.quantity}}</td>
                                    <td class="text-center">
                                        <a :href="'/assets/list/'+asset.id" class="mr-3 text-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"><i class='bx bx-show'></i></a>
                                        <a class="mr-3 text-warning" @click="edit(asset)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class='bx bx-edit-alt' ></i></a>
                                        <a class="text-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class='bx bx-trash'></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-body" v-else>
                    <asset-create :stations="locations" @status="newass"></asset-create>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import myUpload from 'vue-image-crop-upload/upload-2.vue';
export default {
    props: {

    },
    data(){
        return {
            currentUrl: window.location.origin,
            errors: [],
            pagination: {},
            keyword: '',
            assets: [],
            locations: [],
            editable: false,
            addnew: false,
            trselected : '',
            asset: {}
        }
    },

    created(){
        this.fetch();
    },

    methods: {
        makePagination(meta, links) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev
            };
            this.pagination = pagination;
        },

        fetchLocations(){
            axios.get(this.currentUrl + '/request/member/locations')
            .then(response => {
                this.locations = response.data.data;
                this.total = this.locations.length;
            })
            .catch(err => console.log(err));
        },

        fetch(page_url) {
            let vm = this; let key;
            (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';
            page_url = page_url || this.currentUrl + '/request/member/assets/'+key;

            axios.get(page_url)
            .then(response => {
                this.assets = response.data.data;
                vm.makePagination(response.data.meta, response.data.links);
            })
            .catch(err => console.log(err));
        },

        newass(status) {
            if (status) {
                Vue.$toast.success('<strong>Successfully Created</strong>', {
                    position: 'bottom-left'
                });
                this.addnew = false;
                this.fetch();
            }else{
                this.addnew = false;
            }
        },

        view(asset){
            this.trselected = asset;
        },

        newasset(){
            this.addnew = true;
        },

        edit(){

        }

    }, components: { myUpload }
}
</script>