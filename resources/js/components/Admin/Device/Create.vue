<template>
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Device Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form @submit.prevent="create">
                <div class="modal-body">
                    <div class="row" style="margin-right: 10px; margin-left: 10px;">
                        <div class="col-md-12 customerform" style="margin-top: 15px;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Station: <span v-if="errors.station" class="haveerror">({{ errors.station[0] }})</span></label>
                                        <input type="text" class="form-control" v-model="device.station" style="text-transform: capitalize;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Data Logger: <span v-if="errors.datalogger" class="haveerror">({{ errors.datalogger[0] }})</span></label>
                                        <input type="text" class="form-control" v-model="device.datalogger" style="text-transform: uppercase;">
                                    </div>
                                </div>
                                <div class="col-md-6" style="margin-top: -10px;">
                                    <label for="formrow-firstname-input">Type: <span v-if="errors.type" class="haveerror">({{ errors.type[0] }})</span></label>
                                    <multiselect 
                                        v-model="device.type" 
                                        :options="types"
                                        :allow-empty="false"
                                        :show-labels="false"
                                            placeholder="Select Province" 
                                        label="name" track-by="id"
                                        >
                                    </multiselect>
                                </div>
                                <div class="col-md-5" style="margin-top: -10px;">
                                    <div class="form-group">
                                        <label>Coordinates: <span v-if="errors.coordinates" class="haveerror">({{ errors.coordinates[0] }})</span></label>
                                        <input type="text" class="form-control" v-model="device.coordinates" style="text-transform: capitalize;">
                                    </div>
                                </div>
                                <div class="col-md-1" style="margin-top: -10px;">
                                    <button @click="set" style="left:-20px; margin-top: 20px;" type="button" class="btn btn-danger btn-rounded waves-effect waves-light">+</button>
                                </div>
                                <div class="col-md-6" style="margin-top: -10px;">
                                    <div class="row">
                                    
                                        <div class="col-md-12">
                                            <label for="formrow-firstname-input">Status: <span v-if="errors.status" class="haveerror">({{ errors.status[0] }})</span></label>
                                            <multiselect 
                                                v-model="device.status" 
                                                :options="statuses"
                                                :allow-empty="false"
                                                :show-labels="false"
                                                    placeholder="Select Status" 
                                                label="name" track-by="id"
                                                >
                                            </multiselect>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="formrow-firstname-input">Province: <span v-if="errors.province" class="haveerror">({{ errors.province[0] }})</span></label>
                                            <multiselect 
                                                v-model="device.province" 
                                                :options="provinces"
                                                :allow-empty="false"
                                                    :show-labels="false"
                                                @input="onChangeProvince(device.province.id)"
                                                placeholder="Select Province" 
                                                label="name" track-by="id"
                                                >
                                            </multiselect>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="formrow-firstname-input">Municipality: <span v-if="errors.municipality" class="haveerror">({{ errors.municipality[0] }})</span></label>
                                            <multiselect 
                                                v-model="device.municipality" 
                                                :options="municipalities"
                                                :allow-empty="false"
                                                :show-labels="false"
                                                placeholder="Select Municipality" 
                                                label="name" track-by="id"
                                                >
                                            </multiselect>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="float-label">Remarks <code style="color: red;" v-if="errors.remarks">({{ errors.remarks[0] }})</code></label>
                                        <textarea v-model="device.remarks" class="form-control" rows="6"></textarea>
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
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                types: [],
                statuses: [],
                provinces : [],
                municipalities: [],
                device :{
                    station : '',
                    datalogger: '',
                    remarks: '',
                    status: '',
                    municipality: '',
                    province: '',
                    type: '',
                    coordinates: '',
                },
                editable: false
            }
        },

        created(){
            this.fetchProvince();
            this.fetchType();
            this.fetchStatus();
        },

        methods : {
            fetchType(){
                axios.get(this.currentUrl + '/request/dropdowns/Device/-')
                .then(response => {
                    this.types = response.data.data;;
                })
                .catch(err => console.log(err));
            },

            fetchStatus(){
                axios.get(this.currentUrl + '/request/dropdowns/Status/Device')
                .then(response => {
                    this.statuses = response.data.data;;
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
                this.device.municipality = '';
            },

            create(){
                axios.post(this.currentUrl + '/request/admin/device/store', {
                    id: this.device.id,
                    station: this.device.station,
                    data_logger: this.device.datalogger,
                    remarks: this.device.remarks,
                    status_id: this.device.status.id,
                    municipality_id: this.device.municipality.id,
                    type_id: this.device.type.id,
                    coordinates: this.device.coordinates,
                    editable: this.editable
                })
                .then(response => {
                    this.$emit('status', true);
                    this.editable = false;
                    this.device = {};
                    $("#new").modal("hide");
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }else{
                        this.$emit('status', false);
                    }
                    
                });
            },

            set(){
               this.$parent.$parent.setMap('devices');
            },

            populate(latlang){
                this.device.coordinates = latlang;
            }
           
        }, components: { Multiselect }
    }
</script>