@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add your post') }}</div>
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
                <div class="card-body">
                    <form action="{{route('posts.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-1">
                                <img height="50" src="{{ asset('/public/images/'.$user_image) }}" width="40" alt="">
                            </div>
                            <div class="col-sm-11">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="" placeholder="post title" name="title">
                                    <span class="text-danger">@error('title'){{ $message }}@enderror</span>
                                </div>
                                <div class="form-group">
                                    <label for="body">Body</label>
                                    <textarea class="form-control" id="" rows="3" name="body" placeholder="what is on your mind"></textarea>
                                    <span class="text-danger">@error('body'){{ $message }}@enderror</span>
                                </div>
                                <div class="form-group">
                                    <label for="image">Upload Image</label>
                                    <input type="file" name="image" class="form-control" id="image"/>
                                    <span class="text-danger">@error('image'){{ $message }}@enderror</span>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-info" style="float: right">Add Post</button>
                    </form>
                </div>
            </div>
        </div>
        @foreach($posts as $post)
            <div class="col-md-8" style="margin: 28px 0 0 0;">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-1">
                                <img class="" height="60" src="{{ asset('/public/images/'.$post->user->image) }}" width="40" alt="">
                            </div>
                            <div class="">
                                <h3>{{ $post->user->name }}</h3>
                                <p>{{ $post->updated_at->format('d-m-Y H:i:s') }}</p>
                            </div>
                        </div>
                        <div class="" style="border-bottom: 1px solid black;">
                            <h4>{{ $post->title }}</h4>
                        </div>
                        <div>
                            <p>
                            {{\Illuminate\Support\Str::limit($post->body,100,'')}}
                            @if (strlen( $post->body ) > 100)
                                <span class="dots">...</span>
                                <span class="more" style="display:none;">{{ substr($post->body, 100) }}</span><br>
                                <button onclick="" class="myBtn">Read more</button>
                            @endif
                            </p>
                            <img width="100%" height="300px"  src="{{ asset('public/images')}}/{{$post->image}}" alt="">
                        </div>
                        <div style="padding-top: 20px;">
                            <a href="{{ route('user.show.post',$post->id) }}">
                                <button type="button" class="btn btn-light">See Post</button>
                            </a>
                            <div style="float: right">
                                @if(Auth::user()->role == 'admin' || Auth::id() == $post->user->id)
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to unenroll?');" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" class="btn btn-danger" value="Delete">
                                    </form>
                                    <a href="{{ route('posts.edit',$post->id) }}">
                                        <button type="button" class="btn btn-success">Edit</button>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".myBtn").on("click", function () {
            $(this).prevAll('.more:first').toggle();
            $(this).prevAll('.dots:first').toggle();
            // $(this).parent().children().eq(0).toggle()
            // $(this).parent().children().eq(1).toggle()
        });
    });
</script>
@endsection
