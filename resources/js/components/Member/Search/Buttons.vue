<template>
    <div class="col-md-6">
        <div class="form-inline float-right">
            <div v-if="user == 'Administrator'" data-toggle="tooltip" data-placement="bottom" data-original-title="Set Tracker Code">
                <button :disabled="(statuz == 'Disposed') ? true : false" @click="openModal('Code')" type="button" class="btn btn-light waves-light waves-effect mr-2">
                <i class='bx bx-code'></i>
                </button>
            </div>
             <div data-toggle="tooltip" data-placement="bottom" data-original-title="Track">
                <button :disabled="(statuz == 'Disposed') ? true : false" @click="track(asset.id,asset.coordinates)" type="button" class="btn btn-light waves-light waves-effect mr-2">
                <i class='bx bx-target-lock'></i>
                </button>
            </div>
            <!--<div v-if="user == 'Member'" data-toggle="tooltip" data-placement="bottom" data-original-title="Set Maintenance">
                <button :disabled="(statuz == 'Disposed') ? true : false" @click="openModal('Set Maintenance')" type="button" class="btn btn-light waves-light waves-effect mr-2">
                <i class='bx bxs-calendar-event'></i>
                </button>
            </div>-->
            <div v-if="user == 'Member'" data-toggle="tooltip" data-placement="bottom" data-original-title="Add Remarks">
                <button :disabled="(statuz == 'Disposed') ? true : false" @click="openModal('Remarks')" type="button" class="btn btn-light waves-light waves-effect mr-2">
                <i class='bx bx-spreadsheet'></i>
                </button>
            </div>  
            <div v-if="user == 'Member'" data-toggle="tooltip" data-placement="bottom" data-original-title="Maintenance">
                <button :disabled="(statuz == 'Disposed') ? true : false" @click="openModal('Maintenance')" type="button" class="btn btn-light waves-light waves-effect mr-2">
                <i class='bx bx-wrench'></i>
                </button>
            </div>
            <div v-if="user == 'Member'" data-toggle="tooltip" data-placement="bottom" data-original-title="Dispose">
                <button :disabled="(statuz == 'Disposed') ? true : false" @click="openModal('Dispose')" type="button" class="btn btn-light waves-light waves-effect mr-2">
                <i class='bx bx-trash'></i>
                </button>
            </div>
            <div data-toggle="tooltip" data-placement="bottom" data-original-title="Close">
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-light waves-light waves-effect  mr-2">
                <i class='bx bx-x-circle'></i>
                </button>
            </div>
        </div>
        <div class="modal fade exampleModal" id="openModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background: rgba(96,96,96,0.8); overflow: hidden;">
            <div class="modal-dialog modal-dialog-centered modal" role="document">
                <div class="modal-content">
                    <form  @submit.prevent="save">
                        <div class="modal-header">
                            <div class="col-md-6">
                                <h4>{{type}}</h4>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div v-if="type == 'Dispose'">
                                <div class="col-md-12">
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="bx bx-error-circle mr-2"></i>
                                        Please input "DISPOSE" to confirm.
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control" v-model="message">
                                    </div>
                                </div>
                            </div>
                            <div v-else-if="type == 'Maintenance'">
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <i class="bx bx-error-circle mr-2"></i>
                                    Are you sure you want to <span v-if="statuz == 'Maintenance'">stop</span><span v-else>start</span> maintenance?
                                </div>
                            </div>
                            <div v-else-if="type == 'Code'">
                                <div class="form-group">
                                    <label for="formrow-firstname-input">Tracker Code: <span v-if="errors.trackercode" class="haveerror">({{ errors.trackercode[0] }})</span></label>
                                    <input type="text" class="form-control" id="formrow-firstname-input" v-model="asset.tracker_code">
                                </div>
                            </div>
                            <div v-else>
                                <div class="form-group form-primary">
                                    <label class="float-label" v-bind:style="errors.date ? 'color: red' : ''">Date</label>
                                    <input type="date" v-model="asset.maintenance" class="form-control">
                                </div>
                            </div>
                             <div v-if="type == 'Remarks' || type == 'Dispose'">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea v-model="remarks" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" :disabled="status">Confirm</button>
                            <button type="button" class="btn btn-secondary" @click="close">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['statuz','asset','user'],
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                type: '',
                message: '',
                status: true,
                remarks: '',
                date: ''
            }            
        },

        watch : {
            message : function(){
                (this.message == 'DISPOSE') ? this.status = false : this.status = true;
            }
        },

        methods : {
            openModal(val){
                this.type = val;
                (val == 'Dispose') ? this.status = true : this.status = false;
                $("#openModal").modal('show');
            },

            save(){
                if(this.type == "Code"){
                    axios.post(this.currentUrl + '/request/member/tracker/store', {
                        id: this.asset.id,
                        trackercode: this.asset.tracker_code,
                        assetcode: this.asset.asset_code
                    })
                    .then(response => {
                        // var index = this.lists.map(x => {
                        //     return x.id;
                        // }).indexOf(this.location_id);
        
                        // this.lists[index].tracker = response.data.data.tracker_code;
                        // this.clear();
                        Vue.$toast.success('<strong>Successfully Updated</strong>', {
                            position: 'bottom-right'
                        });
                        // this.$emit('status', true);
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
                    
                }else{
                    axios.post(this.currentUrl + '/request/member/status/up', {
                        id: this.asset.id,
                        type: this.type,
                        remarks: this.remarks
                    })
                    .then(response => {
                        // console.log(response.data.data)
                        this.$emit('res',response.data.data)
                        // Vue.$toast.success('<strong>Successful</strong>', {
                        //     position: 'bottom-right'
                        // });
                        this.close();
                        this.remarks = '';
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
                }
            },

            track(id,coordinates){
                if(coordinates != 'n/a'){
                    this.$parent.$parent.$parent.trackMapId(id);
                }
            },

            close(){
                this.message = '';
                this.errors = [];
               $("#openModal").modal('hide');
            }
        }
    }
</script>