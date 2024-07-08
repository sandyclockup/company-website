<template>
  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Blog</h2>
          <ol>
            <li><router-link :to="{ name: 'Home'}">Home</router-link></li>
            <li>Blog</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Blog Section ======= -->
    <section id="blog" class="blog">
      <div class="container" data-aos="fade-up">

        <div class="row">

          <div v-if="loading" class="col-lg-8 entries text-center">
              <i class="spinner-border spinner-border-lg"></i>
          </div>
          <div v-else class="col-lg-8 entries">

             <article class="entry" v-for="article in articles" :key="article.id">

              <div class="entry-img">
                  <img v-if="article.image" :src="`${backendPath}/files/${article.image}`" alt="" class="img-fluid">
                  <img v-else src="http://via.placeholder.com/1024x768" alt="" class="img-fluid">
              </div>

              <h2 class="entry-title">
                <router-link :to="{ name: 'BlogRead', params: { slug: article.slug }}">
                  {{article.title}}
                </router-link>
              </h2>

              <div class="entry-meta">
                <ul>
                   <li class="d-flex align-items-center">
                      <i class="bi bi-person"></i> <a href="#">{{ getUserName(article) }}</a>
                   </li>
                   <li class="d-flex align-items-center">
                      <i class="bi bi-clock"></i> <a href="#"> <time :datetime="article.created_at">{{ convertDate(article.created_at) }}</time> </a>
                   </li>
                   <li class="d-flex align-items-center">
                      <i class="bi bi-chat-dots"></i> <a href="#"> {{ article.total_comments }} Comments </a>
                   </li>
                </ul>
              </div>

              <div class="entry-content">
                <p v-html="(article.content).substring(0, 500)"></p>
                <div class="read-more">
                  <router-link :to="{ name: 'BlogRead', params: { slug: article.slug }}">
                    Read More
                  </router-link>
                </div>
              </div>

            </article><!-- End blog entry -->

            <div class="blog-pagination">
                <paginate
                  :page-count="parseInt(total_data)"
                  :page-range="10"
                  :click-handler="loadData"
                  :prev-text="'Prev'"
                  :next-text="'Next'"
                  :container-class="'justify-content-center'"
                  :page-class="''"
                  :modelValue="page"
                >
                </paginate>
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
                        <a href="#" @click="filterByCategory(category.id)">{{ category.name }} <span>({{ category.total }})</span></a>
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
                        <a href="#" @click="filterByTag(tag.id)">{{ tag.name }}</a>
                      </li>
                  </template>
                </ul>
              </div><!-- End sidebar tags-->

            </div><!-- End sidebar -->

          </div><!-- End blog sidebar -->

        </div>

      </div>
    </section><!-- End Blog Section -->

  </main><!-- End #main -->
</template>
<script>
  
  import Swal from 'sweetalert2'
  import moment from "moment"
  import Paginate from "vuejs-paginate-next";


  export default {

    components: {
      paginate: Paginate,
    },
    
    methods: {

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
       
       filterByTag(id){
          this.tag = id;
          this.loadData(1);
       },

       filterByCategory(id){
          this.category = id;
          this.loadData(1);
       },

       filterByKey(){
          this.loadData(1)
       },

       loadData(page){

          this.loading = true;
          this.page = parseInt(page);

          var params = {}
          params["page"] = page;

          if(this.search){
            params["search"] = this.search;
          }

          if(this.tag){
            params["tag"] = this.tag;
          }

          if(this.category){
            params["category"] = this.category;
          }

          

          var queryString = Object.keys(params).map(key => key + '=' + params[key]).join('&');
         
          this.$store.dispatch("blog/articlePost", queryString).then((result) => {
              this.articles = result.data;
              this.total_data = result.total_data;
              this.loading = false;
              document.body.scrollTop = 0; // For Safari
              document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
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
       }

    },
    data() {
      return {
        publicPath: process.env.VUE_APP_BASE_URL,
        backendPath: process.env.VUE_APP_BACKEND_URL,
        loading: false,
        tags: [],
        categories: [],
        recentPost: [],
        articles: [],
        total_data: 100,
        page: 1,
        search: "",
        category: "",
        tag: ""
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

       this.loadData(1);
    }
  }
</script>