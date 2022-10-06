<x-guest-layout>
    <x-jet-authentication-card>
        <section class="body-sign">
            <div class="center-sign">

                <div class="panel card-sign">
                    <div class="card-body">
                    <h2 class="login-title">Login</h2>
                        <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                            @csrf
                            <div class="form-custom-group">
                                <label for="email">{{ __('Email address') }} <span class="required">*</span></label>
                                <input name="email" id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" required autofocus />

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-custom-group">
                                <label class="float-left" for="password">{{ __('Password') }} <span class="required">*</span></label>
                                <input name="password" id="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" value="{{ old('password') }}" required />

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="row rem-password">
                                <div class="col-sm-8">
                                    <div class="checkbox-custom checkbox-default">
                                        <input class="checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="custom-label mb-0" for="remember">
                                            {{ __('Remember me') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    
                                    <a href="{{ route('password.request') }}" class="float-right forgot-psw">{{ __('Forgot Password?') }}</a>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-login btn-block">{{ __('LOGIN') }}</button>
                        </form>
                    </div>
                </div>

                <p class="text-center text-muted mt-3 mb-3">&copy; Copyright {{ date('Y') }}. All Rights Reserved.</p>
            </div>
        </section>
    </x-jet-authentication-card>
</x-guest-layout>
