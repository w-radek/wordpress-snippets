<template>
    <div class="form" v-html="form"></div>
</template>

<script>
export default {
    name: "Contactform",
    data() {
        return {
            form: null
        }
    },
    mounted() {
        console.log('ok');
        this.form = sharedData['contactForm'];
    }
}
</script>

<style scoped>

</style>