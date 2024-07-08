import { createStore } from "vuex";
import { auth } from "./auth.module";
import { contact } from "./contact.module";
import { notification } from "./notification.module";
import { account } from "./account.module";
import { customer } from "./customer.module";
import { categoryArticle } from "./categoryArticle.module";
import { categoryPortfolio } from "./categoryPortfolio.module";
import { categoryTag } from "./categoryTag.module";
import { user } from "./user.module";
import { website } from "./website.module";
import { portfolio } from "./portfolio.module";
import { serve } from "./serve.module";
import { team } from "./team.module";
import { dashboard } from "./dashboard.module";
import { article } from "./article.module";
import { faq } from "./faq.module";
import { feature } from "./feature.module";
import { slider } from "./slider.module";
import { testimonial } from "./testimonial.module";
import { pricing } from "./pricing.module";
import { portfolioImage } from "./portfolioImage.module"
import { skill } from "./skill.module"

const store = createStore({
  modules: {
    auth,
    contact,
    notification,
    account,
    customer,
    categoryArticle,
    categoryPortfolio,
    categoryTag,
    user,
    website,
    portfolio,
    serve,
    team,
    dashboard,
    article,
    faq,
    skill,
    feature,
    slider,
    testimonial,
    pricing,
    portfolioImage
  },
});

export default store;
