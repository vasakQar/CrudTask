@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 28px;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Post') }}</div>
                </div>
                <div class="" style="margin: 10px 0 0 0;">
                    <div class="card">
                        <div class="card-body">
                            <div class="" style="border-bottom: 1px solid black;">
                                <p>{{ $post->updated_at->format('d-m-Y H:i:s') }}</p>
                                <h4>{{ $post->title }}</h4>
                            </div>
                            <div>
                                <p>
                                    {{\Illuminate\Support\Str::limit($post->body,100,'')}}
                                    @if (strlen( $post->body ) > 100)
                                        <span id="dots">...</span>
                                        <span id="more" style="display:none;">{{ substr($post->body, 100) }}</span><br>
                                        <button onclick="myFunction()" id="myBtn">Read more</button>
                                    @endif
                                </p>
                                <img width="100%" height="300px"  src="{{ asset('public/images')}}/{{$post->image}}" alt="">
                            </div>
                            <div style="padding-top: 20px;">
                                <a href="{{ route('home',$post->id) }}">
                                    <button type="button" class="btn btn-light">Go Back</button>
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
            </div>
        </div>
    </div>
    <script>
        function myFunction() {
            var dots = document.getElementById("dots");
            var moreText = document.getElementById("more");
            var btnText = document.getElementById("myBtn");

            if (dots.style.display === "none") {
                dots.style.display = "inline";
                btnText.innerHTML = "Read more";
                moreText.style.display = "none";
            } else {
                dots.style.display = "none";
                btnText.innerHTML = "Read less";
                moreText.style.display = "inline";
            }
        }
    </script>
@endsection
