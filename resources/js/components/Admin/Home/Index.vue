<template>
    <div class="row">
        <div class="col-lg-8">
            <admin-home-left></admin-home-left>
        </div>
        <div class="col-lg-4">
            <admin-home-right></admin-home-right>
        </div>
        <div class="col-lg-12">
            <admin-home-bottom></admin-home-bottom>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            errors: [],
        }
    },

    created(){

    },

    methods : {

    }
}
</script>