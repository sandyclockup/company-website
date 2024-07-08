<template>
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
    <div :id="`comment-reply-${comment.id}`" class="comment comment-reply">
        <template v-for="child in comments.filter(function(el) { return el.parent_id === comment.id; })" :key="child.id">
            <blog-comment-child :comment="child" :auth="auth" :user="user" :comments="comments" />
        </template>
    </div>
</template>
<script>
    import moment from "moment"
    import Swal from 'sweetalert2';
    export default {
        name: "blog-comment-child",
        props: ['comment', 'auth','comments', 'user'],
        methods: {
            convertDate(input){
                return moment(input).format("MMMM DD, Y HH:mm:ss");
            },
            replyData(id, event){
                event.preventDefault();
                this.$parent.$parent.setReply(id);
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
                            this.$parent.$parent.loadData();
                        })
                    }
                });
            }
        },
        data(){
            return {
                publicPath: process.env.VUE_APP_BASE_URL,
                backendPath: process.env.VUE_APP_BACKEND_URL
            }
        }
    }
</script>