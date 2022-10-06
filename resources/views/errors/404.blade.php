@extends('admin.layout')

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    <section class="body-error error-inside">
        <div class="center-error">

            <div class="row">
                <div class="col-lg-8">
                    <div class="main-error mb-3">
                        <h2 class="error-code text-dark text-center font-weight-semibold m-0">404 <i class="fas fa-file"></i></h2>
                        <p class="error-explanation text-center">We're sorry, but the page you were looking for doesn't exist.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h4 class="text">Here are some useful links</h4>
                    <ul class="nav nav-list flex-column primary">
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-caret-right text-dark"></i> Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-caret-right text-dark"></i> User Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-caret-right text-dark"></i> FAQ's</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection