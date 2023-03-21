<template>
    <home-header/>
    <slot/>
    <flash-message/>
    <main-footer/>
    <svg-icons/>
    <back-to-top/>
    <cart-canvas/>
    <canvas-menu/>
    <sign-in/>

</template>

<script>
import HomeHeader from "../Includes/home-header";
import MainFooter from "../Includes/main-footer";
import SvgIcons from "../Includes/svg-icons";
import BackToTop from "../Includes/back-to-top";
import CartCanvas from "../Includes/cart-canvas";
import CanvasMenu from "../Includes/canvas-menu";
import SignIn from "../Includes/sign-in";
import FlashMessage from "../Includes/FlashMessage";

export default {
    name: "MainLayout",
    components: {FlashMessage, SignIn, CanvasMenu, CartCanvas, BackToTop, SvgIcons, MainFooter, HomeHeader},
}
</script>

<style scoped>

</style>
