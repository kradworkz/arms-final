<template>
    <div class="row">
        <div class="col-lg-8">
            <home-left></home-left>
        </div>
        <div class="col-lg-4">
            <home-right></home-right>
        </div>
        <div class="col-lg-12">
            <home-bottom></home-bottom>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                keyword: '',
            }
        }
    }   
</script>
