import {createApp} from "vue";
const app = createApp({});
import Helper from "./helper";
import Lodash from "./lodash";

app.use(Helper);
app.use(Lodash);
