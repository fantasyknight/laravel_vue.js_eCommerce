<x-guest-layout>
    <x-jet-authentication-card>
        <section class="body-sign">
            <div class="center-sign">
                <a href="/" class="logo float-left">
                    <img src="{{ asset('server/images/logo.png') }}" height="54" alt="Porto Admin" />
                </a>

                <div class="panel card-sign">
                    <div class="card-title-sign mt-3 text-right">
                        <h2 class="title text-uppercase font-weight-bold m-0"><i class="fas fa-user mr-1"></i> Recover Password</h2>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="alert alert-info">
                            <p class="m-0">Enter your e-mail below and we will send you reset instructions!</p>
                        </div>

                        <form method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}">
                            @csrf
                            <div class="form-group mb-0">
                                <div class="input-group">
                                    <input name="email" type="email" id="email" placeholder="E-mail" class="form-control form-control-lg{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" required />
                                    <span class="input-group-append">
                                        <button class="btn btn-primary btn-lg" type="submit">Reset!</button>
                                    </span>
                                </div>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <p class="text-center mt-3">Remembered? <a href="{{ route('login') }}">Sign In!</a></p>
                        </form>
                    </div>
                </div>

                <p class="text-center text-muted mt-3 mb-3">&copy; Copyright {{ date('Y') }}. All Rights Reserved.</p>
            </div>
        </section>
    </x-jet-authentication-card>
</x-guest-layout>
