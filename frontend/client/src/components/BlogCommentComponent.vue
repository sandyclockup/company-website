<template>
    <div :id="`comment${comment.id}`" class="comment">

        <div class="d-flex">
            <div class="comment-img">
                <img v-if="comment.image" :src="`${backendPath}/files/${comment.image}`" alt="" class="">
                <img v-else :src="`${publicPath}/img/user.png`" alt="" class="">
            </div>
            <div>
                <h5>
                    <a href="#">{{ comment.author_name }}</a> 
                    <a v-if="auth && comment.user_id !== user.id" href="#" @click="replyData(comment.id, $event)" class="reply" >
                        <i class="bi bi-reply-fill"></i> 
                    </a>
                </h5>
                <time :datetime="comment.created_at">{{ convertDate(comment.created_at) }}</time>
                <p>{{comment.comment}}</p>
                <div v-if="comment.user_id === user.id">
                    <button class="btn btn-sm btn-danger" @click="deleteData(comment.id)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>

        <template v-for="child in comments.filter(function(el) { return el.parent_id === comment.id; })" :key="child.id">
            <div :id="`comment-reply-${child.id}`" class="comment comment-reply">
                <BlogCommentChildComponent :comment="child" :auth="auth" :comments="comments" :user="user" />
            </div>   
        </template>

    </div><!-- End comment #1 -->
</template>
<script>
    import moment from "moment"
    import BlogCommentChildComponent from "../components/BlogCommentChildComponent.vue"
    import Swal from 'sweetalert2';
    export default {
        components: {
            BlogCommentChildComponent
        },
        props: ['comment', 'auth','comments'],
        methods: {
            convertDate(input){
                return moment(input).format("MMMM DD, Y HH:mm:ss");
            },
            replyData(id, event){
                event.preventDefault();
                this.$parent.setReply(id);
                window.scrollTo(0, document.body.scrollHeight);
            },
            deleteData(id){
                Swal.fire({
                    title: 'Confirmation',
                    text: 'Are you sure you want to delete this item  ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.$store.dispatch("blog/articleCommentDelete", id).then(() => {
                            Swal.fire(
                                'Delete Success',
                                'Your item has been deleted!',
                                'success'
                            )
                            this.$parent.loadData();
                        })
                    }
                });
            }
        },
        data(){
            return {
                publicPath: process.env.VUE_APP_BASE_URL,
                backendPath: process.env.VUE_APP_BACKEND_URL,
                user: {}
            }
        },
        mounted(){
             this.$store.dispatch("account/profile").then((result) => {
                this.user = result.data.user;
            })
        }
    }
</script>