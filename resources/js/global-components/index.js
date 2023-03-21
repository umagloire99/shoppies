import {createApp} from "vue";
const app = createApp({});
app.component('ProductCard', ()=> import('./ProductCard'))
app.component('RatingWidget', () => import('./RatingWidget'))
app.component('UserLoadingButton', () => import('./UserLoadingButton'))
app.component('ShortCartItem', () => import('./ShortCartItem'))
