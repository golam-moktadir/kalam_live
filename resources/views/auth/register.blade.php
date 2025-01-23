@extends('layouts.app')

@section('content')
<div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-floating mb-2">
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name='name' autocomplete="off" placeholder="" value="{{ old('Name') }}">
            <label for="name">Name </label>
        </div>
        @error('name')
            <div class="mb-4">
                <label class="form-check-label">{{ $message }}</label>
            </div>
        @enderror
        <div class="form-floating mb-2">
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name='email' placeholder="" autocomplete="off" value="{{ old('email') }}">
            <label for="email">Email address</label>
        </div>
        @error('email')
            <div class="mb-4">
                <label class="form-check-label">{{ $message }}</label>
            </div>
        @enderror
        <div class="form-floating mb-2">
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="">
            <label for="password">Password</label>
        </div>
        @error('password')
            <div class="mb-4">
                <label class="form-check-label">{{ $message }}</label>
            </div>
        @enderror
        <div class="form-floating mb-2">
            <input type="password" class="form-control" id="password-confirm" name="password_confirmation" placeholder="">
            <label for="password-confirm">Confirm Password</label>
        </div>
        <input type="submit" class="btn btn-primary py-3 w-100 mb-4" value="Sign Up" />
    </form>
    <p class="text-center mb-0">Already have an Account ? <a href="{{route('login') }}">Sign In</a></p>
</div>
@endsection
