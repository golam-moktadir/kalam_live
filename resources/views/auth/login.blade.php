@extends('layouts.app')

@section('content')
<div class="col-6 col-lg-4 col-lg-3">
  <div class="card">
    <img src="{{asset('build/assets/img/logo.jpg')}}" class="card-img-top">
    <h5 class="card-header text-center text-secondary">Samit Enterprise</h5>
    <div class="card-body">
        <form method="POST" action="{{ url('login') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="d-grid">
          <input type="submit" class="btn btn-success" value="Login" />
        </div>
      </form>
    </div>
  </div>
</div>
@endsection