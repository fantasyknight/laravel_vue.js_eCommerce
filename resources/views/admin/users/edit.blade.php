@extends('admin.layout')

@section('vendor-css')
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/select2-bootstrap-theme/select2-bootstrap.min.css') }}" />
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Edit User', 'paths' => ['home' => '/dashboard', 'Users' => '/users']])
    
    <user-detail-component :user="{{ $user }}" :is-admin="{{ Auth::user()->role_id == 7 ? 1 : 0 }}" :roles="{{ $roles }}" :multivendor="{{ config('setting.multivendor') }}"></user-detail-component>

    @include('admin.common.modals.delete-confirm')
@endsection

@section('vendor-js')
@endsection

@section('page-js')
    <script src="{{ asset('server/js/users/edit.min.js') }}"></script>
@endsection