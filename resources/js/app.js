require('./bootstrap')
import dayjs from "dayjs";
import {createApp, h} from 'vue';
import "./global-components";
import {App, plugin, Head, Link} from '@inertiajs/inertia-vue3';
import {InertiaProgress} from '@inertiajs/progress'
import Notifications from 'vue3-vt-notifications'
import {Inertia} from '@inertiajs/inertia'
import vSelect from 'vue-select'
import i18n from "./locales/i18n";


const el = document.getElementById('app');
InertiaProgress.init();

const app = createApp(
    {
        title: title => title ? `${title} - Shoppies` : 'Shoppies',
        render: () => h(App, {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: name => require(`./Pages/${name}`).default
        })
    });

app.use(i18n)
app.use(Notifications)
app.component('v-select', vSelect)
app.component('InertiaHead', Head)
app.component('InertiaLink', Link)
app.config.globalProperties.$route = window.route;
app.provide('$route', window.route);
app.mixin({methods: {route: window.route}})
app.use(plugin).mount(el);
app.config.globalProperties.$h = {
    getInertiaRequest(url) {
        Inertia.visit(url)
    },
    formatCurrency(number, separator) {
        if (number) {
            let splitArray = number.toString().split('.')
            let decimalPart = ''
            if (splitArray.length > 1) {
                number = splitArray[0]
                decimalPart = '.' + splitArray[1]
            }
            let formattedNumber = number.toString().replace(/\D/g, "");
            let rest = formattedNumber.length % 3;
            let currency = formattedNumber.substr(0, rest);
            let thousand = formattedNumber.substr(rest).match(/\d{3}/g);

            if (thousand) {
                separator = rest ? separator ? separator : "," : "";
                currency += separator + thousand.join(",");
            }

            return currency + decimalPart + ' FCFA';
        } else {
            return ' FCFA';
        }
    },
    formatPrice(price) {
        if (!price) return '0 FCFA'
        return this.formatCurrency(price, ',')
    },

    truncate(str, n) {
        return (str.length > n) ? str.substr(0, n - 1) + '&hellip;' : str;
    },
    timeAgo(time) {
        let date = new Date(
            (time || "").replace(/-/g, "/").replace(/[TZ]/g, " ")
            ),
            diff = (new Date().getTime() - date.getTime()) / 1000,
            dayDiff = Math.floor(diff / 86400);

        if (isNaN(dayDiff) || dayDiff < 0 || dayDiff >= 31)
            return dayjs(time).format("MMMM DD, YYYY");

        return (
            (dayDiff === 0 &&
                ((diff < 60 && "just now") ||
                    (diff < 120 && "1 minute ago") ||
                    (diff < 3600 && Math.floor(diff / 60) + " minutes ago") ||
                    (diff < 7200 && "1 hour ago") ||
                    (diff < 86400 && Math.floor(diff / 3600) + " hours ago"))) ||
            (dayDiff === 1 && "Yesterday") ||
            (dayDiff < 7 && dayDiff + " days ago") ||
            (dayDiff < 31 && Math.ceil(dayDiff / 7) + " weeks ago")
        );
    },
};
