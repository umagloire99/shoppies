import {createI18n} from "vue3-i18n";
import Locales from "./translations";
import dateTimeFormats from "./date-time-formats";
import numberFormats from "./number-formats";

const i18n = createI18n({
    legacy: false,
    locale: window.default_locale || "fr",
    fallbackLocale: window.fallback_locale || "fr",
    messages: Locales,
    dateTimeFormats,
    numberFormats
})

export default i18n;
