<template>
     <div>
        <h4 class="card-title">Asset Information</h4>
        <p class="card-title-desc">Fill all information below</p>

        <form  @submit.prevent="create">
            <div class="row">
                <div class="col-md-4" style="margin-top: -20px;">
                    <myUpload field="img" @crop-success="cropSuccess" v-model="photo.show" :width="500" :height="500" :params="params" :headers="headers" lang-type="en" img-format="jpeg">
                    </myUpload>
                    <div @click="toggleShow" class="fuzone" style="width:100%;">
                        <div v-if="photo.url != ''">
                            <img :src="photo.url" style="width: 100%;">
                        </div>
                        <div v-else class="fu-text" @click="toggleShow">
                            <span><i class="fa fa-picture"></i> Click here to upload<br> 
                                <span v-if="errors.avatar" style="color: red; font-size: 12px; margin-top: -20px;">({{ errors.avatar[0] }})</span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row customerform">
                    
                        <div class="row col-md-12">
                            <div class="col-md-9" style="margin-top: -10px;">
                                <div class="form-group">
                                    <label for="formrow-firstname-input">Name: <span v-if="errors.name" class="haveerror">({{ errors.name[0] }})</span></label>
                                    <input type="text" class="form-control" id="formrow-firstname-input" v-model="asset.name" style="text-transform: capitalize;">
                                </div>
                            </div>
                            <div class="col-md-3" style="margin-top: -10px;">
                                <div class="form-group form-primary">
                                    <label class="float-label">Category <span v-if="errors.category" class="haveerror">({{ errors.category[0] }})</span></label>
                                    <multiselect v-model="asset.category"  :allow-empty="false" :show-labels="false" :options="categories" placeholder="Select Category" label="name" track-by="id">
                                    </multiselect>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr>
                            <button v-if="locations.length != 0" @click="add" style="margin-top: -55px;" class="btn btn-sm btn-primary pull-right" type="button">Add Storage</button>
                        </div>
                        <div class="col-md-12">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="mdi mdi-alert-outline mr-2"></i>
                                <div class="form-group" style="margin-top:-20px; margin-bottom: 2px;">         
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" v-model="asset.trackable" class="custom-control-input" id="formrow-customCheck">
                                        <label class="custom-control-label font-size-12" for="formrow-customCheck">Is trackable via <b>GPS</b>? (<b>Yes</b>?, It will automatically generate a code for each Asset quantity)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12" v-for="(list , index) in lists" v-bind:key="'a-'+list.id+index">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="float-label">Station<span v-if="errors['lists.'+index+'.location']" class="haveerror"> {{( errors['lists.'+index+'.location'][0] )}}</span></label>
                                    <multiselect  
                                    :allow-empty="false"
                                    deselect-label="Can't remove"
                                    v-model="list.location" 
                                    @input="onChange(list.location.id)" 
                                    :show-labels="false"
                                    :options="locations" placeholder="Select Station" 
                                    label="name" track-by="id">
                                    </multiselect>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>Quantity <span v-if="errors['lists.'+index+'.quantity']" class="haveerror"> {{( errors['lists.'+index+'.quantity'][0] )}}</span></label>
                                <div class="input-group  bootstrap-touchspin bootstrap-touchspin-injected"><input type="text" v-model="list.quantity" class="form-control"><span class="input-group-btn-vertical">
                                    <button @click="addup('add',index)" class="btn btn-primary bootstrap-touchspin-up " type="button">+</button>
                                    <button @click="addup('minus',index)" class="btn btn-primary bootstrap-touchspin-down " type="button">-</button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-1"><button @click="remve(index)" class="btn btn-sm btn-warning mt-4"  type="button">Remove</button></div>
                        </div>
                        
                    </div>
                </div>
               
                <div class="col-md-12">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" @click="cancel">Cancel</button>
                    </div>
               </div>
            </div>
        </form>
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
            pagination: {},
            keyword: '',
            asset: {
                id : '',
                code: '',
                name: '',
                quantity: 1,
                category: '',
                location: '',
                trackable: true
            },
            lists : [ {quantity : 1}],
            categories: [],
            locations :[],
            photo: {show: false,url: '',signature: ''},
            params: {token: '123456798',name: 'avatar'},
            headers: {smail: '*_~'},
            isLoading: false,
            fullPage: true,
            extra: false,
            selected: '',
            removes: [],
            total: ''
        }
    },

    created(){
        this.fetchCategory();
        this.fetchLocations();
    },

    methods : {
        onChange(ids){
            var index = this.locations.map(x => {
                return x.id;
            }).indexOf(ids);
    
            this.removes.push(this.locations[index])
            this.locations.splice(index, 1);

            for(var i=0; i < this.removes.length; i++){
                let x = this.lists.some(
                    l => (
                        l.location.id === this.removes[i].id
                    )
                )
                if (!x) {
                    this.locations.push(this.removes[i]);
                    this.removes.splice(i, 1);
                }
            } 
        },

        remve(index){
            if(this.lists.length > 1){
            this.locations.push(this.lists[index].location);
            this.lists.splice(index, 1);
            this.removes.splice(index, 1);
            }
        },

        create(){
            this.isLoading = true;
            axios.post(this.currentUrl + '/request/member/asset/store', {
                id: this.asset.id,
                name: this.asset.name,
                category: this.asset.category.id,
                lists: this.lists,
                avatar: this.photo.url,
                editable: this.editable,
                extra: this.extra,
                selected: this.selected,
                trackable: this.asset.trackable
            })
            .then(response => {
                this.$emit('status', true);
                this.isLoading = false;
            })
            .catch(error => {
                if (error.response.status == 422) {
                    this.isLoading = false;
                    this.errors = error.response.data.errors;
                }else{
                     this.isLoading = false;
                    Vue.$toast.error('<strong>Contact Administrator</strong>', {
                        position: 'bottom-right'
                    });
                }
            });
        },

        add() {
            if(this.lists.length <= this.total){
                if(typeof this.lists[this.lists.length-1].location !== 'undefined'){
                    this.lists.push({quantity: 1})
                }
            }
        },

        fetchCategory(){
            axios.get(this.currentUrl + '/request/dropdowns/category/-')
            .then(response => {
                this.categories = response.data.data;;
            })
            .catch(err => console.log(err));
        },

        fetchLocations(){
            axios.get(this.currentUrl + '/request/member/locations')
            .then(response => {
                this.locations = response.data.data;
                this.total = this.locations.length;
            })
            .catch(err => console.log(err));
        },

        more(){
            (this.extra) ? this.extra = false : this.extra = true;
        },

        addup(val,index){
            if(val == 'add'){
                this.lists[index].quantity += 1;
            }else{
                if(this.lists[index].quantity > 1){
                this.lists[index].quantity -= 1;
                }
            }
        },

        toggleShow() {
            this.photo.show = !this.photo.show;
        },

        cropSuccess(imgDataUrl, field) {
            this.photo.url = imgDataUrl;
        },

        cancel(){
            this.$emit('status', false);
            this.asset  = {};
        }

    }, components: { Multiselect, myUpload}
}
</script>