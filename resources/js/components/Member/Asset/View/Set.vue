<template>
    <div class="modal fade exampleModal" id="set" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{text}}</h5>
                </div>
                    
                <div class="row">
                    <div class="col-md-12" v-if="ids.length > 0">
                        <form  @submit.prevent="create">
                            <div class="modal-body customerform">
                                <div class="form-group form-primary">
                                    <label class="float-label" v-bind:style="errors.date ? 'color: red' : ''">Date</label>
                                    <input type="date" v-model="date" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button  type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12" v-else>
                        <div class="modal-body customerform">
                            <div class="alert alert-warning alert-dismissible fade show pt-4" role="alert">
                                <i class='bx bx-alarm-exclamation mr-2'></i> Please select at least one Asset.
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button  type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
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
                ids: [],
                type: '',
                text: '',
                date: ''
            }
        },

        methods : {
            set(ids,type,text){
                this.ids = ids;
                this.type = type;
                this.text = text;
                $("#set").modal('show');
            },

            create(){
                axios.post(this.currentUrl + '/request/member/asset/update', {
                    ids: this.ids,
                    date: this.date,
                    type: this.type
                })
                .then(response => {
                    this.$emit('status', true);
                    Vue.$toast.success('<strong>Successfully Created</strong>', {
                        position: 'bottom-right'
                    });
                    $("#set").modal('hide');
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }else{
                        this.$emit('status', false);
                    }
                });
            },

        },
    }
</script>
