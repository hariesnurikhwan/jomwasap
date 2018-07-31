@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Login
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="name" name="name" class="form-control" value="{{ old('name') }}" required>
                            <small class="text-danger">{{ $errors->first('name') }}</small>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            <small class="text-danger">{{ $errors->first('email') }}</small>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" required>
                            <small class="text-danger">{{ $errors->first('password') }}</small>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                            <small class="text-danger">{{ $errors->first('password_confirmation') }}</small>
                        </div>
                        <div class="form-group">
                            <div class="float-right">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
