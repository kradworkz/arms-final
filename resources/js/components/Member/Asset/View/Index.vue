<template>
    <div class="row">
        <div class="col-lg-12">
            <asset-header :assetId="assetid"></asset-header>
        </div>

        <div class="col-lg-12">
            <asset-body :assetId="assetid"></asset-body>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['assetid'],
        data(){
            return {

            }
        }
    }
</script>
