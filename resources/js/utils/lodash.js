import _ from "lodash";
import {createApp} from "vue";

export default {
  install(Vue) {
      const app = createApp({})
      app.config.globalProperties.$_ = _;
  }
};
