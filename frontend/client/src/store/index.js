import { createStore } from "vuex";
import { auth } from "./auth.module";
import { notification } from "./notification.module";
import { account } from "./account.module";
import { website } from "./website.module";
import { page } from "./page.module";
import { blog } from "./blog.module";

const store = createStore({
  modules: {
    auth,
    notification,
    account,
    website,
    page,
    blog
  },
});

export default store;
