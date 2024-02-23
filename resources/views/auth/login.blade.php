@extends('auth.layouts.app')

@section('css')
    <link href="{{ asset('css/customs/login.css') }}" rel="stylesheet">
@endsection

@section('content')
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100 px-4">
                    <div class="d-table-cell align-middle">
                        <div class="d-flex align-items-center justify-content-center mb-4">
                            {{-- <a href="{{ route('index') }}" class="logo"> --}}
                            <!-- <a href="#" class="logo">
                                <img src="{{ asset('images/logo.png') }}" alt="TiketBersama's Logo"
                                    class="app-logo img-fluid">
                            </a> -->
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-3">
                                    <form id="login-form" action="{{ route('login') }}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="title text-center mb-4">
                                            Login
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            <div
                                                class="custom-input-container d-flex flex-column flex-md-row align-items-start align-items-md-center w-100">
                                                <input type="text"
                                                    class="form-control @error('username') is-invalid @enderror"
                                                    type="text" name="username" id="username-input"
                                                    value="{{ old('username') }}" placeholder="Username">
                                            </div>
                                            <div class="invalid-feedback d-block invalid">
                                                @if ($errors->has('username'))
                                                    @foreach ($errors->get('username') as $message)
                                                        <div>
                                                            {{ $message }}
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <div
                                                class="custom-input-container right-icon d-flex flex-column flex-md-row align-items-start align-items-md-center w-100">
                                                <div
                                                    class="position-relative w-100 @error('password') is-invalid @enderror">
                                                    <input type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        name="password" id="password-input" placeholder="Password">
                                                    <div class="icon-container h-100 d-flex align-items-center">
                                                        <div class="d-flex flex-grow-1 align-items-center justify-content-center w-100 h-100 cursor-pointer"
                                                            id="toggle-password">
                                                            <i class="fas fa-eye"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback d-block invalid">
                                                @if ($errors->has('password'))
                                                    @foreach ($errors->get('password') as $message)
                                                        <div>
                                                            {{ $message }}
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="mt-5">
                                                <button type="submit" class='login-button w-100'
                                                    id="login-button">Login</button>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('js')
    <script>
        $(function() {
            $('#toggle-password').on('click', function() {
                const $passwordInput = $('#password-input');
                const $togglePassword = $('#toggle-password');
                const type = $passwordInput.attr('type');

                if (type === 'password') {
                    $passwordInput.attr('type', 'text');
                    $togglePassword.html('<i class="fas fa-eye-slash"></i>');
                } else {
                    $passwordInput.attr('type', 'password');
                    $togglePassword.html('<i class="fas fa-eye"></i>');
                }
            });
        });
    </script>
@endsection
