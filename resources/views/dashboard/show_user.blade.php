@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Aboute User') }}</div>
                </div>
                <div class="">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <img src="{{ asset('/public/images/'.$user->image) }}" width="100%">
                                </div>
                                <div class="col-sm-9">
                                    <div><h1>{{ $user->name }}</h1></div>
                                    <div><h4>{{ $user->email }}</h4></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container" style="margin-top: 28px;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('User Posts') }}</div>
                </div>
                @foreach($userPosts as $userPost)
                    <div class="" style="margin: 10px 0 0 0;">
                        <div class="card">
                            <div class="card-body">
                                <div class="" style="border-bottom: 1px solid black;">
                                    <p>{{ $userPost->updated_at->format('d-m-Y H:i:s') }}</p>
                                    <h4>{{ $userPost->title }}</h4>
                                </div>
                                <div>
                                    <p>
                                        {{\Illuminate\Support\Str::limit($userPost->body,100,'')}}
                                        @if (strlen( $userPost->body ) > 100)
                                            <span class="dots">...</span>
                                            <span class="more" style="display:none;">{{ substr($userPost->body, 100) }}</span><br>
                                            <button onclick="" class="myBtn">Read more</button>
                                        @endif
                                    </p>
                                    <img width="100%" height="300px"  src="{{ asset('public/images')}}/{{$userPost->image}}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
<script>
    $(document).ready(function () {
        $(".myBtn").on("click", function () {
            $(this).prevAll('.more:first').toggle();
            $(this).prevAll('.dots:first').toggle();
        });
    });
</script>
@endsection
