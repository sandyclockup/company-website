<template>
    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <section id="breadcrumbs" class="breadcrumbs">
            <div class="container">

                <div class="d-flex justify-content-between align-items-center">
                    <h2>Term Of services</h2>
                    <ol>
                        <li>
                            <router-link :to="{ name: 'Home'}">Home</router-link>
                        </li>
                        <li>Term Of services</li>
                    </ol>
                </div>

            </div>
        </section><!-- End Breadcrumbs -->

        <section id="about-us" class="about-us">
            <div class="container aos-init aos-animate" data-aos="fade-up">
                <div class="row content">
                    <div class="col-lg-12 aos-init aos-animate" v-html="config.config_term_of_service" data-aos="fade-right"></div>
                </div>
            </div>
        </section>


    </main><!-- End #main -->
</template>
<script>
    export default {
        data(){
            return {
                config: {}
            }
        },
        mounted() {
            if(localStorage.getItem('config')){
                let config = JSON.parse(localStorage.getItem('config'));
                this.config = config;
                document.title = "Term Of services | " + config.config_site_title
            }
        }
    }
</script>