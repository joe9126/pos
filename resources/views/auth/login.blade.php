
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>POS - Login</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    
    @vite(['resources/sass/login.scss', 'resources/js/login.js'])
</head>
<body>
    <div class="container-fluid mx-auto">
    <div class="row bg-primary ">
        <div class="col-md-8 bg-black ">
            <!--Image background -->
        </div>
        <div class="col-md-4 bg-primary py-4">        
          <div class="d-flex align-items-center justify-content-center">
            <div class="card loginform">
                
                <div class="card-body">
                    <h3 class="text-center pb-3">Welcome back!</h3>
                    <form method="POST" action="{{ route('login') }}" >
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-primary text-white">@</span>
                                    <div class="form-floating">
                                      <input id="email" type="email" placeholder="Email Address" class="form-control login-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                      <label for="email">Email address</label>
                                      @error('email')
                                       <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                           
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-key"></i>
                                    </span>
                                    <div class="form-floating">
                                <input id="password" type="password" placeholder="Password" class="form-control login-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                <label for="password">Password</label>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-12 ">
                                <button type="submit" class="btn btn-primary btn-block w-100 " id="loginbtn" disabled>
                                    {{ __('Login') }} <i class="fa-solid fa-right-to-bracket"></i>
                                </button>

                                @if (Route::has('password.request'))
                                    <div class="text-left">
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    </div>
                                    
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>