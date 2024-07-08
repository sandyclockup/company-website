import axios from 'axios';

class PageService {

    contact(data) {
        return axios
          .post(process.env.VUE_APP_BACKEND_URL + '/page/guest/contact', data)
          .then(response => { return response.data; });
    }

    newsletter(data) {
        return axios
          .post(process.env.VUE_APP_BACKEND_URL + '/page/guest/newsletter', data)
          .then(response => { return response.data; });
    }

    content() {
        return axios
          .get(process.env.VUE_APP_BACKEND_URL + '/page/guest/content')
          .then(response => { return response.data; });
    }

    slider() {
        return axios
          .get(process.env.VUE_APP_BACKEND_URL + '/page/guest/slider')
          .then(response => { return response.data; });
    }

    feature() {
        return axios
          .get(process.env.VUE_APP_BACKEND_URL + '/page/guest/feature')
          .then(response => { return response.data; });
    }

    service() {
        return axios
          .get(process.env.VUE_APP_BACKEND_URL + '/page/guest/service')
          .then(response => { return response.data; });
    }

    customer() {
        return axios
          .get(process.env.VUE_APP_BACKEND_URL + '/page/guest/customer')
          .then(response => { return response.data; });
    }

    team() {
        return axios
          .get(process.env.VUE_APP_BACKEND_URL + '/page/guest/team')
          .then(response => { return response.data; });
    }

    skill() {
        return axios
          .get(process.env.VUE_APP_BACKEND_URL + '/page/guest/skill')
          .then(response => { return response.data; });
    }

    testimonial() {
        return axios
          .get(process.env.VUE_APP_BACKEND_URL + '/page/guest/testimonial')
          .then(response => { return response.data; });
    }

    portfolio() {
        return axios
          .get(process.env.VUE_APP_BACKEND_URL + '/page/guest/portfolio')
          .then(response => { return response.data; });
    }

    portfolioDetail(id) {
        return axios
          .get(process.env.VUE_APP_BACKEND_URL + '/page/guest/portfolio/'+id)
          .then(response => { return response.data; });
    }

    pricing() {
        return axios
          .get(process.env.VUE_APP_BACKEND_URL + '/page/guest/pricing')
          .then(response => { return response.data; });
    }

    faq() {
        return axios
          .get(process.env.VUE_APP_BACKEND_URL + '/page/guest/faq')
          .then(response => { return response.data; });
    }

}

export default new PageService();
