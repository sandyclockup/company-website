<template>
  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Blog Single</h2>
          <ol>
            <li><router-link :to="{ name: 'Home'}">Home</router-link></li>
            <li><router-link :to="{ name: 'Blog'}">Blog</router-link></li>
            <li>Blog Details</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Blog Single Section ======= -->
    <section id="blog" class="blog">
      <div class="container" data-aos="fade-up">

        <div class="row">

          <div class="col-lg-8 entries">

            <article class="entry entry-single">

              <div class="entry-img">
                <img v-if="article.image" :src="`${backendPath}/files/${article.image}`" alt="" class="img-fluid">
                <img v-else src="http://via.placeholder.com/1024x768" alt="" class="img-fluid">
              </div>

              <h2 class="entry-title">
                <a href="#">{{ article.title }}</a>
              </h2>

              <div class="entry-meta">
                 <ul>
                   <li class="d-flex align-items-center">
                      <i class="bi bi-person"></i> <a href="#">{{ getUserName(author) }}</a>
                   </li>
                   <li class="d-flex align-items-center">
                      <i class="bi bi-clock"></i> <a href="#"> <time :datetime="article.created_at">{{ convertDate(article.created_at) }}</time> </a>
                   </li>
                   <li class="d-flex align-items-center">
                      <i class="bi bi-chat-dots"></i> <a href="#"> {{ comments.length }} Comments </a>
                   </li>
                </ul>
              </div>

              <div class="entry-content" v-html="article.content"></div>

              <div class="entry-footer">
                <i class="bi bi-folder"></i>
                <ul class="tags">
                  <li v-for="category in article_categories" :key="category.id"><a href="#">{{ category.name }}</a></li>
                </ul>
                &nbsp;
                <i class="bi bi-tags"></i>
                <ul class="tags">
                  <li v-for="tag in article_tags" :key="tag.id"><a href="#">{{ tag.name }}</a></li>
                </ul>
              </div>

            </article><!-- End blog entry -->

            <div class="blog-author d-flex align-items-center">

              <img v-if="author.image" :src="`${backendPath}/files/${author.image}`" alt="" class="rounded-circle float-left">
              <img v-else :src="`${publicPath}/img/user.png`" alt="" class="rounded-circle float-left">

              <div>
                <h4>{{ getUserName(author) }}</h4>
                <div class="social-links">
                  <a :href="author.twitter"><i class="bi bi-twitter"></i></a>
                  <a :href="author.facebook"><i class="bi bi-facebook"></i></a>
                  <a :href="author.instagram"><i class="biu bi-instagram"></i></a>
                </div>
                <p>
                   {{author.about_me}}
                </p>
              </div>
            </div><!-- End blog author bio -->

            <div class="blog-comments" id="comment-section">
                <h4 class="comments-count">{{ comments.length }} Comments</h4>
                <template v-for="comment in comments_parents" :key="comment.id">
                    <BlogCommentComponent :comment="comment" :comments="comments" :auth="auth" />
                </template>
                <div v-if="auth" class="reply-form">
                  <h4>Leave a Reply</h4>
                  <p>Required fields are marked * </p>
                   <Form  @submit="handleSubmit" :validation-schema="schema" class="php-email-form">
                    <div class="row">
                      <div class="col form-group">
                         <Field name="comment" v-slot="{ field, errors}">
                            <textarea v-bind="field" rows="4" placeholder="Your Comment" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'"></textarea>
                          </Field>
                          <ErrorMessage name="comment" class="error invalid-feedback" />
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary" :disabled="loading">
                        <span v-if="loading">
                          <i class="spinner-border spinner-border-sm me-2"></i> Post Comment
                      </span>
                      <span v-else>
                        Post Comment
                      </span>
                    </button>
                  </form>
                </div>
            </div>

          </div><!-- End blog entries list -->

          <div class="col-lg-4">

              <div class="sidebar">

              <h3 class="sidebar-title">Search</h3>
              <div class="sidebar-item search-form">
                <form onsubmit="return false;">
                  <input type="text" v-model="search">
                  <button type="submit" @click="filterByKey"><i class="bi bi-search"></i></button>
                </form>
              </div><!-- End sidebar search formn-->

              <h3 class="sidebar-title">Categories</h3>
              <div class="sidebar-item categories">
                <ul>
                  <template v-for="category in categories" :key="category.id">
                     <li>
                        <a href="#">{{ category.name }} <span>({{ category.total }})</span></a>
                      </li>
                  </template>
                </ul>
              </div><!-- End sidebar categories-->

              <h3 class="sidebar-title">Recent Posts</h3>
              <div class="sidebar-item recent-posts">
                <div class="post-item clearfix" v-for="row in recentPost" :key="row.id">
                    <img v-if="row.image" :src="`${backendPath}/files/${row.image}`" alt="" >
                    <img v-else src="http://via.placeholder.com/1024x768" alt="">
                    <h4>
                      <router-link :to="{ name: 'BlogRead', params: { slug: row.slug }}">
                        {{row.title}}
                      </router-link>
                    </h4>
                    <time :datetime="row.created_at">{{ convertDate(row.created_at) }}</time>
                </div>
              </div><!-- End sidebar recent posts-->

              <h3 class="sidebar-title">Tags</h3>
              <div class="sidebar-item tags">
                <ul>
                  <template v-for="tag in tags" :key="tag.id">
                     <li>
                        <a href="#">{{ tag.name }}</a>
                      </li>
                  </template>
                </ul>
              </div><!-- End sidebar tags-->

            </div><!-- End sidebar -->

          </div><!-- End blog sidebar -->

        </div>

      </div>
    </section><!-- End Blog Single Section -->

  </main><!-- End #main -->
</template>
<script>
  
  import Swal from 'sweetalert2'
  import moment from "moment"
  import BlogCommentComponent from "../components/BlogCommentComponent.vue"
  import { Form, Field, ErrorMessage } from "vee-validate";
  import * as yup from "yup";

  export default {

    components: {
      BlogCommentComponent,
      Form,
      Field,
      ErrorMessage,
    },

    methods: {

      setReply(parent){
          this.parent_id = parent;
      },

      getUserName(elem){
         if(elem.full_name){
            return elem.full_name;
         }else if(elem.nick_name){
            return elem.nick_name;
         }else{
            return elem.username;
         }
      },
      
      convertDate(input){
        return moment(input).format("MMMM DD, Y HH:mm:ss");
      },

      loadData(){
          this.$store.dispatch("blog/articleRead", this.$route.params.slug).then((result) => {
            let comments = result.data.comments;
            let comments_parents = comments.filter(function(el) { return !el.parent_id; });
            this.article = result.data.article;
            this.author = result.data.author;
            this.article_categories = result.data.categories;
            this.article_tags = result.data.tags;
            this.comments = result.data.comments;
            this.comments_parents = comments_parents;
          },
          (error) => {
            this.message =
              (error.response &&
                error.response.data &&
                error.response.data.message) ||
              error.message ||
              error.toString();
            Swal.fire('Sorry, something went wrong', this.message, 'error');
          }
        );  
      },

      handleSubmit(data, { resetForm }) {
              Swal.fire({
                title: 'Confirmation',
                text: 'Do you really want to submit the form ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.formSubmit(data)
                    resetForm();
                }
            });    
        },
        formSubmit(data){
            let id = this.article.id;

            if(this.parent_id){
              data["parent_id"] = this.parent_id;
            }

            this.loading = true;
            this.$store.dispatch("blog/articleCommentCreate", { id, data }).then((result) => {
                this.loading = false;
                this.message = result.message;
                Swal.fire('Success', this.message, 'success');
                this.loadData();
            },
            (error) => {
                this.loading = false;
                this.message =
                    (error.response &&
                    error.response.data &&
                    error.response.data.message) ||
                    error.message ||
                    error.toString();

                    Swal.fire('Sorry, something went wrong', this.message, 'error');
                }
            );
        }

    },
    data() {
      const schema = yup.object().shape({
          comment: yup.string().min(8).required("Comment is required!"),
      });
      return {
        auth: false,
        publicPath: process.env.VUE_APP_BASE_URL,
        backendPath: process.env.VUE_APP_BACKEND_URL,
        loading: false,
        tags: [],
        categories: [],
        recentPost: [],
        comments: [],
        comments_parents: [],
        search: "",
        category: "",
        tag: "",
        article: {},
        author: {},
        article_categories: [],
        article_tags: [],
        parent_id:"",
        schema
      }
    },
    mounted() {
     if(localStorage.getItem('config')){
        let config = JSON.parse(localStorage.getItem('config'));
        document.title = "Blog | " + config.config_site_title
      }

      this.$store.dispatch("blog/articleCategory").then((result) => {
          this.categories = result.data;
        },
        (error) => {
          this.message =
            (error.response &&
              error.response.data &&
              error.response.data.message) ||
            error.message ||
            error.toString();
          Swal.fire('Sorry, something went wrong', this.message, 'error');
        }
      );

      this.$store.dispatch("blog/articleTag").then((result) => {
           this.tags = result.data;
        },
        (error) => {
          this.message =
            (error.response &&
              error.response.data &&
              error.response.data.message) ||
            error.message ||
            error.toString();
          Swal.fire('Sorry, something went wrong', this.message, 'error');
        }
      );

      this.$store.dispatch("blog/articlePost", "limit=5").then((result) => {
           this.recentPost = result.data;
        },
        (error) => {
          this.message =
            (error.response &&
              error.response.data &&
              error.response.data.message) ||
            error.message ||
            error.toString();
          Swal.fire('Sorry, something went wrong', this.message, 'error');
        }
      );

      let user = JSON.parse(localStorage.getItem('user'));
      if(user){ this.auth = true; }
      
      this.loadData();
    }
  }
</script>