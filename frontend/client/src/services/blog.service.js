import axios from 'axios';
import authHeader from './auth-header';

class BlogService {

    articleCategory(){
        return axios
            .get(process.env.VUE_APP_BACKEND_URL + '/blog/article/category')
            .then(response => { return response.data; });
    }

    articleTag(){
        return axios
            .get(process.env.VUE_APP_BACKEND_URL + '/blog/article/tag')
            .then(response => { return response.data; });
    }

    articlePost(params){
        return axios
            .get(process.env.VUE_APP_BACKEND_URL + '/blog/article/post?'+params)
            .then(response => { return response.data; });
    }

    articleRead(slug){
        return axios
            .get(process.env.VUE_APP_BACKEND_URL + '/blog/article/read/'+slug)
            .then(response => { return response.data; });
    }

    articleCommentCreate(id, data){
        return axios
            .post(process.env.VUE_APP_BACKEND_URL + '/blog/article/comment/'+id, data, { headers: authHeader() })
            .then(response => { return response.data; });
    }

    articleCommentDelete(id){
        return axios
            .delete(process.env.VUE_APP_BACKEND_URL + '/blog/article/comment/'+id, { headers: authHeader() })
            .then(response => { return response.data; });
    }

}

export default new BlogService();