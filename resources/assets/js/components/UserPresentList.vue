<template>
    <h1>{{ present }}</h1>
</template>

<script>
    export default {
        name: "UserPresentList",
        props: ['present'],
        mounted () {
            console.log(this.present)
        }
    }
</script>

<style scoped>

</style>