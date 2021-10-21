<template>
    <div class="modal-dialog modal-dialog-centered modal" role="document" style="height: 300px; max-width: 600px;">
        <div class="modal-content">
            <div class="card-body">
                <div class="p-2">
                    <div class="text-center">

                        <div class="avatar-md mx-auto">
                            <div class="avatar-title rounded-circle bg-light">
                                <i :class="'bx bxs-alarm-exclamation bx-tada h1 mb-0 text-'+alert.event.setting.color"></i>
                            </div>
                        </div>
                        <div class="p-2 mt-4">
                            <h4>{{alert.event.device.station }}</h4>
                            <p class="mb-0">{{alert.event.device.address }}</p>
                            <span class="text-muted font-size-11">{{alert.event.device.type.name }}</span>
                            <hr>
                            <div class="row text-primary font-weight-bold">
                                <div class="col-sm-3">
                                    <h6 class="font-size-12"><i class="bx bx-barcode-reader mr-1 text-primary"></i> Accelerometer</h6> 
                                    <p class="mb-0">{{alert.event.aa.Accelerometer }}</p>
                                </div> 
                                <div class="col-sm-3">
                                    <h6 class="font-size-12"><i class="bx bx-code mr-1 text-primary"></i>Gyro</h6>
                                    <p class="mb-0">{{alert.event.aa.Gyro }}</p>
                                </div>
                                 <div class="col-sm-3">
                                    <h6 class="font-size-12"><i class="bx bx-water mr-1 text-primary"></i> Soil Moisture</h6> 
                                    <p class="mb-0">{{alert.event.aa.SoilMoisture }}</p>
                                </div> 
                                <div class="col-sm-3">
                                    <h6 class="font-size-12"><i class="bx bx-sun mr-1 text-primary"></i>Temperature</h6>
                                    <p class="mb-0">{{alert.event.aa.Temperature }}</p>
                                </div>
                            </div>
                            <hr>
                            <button @click="close" data-dismiss="modal" aria-label="Close"  type="button" class="btn btn-success w-lg waves-effect waves-light">Confirm</button>
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
                alert: {
                    event: {
                        setting: {},
                        aa: {},
                        device: {
                            type: {}
                        }
                    },
                },
            }
        },
        
        methods : {
            set(alert){
                this.alert = alert;
                $("#alert").modal("show");
            },

            close(){
                this.$emit('status', true);
            }
        }
    }
</script>
