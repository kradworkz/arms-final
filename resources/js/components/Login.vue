<template>
    <div class="modal-dialog modal-dialog-centered modal" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Login API</h5>
            </div>

            <div class="modal-body">
                
                <div class="card-body pt-0"> 
                    <div class="p-2 mt-4">
                        <form class="form-horizontal" @submit.prevent="login">
                            <div class="form-group">
                                <label for="userpassword">Username</label>
                                <input type="text" class="form-control" v-model="username" placeholder="Enter username">
                            </div>
                            <div class="form-group">
                                <label for="userpassword">Password</label>
                                <input type="password" class="form-control" v-model="password" placeholder="Enter password">
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-12 text-right">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Confirm</button>
                                    <a href="/requests" class="btn btn-warning waves-effect waves-light" type="button">Back</a>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
                
                <div class="mt-5 text-center">
                    <p>© 2021 ARMS. Crafted with <i class="mdi mdi-heart text-danger"></i> by Krad</p>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            currentUrl: window.location.origin,
            errors: [],
            username: '',
            password: ''
        }
    },

    methods : {
        login(){
            axios.post(this.currentUrl+'/krad/api/login', {
                username: this.username,
                password: this.password
            })
            .then(response => {
              
                if(response.data.code == 16){
                     Vue.$toast.error('<strong>Incorrect Credentials!</strong>', {
                        position: 'bottom-left'
                    });
                }else{
                    localStorage.setItem('api_token', response.data.jwt);
                    Vue.$toast.success('<strong>Login Successful!</strong>', {
                        position: 'bottom-left'
                    });
                    $("#loginapi").modal('hide');
                    this.$parent.check(true);
                }
            })
            .catch(error => {
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            });
        }
    }
}
</script>
