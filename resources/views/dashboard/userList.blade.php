@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('User List') }}</div>
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                </div>
            </div>
            @foreach($users as $user)
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-1">
                                <img class="" height="40" src="{{ asset('/public/images/'.$user->image) }}" width="40" alt="">
                            </div>
                            <div class="col-sm-2">
                                <a href="{{ route('user.show',$user->id) }}">
                                    <h3>{{ $user->name }}</h3>
                                </a>
                            </div>
                            <div class="col-sm-8">
                                <h4>{{ $user->email }}</h4>
                            </div>
                            <div class="col-sm-1">
                                @if(Auth::user()->role == 'admin' || Auth::id() == $user->id)
                                    <form action="{{ route('user.delete', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to unenroll?');" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" style="float: right">X</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
