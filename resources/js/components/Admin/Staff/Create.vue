<template>
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Staff Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form @submit.prevent="create">
                <div class="modal-body">
                    <div class="row" style="margin-right: 10px; margin-left: 10px;">
                        <div class="col-md-4">
                            <myUpload field="img" @crop-success="cropSuccess" v-model="photo.show" :width="500" :height="500" :params="params" :headers="headers" lang-type="en" img-format="png">
                            </myUpload>
                            <div @click="toggleShow" class="fuzone" style="width: 210px; height: 210px;">
                                <div v-if="photo.url != ''">
                                    <img :src="photo.url" style="width: 200px; height: 200x;">
                                </div>
                                <div v-else class="fu-text" @click="toggleShow">
                                    <span><i class="fa fa-picture"></i> Click here to upload<br> <span
                                            v-if="errors.avatar"
                                            style="color: red; font-size: 12px; margin-top: -20px;">
                                            ({{ errors.avatar[0] }})</span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 customerform" style="margin-top: 15px;">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Member <span v-if="errors.member" class="haveerror">({{ errors.member[0] }})</span></label>
                                        <multiselect 
                                        v-model="user.member" 
                                        :options="agencies" 
                                        placeholder="Select Agency" 
                                        track-by="id"
                                        label="name">
                                        </multiselect>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-primary">
                                        <label class="float-label" v-bind:style="errors.province ? 'color: red' : ''">Province</label>
                                        <multiselect @input="onChangeProvince(user.province.id)" v-model="user.province"
                                            :options="provinces" placeholder="Select Province" :show-labels="false" :allow-empty="false" label="name" track-by="id">
                                        </multiselect>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                        <label class="float-label" v-bind:style="errors.municipality ? 'color: red' : ''">Municipality</label>
                                    <multiselect v-model="user.municipality" :options="municipalities" placeholder="Select Municipality" :show-labels="false" label="name" track-by="id">
                                    </multiselect>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Personnel: <span v-if="errors.name" class="haveerror">({{ errors.name[0] }})</span></label>
                                        <input type="text" class="form-control" v-model="user.name" style="text-transform: capitalize;">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Email: <span v-if="errors.email" class="haveerror">({{ errors.email[0] }})</span></label>
                                        <input type="email" class="form-control" v-model="user.email" style="text-transform: lowercase;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>

</template>

<script>
    import Multiselect from 'vue-multiselect';
    import myUpload from 'vue-image-crop-upload/upload-2.vue';
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [], 
                agencies: [],
                provinces: [],
                municipalities: [],
                user: {id: '',name: '',member: '',avatar: '',type: '',province: '', municipality: ''},
                photo: {show: false,url: '',signature: ''},
                params: {token: '123456798',name: 'avatar'},
                headers: {smail: '*_~'},
                editable: false,
            }
        },

        created(){
            this.fetchMember();
            this.fetchProvince();
        },

        methods : {

            fetchMember(){
                axios.get(this.currentUrl + '/request/admin/member/list')
                .then(response => {
                    this.agencies = response.data.data;;
                })
                .catch(err => console.log(err));
            },

            fetchProvince() {
                axios.get(this.currentUrl + '/request/provinces/10')
                    .then(response => {
                        this.provinces = response.data.data;
                    })
                    .catch(err => console.log(err));
            },

            fetchMunicipality($id) {
                axios.get(this.currentUrl + '/request/municipalities/' + $id)
                    .then(response => {
                        this.municipalities = response.data.data;
                    })
                    .catch(err => console.log(err));
            },

            onChangeProvince($id) {
                this.fetchMunicipality($id);
            },

            create(){
                axios.post(this.currentUrl + '/request/admin/user/store', {
                    id: this.user.id,
                    name: this.user.name,
                    email: this.user.email,
                    member_id: this.user.member.id,
                    img: this.photo.url,
                    municipality_id: this.user.municipality.id,
                    editable: this.editable
                })
                .then(response => {
                    this.clear();
                    this.$emit('status', true);
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
            },

            edit(user,editable){
                this.user = user;
                this.editable = editable;
            },

            clear(){
                this.editable = false;
                $("#new").modal("hide");
                this.isLoading = false;
                this.empty();
            },

            empty(){
                this.user = {id: '',name: '',member: '',avatar: '',type: '',province: '', municipality: ''};
            },

            toggleShow() {
                this.photo.show = !this.photo.show;
            },

            cropSuccess(imgDataUrl, field) {
                this.photo.url = imgDataUrl;
            }

        }, components: { Multiselect, myUpload }

    }
</script>