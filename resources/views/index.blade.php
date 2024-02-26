<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>


    <input type="text" id="success" value="{{ session('success')}}" readonly hidden>
    <input type="text" id="error" value="{{ session('error')}}" readonly hidden>
    <input type="text" id="csrf" value="{{ csrf_token() }}" readonly hidden>
    
    <div class="container">
        @foreach ($posts as $post)
        <div>
            <div class="title-div mt-5">
                <h2>{{ $post->title }}</h2>
                <small>{{ $post->description }}</small>
                <div>
                    <span class="btn like-btn" data-id="{{ $post->id }}">Like</span>
                    <!-- Button trigger modal -->
                    <span class="btn comment-model" data-bs-toggle="modal" data-bs-target="#commentModel" data-id="{{ $post->id }}">Comment</span>
                    </button>

                    
                </div>
                <div class="comment-div ms-3">
                    @foreach ($post->comment as $comment)
                        <small>{{ $comment->comment }}</small></br>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach


        <!-- Modal -->
        <div class="modal fade" id="commentModel" tabindex="-1" aria-labelledby="commentModelLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="commentModelLabel">Comment</h5>
                            <button type="button" class="btn-close comment-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="text" name="post_id" id="post_id" value="" hidden/>
                            <label>Enter Comment:</label>
                            <input type="text" name="comment" id="comment" placeholder="Comment Here.."/>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="color:black">Close</button>
                            <button type="button" class="btn btn-primary comment-btn" style="color:black">Save changes</button>
                        </div>
                        </div>
                    </div>
                    </div>
    </div>
</x-app-layout>


<script>
    $(document).ready(function() {
        $(".comment-btn").click(function() {
            let postid = $(this).attr('data-id');
            // let csrf=$('meta[name="csrf-token"]').attr('content');
            let csrf=$('#csrf').val();
            let comment=$('#comment').val();

            $.ajax({
                url: '/commentOnPost',
                method: 'POST',
                data: {
                    post: postid,
                    comment: comment,
                    _token: csrf
                },
                success: function(data) {
                    if (data.action == 'success') {
                        swal({
                            title: 'Alert',
                            text: data.msg,
                            type: 'success'
                        });
                        $('#comment').val("");
                    } else {
                        swal({
                            title: 'Alert',
                            text: data.msg,
                            type: 'error'
                        });
                    }
                }
            });
        });

        let myModal = $("#commentModel");
        $( ".comment-model" ).on( "click", function( e ) {
        // $(".comment-model").click(function(e) {
            e.preventDefault();
            let postid = $(this).attr('data-id');
            $("#post_id").val(postid);
            myModal.show();
        });


        // $(".comment-btn").click(function() {
        //     $('#comment').val("asd");
        // });

        // function clearComment(){
        //     $('#comment').val("");
        // }
    });
</script>