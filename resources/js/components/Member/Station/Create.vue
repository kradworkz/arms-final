<template>
   <div class="modal-dialog modal-dialog-centered modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{(this.editable) ? 'Update' : 'New'}} Station</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form @submit.prevent="createloc">
                <div class="modal-body">
                    <div class="row" style="margin-right: 10px; margin-left: 10px;">
                        
                        <div class="col-md-12 customerform" style="margin-top: 10px;">
                            <div class="row">
                                <div class="col-md-12" style="margin-bottom: -10px;">
                                    <div class="form-group">
                                        <label for="formrow-firstname-input">Name: <span v-if="errors.name" class="haveerror">({{ errors.name[0] }})</span></label>
                                        <input type="text" class="form-control" v-model="loc.name" style="text-transform: capitalize;">
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: -10px;"  >
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formrow-firstname-input">Address: <span v-if="errors.address" class="haveerror">({{ errors.address[0] }})</span></label>
                                        <input type="text" class="form-control" v-model="loc.address" style="text-transform: capitalize;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formrow-firstname-input">Contact no: <span v-if="errors.contact_no" class="haveerror">({{ errors.contact_no[0] }})</span></label>
                                        <input type="text" class="form-control" v-model="loc.contact_no" style="text-transform: capitalize;">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <label for="formrow-firstname-input">Coordinates: <span v-if="errors.coordinates" class="haveerror">({{ errors.coordinates[0] }})</span></label>
                                        <input type="text" class="form-control" v-model="loc.coordinates">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button @click="set" style="left:-20px; margin-top: 20px;" type="button" class="btn btn-danger btn-rounded waves-effect waves-light">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                loc: {
                    id: '',
                    name: '',
                    address: '',
                    contact_no: '',
                    coordinates: ''
                },
                editable: false
            }
        },

        methods : {

            createloc(){
                axios.post(this.currentUrl + '/request/member/location/store', {
                    id: this.loc.id,
                    name: this.loc.name,
                    address: this.loc.address,
                    contact_no: this.loc.contact_no,
                    coordinates: this.loc.coordinates,
                    editable: this.editable
                })
                .then(response => {
                    this.loc.name = '';
                    this.loc.address = '';
                    this.loc.contact_no = '';
                    this.loc.coordinates = '';
                    this.editable = false;
                    this.errors = [];
                    Vue.$toast.success('<strong>Successfully Created</strong>', {
                        position: 'bottom-right'
                    });
                    this.$emit('status', true);
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
            },
            
            set(){
               (this.editable) ? this.$parent.$parent.setForm(this.loc.coordinates) : this.$parent.$parent.setMap('location');
            },

            populate(latlang){
                this.loc.coordinates = latlang;
            },
            
            edit(location,editable){
                this.loc = location;
                this.editable = editable;
            }
        }
    }
</script>
