<template>
     <div class="modal-dialog modal-dialog-centered modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form class="form-horizontal" @submit.prevent="changepassword">
                <div class="modal-body">
                    <div class="customerform">
                        <div v-if="test1 != ''" class="alert alert-success" role="alert">
                            {{ test1 }}
                        </div>
                        <div class="form-group">
                            <label for="userpassword">Current Password <b v-if="test" style="color: red; font-size: 12px;"> ({{ test }})</b></label>
                            <input type="password" class="form-control" v-model="current_password" placeholder="Enter password">
                        </div>
                        <div class="form-group">
                            <label for="userpassword">New Password <b v-if="errors.password" style="color: red; font-size: 12px;"> ({{ errors.password[0] }})</b></label>
                            <input type="password" class="form-control" v-model="password" placeholder="Enter password">
                            <input type="password" class="form-control" v-model="password_confirmation" placeholder="Enter password" style="margin-top: 5px;">
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
        return{
            currentUrl: window.location.origin,
            errors: [],
            current_password : '',
            password : '',
            password_confirmation: '',
            test: '',
            test1: ''
        }
    },

    methods : {
        changepassword(){
            axios.post(this.currentUrl + '/request/user/password', {
                current_password: this.current_password,
                password: this.password,
                password_confirmation: this.password_confirmation,
            })
            .then(response => {
                if(response.data.success == "First Attempt"){
                    window.location.replace('/home');
                }else{
                    this.current_password = '';
                    this.password = '';
                    this.password_confirmation = '';
                    this.errors = [];
                    this.test = '';
                    this.test1 = response.data.success;
                     this.$parent.xsettings();
                }
            })
            .catch(error => {
                if (error.response.status == 422) {
                   this.errors = error.response.data.errors;
                } 
                
                if(error.response.status == 401){
                   this.test = error.response.data.error;
                }

                this.test1 = '';
            });
        }
    }
}
</script>