<template>
    <!-- ======= Hero Section ======= -->
    <section id="hero">
        <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">

            <div class="carousel-inner" role="listbox">
                <div v-for="(slider, index) in sliders" :key="slider.id">
                    <div :class="index === 0 ? 'carousel-item active': 'carousel-item'" :id="`slider${slider.id}`" :style="slider.image ? `background-image: url(${backendPath+`/files/`+slider.image});` : `background-image: url('http://via.placeholder.com/1024x768');`">
                        <div class="carousel-container">
                            <div class="carousel-content animate__animated animate__fadeInUp">
                                <h2>{{slider.title}}</h2>
                                <p>{{slider.description}}</p>
                                <div class="text-center"><a :href="slider.link" class="btn-get-started">Read More</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
            </a>

            <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
            </a>

            <ol class="carousel-indicators" id="hero-carousel-indicators">
                <li v-for="(slider, index) in sliders" :key="slider.id" data-bs-target='#heroCarousel' :data-bs-slide-to="index" :class="index === 0 ? 'active': ''"></li>
            </ol>

        </div>
    </section><!-- End Hero -->
</template>

<script>

    import * as Bootstrap from 'bootstrap'
    import Swal from 'sweetalert2'

    export default {

        data () {
            return {
                publicPath: process.env.VUE_APP_BASE_URL,
                backendPath: process.env.VUE_APP_BACKEND_URL,
                sliders: []
            }
        },

        methods: {
            select: function(el, all = false){
                el = el.trim()
                if (all) {
                    return [...document.querySelectorAll(el)]
                } else {
                    return document.querySelector(el)
                }
            }
        },

        mounted() {
            this.$store.dispatch("page/slider").then((result) => {
                this.sliders = result.data;
                var myCarousel = document.querySelector('#heroCarousel')
                new Bootstrap.Carousel(myCarousel)
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
        },
    }
</script>