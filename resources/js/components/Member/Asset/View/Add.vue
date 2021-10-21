<template>
    <div class="modal fade exampleModal" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{text}}</h5>
                    </div>
                    <form  @submit.prevent="create">
                        <div class="modal-body customerform">
                            <div class="row" v-if="type == 'Quantity'">
                                <div class="col-md-12">
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <i class="mdi mdi-alert-outline mr-2"></i>
                                        <div class="form-group" style="margin-top:-20px; margin-bottom: 2px;">         
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" v-model="trackable" class="custom-control-input" id="formrow-customCheck">
                                                <label class="custom-control-label font-size-12" for="formrow-customCheck">Is trackable via <b>GPS</b>? (<b>Yes</b>?, It will automatically generate a code for each Asset quantity)</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label>Quantity <span v-if="errors['quantity']" class="haveerror"> {{( errors['quantity'])}}</span></label>
                                    <div class="input-group  bootstrap-touchspin bootstrap-touchspin-injected"><input type="text" v-model="quantity" class="form-control"><span class="input-group-btn-vertical">
                                        <button @click="addup('add')" class="btn btn-primary bootstrap-touchspin-up " type="button">+</button>
                                        <button @click="addup('minus')" class="btn btn-primary bootstrap-touchspin-down " type="button">-</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div v-else-if="type == 'Update'">
                                <div class="form-group ">
                                    <label for="formrow-firstname-input">Tracker Code: <span v-if="errors.trackercode" class="haveerror">({{ errors.trackercode[0] }})</span></label>
                                    <input type="text" class="form-control" v-model="trackercode" style="text-transform: capitalize;">
                                </div>
                                <div class="form-group ">
                                    <label for="formrow-firstname-input">Asset Code: <span v-if="errors.assetcode" class="haveerror">({{ errors.assetcode[0] }})</span></label>
                                    <input type="text" class="form-control" v-model="assetcode" style="text-transform: capitalize;">
                                </div>
                            </div>
                            <div v-else>
                                <div v-if="currentStatus != 'Borrowed'">
                                    <div class="form-group">
                                        <label class="float-label">Status  <span v-if="errors.status" class="haveerror"> {{( errors.status )}}</span></label>
                                        <multiselect v-model="status" 
                                        :allow-empty="false"
                                        deselect-label="Can't remove"
                                        :options="statuses" 
                                        placeholder="Select Status" 
                                        label="name" track-by="id">
                                        </multiselect>
                                    </div>
                                    <div class="form-group" v-if="status.name == 'Borrowed'">
                                        <label class="float-label">Agencies<span v-if="errors.agency" class="haveerror"> {{( errors.agency )}}</span></label>
                                        <multiselect v-model="agency" id="ajax" label="name" track-by="name"
                                            placeholder="Search Agency" open-direction="bottom" :options="agencies"
                                            :searchable="true" 
                                            @search-change="asyncFind">
                                        </multiselect> 
                                    </div>
                                </div>
                                <div v-else>
                                    <div class="text-muted">
                                        <h5 class="mb-1"><span class="text-secondary font-size-11">Borrowed By:</span> {{code.name }}</h5>
                                        <p class="mb-0"><span class="text-secondary font-size-11">Date Borrowed:</span> {{code.created_at}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button  type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
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
                statuses: [],
                trackable : true,
                quantity : 1,
                id: '',
                type: '',
                text: '',
                trackercode: '',
                assetcode: '',
                status: '',
                agency: '',
                currentStatus: ''
            }
        },

        created(){
            this.fetchStatus();
        },

        methods : {
            set(id,type,text,data){
                this.id = id;
                this.type = type;
                this.text = text;

                if(data != undefined && type == 'Update'){
                    this.assetcode = data.asset;
                    this.trackercode = data.tracker;
                }else if(type == 'Quantity'){
                    
                }else{
                    this.currentStatus = data.name;
                    this.status = data;
                }
                $("#add").modal('show');
            },

            fetchStatus(){
                axios.get(this.currentUrl + '/request/dropdowns/status/asset')
                .then(response => {
                    this.statuses = response.data.data;;
                })
                .catch(err => console.log(err));
            },

            asyncFind(value) {
                if(value.length > 0){
                    axios.post(this.currentUrl + '/request/agency/search', {
                        keyword: value,
                    })
                    .then(response => {
                        this.agencies = response.data.data;
                    })
                    .catch(err => console.log(err));
                }else{
                    this.agencies = [];
                }
            },


            create(){
                if(this.type == 'Quantity'){
                    axios.post(this.currentUrl + '/request/member/quantity/update', {
                        id: this.id,
                        quantity: this.quantity,
                        trackable: this.trackable
                    })
                    .then(response => {
                        this.$emit('status', true);
                        Vue.$toast.success('<strong>Successfully Created</strong>', {
                            position: 'bottom-right'
                        });
                        this.clear();
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            this.errors = error.response.data.errors;
                        }else{
                            this.$emit('status', false);
                        }
                    });
                }else if(this.type == 'Update'){
                    axios.post(this.currentUrl + '/request/member/tracker/store', {
                        id: this.id,
                        trackercode: this.trackercode,
                        assetcode: this.assetcode
                    })
                    .then(response => {
                        // var index = this.lists.map(x => {
                        //     return x.id;
                        // }).indexOf(this.location_id);
        
                        // this.lists[index].tracker = response.data.data.tracker_code;
                        this.clear();
                        Vue.$toast.success('<strong>Successfully Updated</strong>', {
                            position: 'bottom-right'
                        });
                        this.$emit('status', true);
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            this.errors = error.response.data.errors;
                        }else{
                             this.$emit('status', false);
                        }
                    });
                }else{
                    axios.post(this.currentUrl + '/request/member/status/update', {
                        id: this.id,
                        status: this.status.id,
                        agency: this.agency.id
                    })
                    .then(response => {
                        this.clear();
                        Vue.$toast.success('<strong>Successfully Updated</strong>', {
                            position: 'bottom-right'
                        });
                        this.$emit('status', true);
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            this.errors = error.response.data.errors;
                        }else{
                            this.$emit('status', false);
                        }
                    });
                }
            },

            clear(){
                this.quantity = '';
                $("#add").modal('hide');
            },

            addup(val){
                if(val == 'add'){
                    this.quantity += 1;
                }else{
                    if(this.quantity > 1){
                    this.quantity -= 1;
                    }
                }
            },
        },  components: { Multiselect}
    }
</script>
