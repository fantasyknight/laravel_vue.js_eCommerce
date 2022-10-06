@extends('admin.layout')

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Edit Attribute', 'paths' => ['home' => '/dashboard', 'products' => '/products', 'attributes' => '/products/attributes']])

    
    <form class="ecommerce-form " action="{{ url('/admin/products/attributes/'.$attribute->id) }}" method="post">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col">
                <section class="card card-modern card-big-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2-5 col-xl-1-5">
                                <i class="card-big-info-icon bx bx-analyse"></i>
                                <h2 class="card-big-info-title">Attribute</h2>
                                <p class="card-big-info-desc">Add here the customer billing info with all details and necessary information.</p>
                            </div>
                            <div class="col-lg-3-5 col-xl-4-5">
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Attribute Name</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="text" maxlength="20" class="form-control form-control-modern" name="name" value="{{ $attribute->name }}" required />
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Slug</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="text" maxlength="20" class="form-control form-control-modern" name="slug" value="{{ $attribute->slug }}" />
                                    </div>
                                </div>
                                <div class="form-group row align-items-cneter">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Default sort order</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <select class="form-control form-control-modern w-auto" name="sort_by">
                                            <option value="custom_ordering" {{ $attribute->sort_by == 'custom_ordering' ? 'selected' : '' }}>Custom Ordering</option>
                                            <option value="name" {{ $attribute->sort_by == 'name' ? 'selected' : '' }}>Name</option>
                                            <option value="name_numeric" {{ $attribute->sort_by == 'name_numeric' ? 'selected' : '' }}>Name (numeric)</option>
                                            <option value="term_id" {{ $attribute->sort_by == 'term_id' ? 'selected' : '' }}>Term ID</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="row action-buttons">
            <div class="col-12 col-md-auto">
                <button type="submit" class="submit-button btn btn-primary btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1" data-loading-text="Loading...">
                    <i class="bx bx-save text-4 mr-2"></i> Save Attribute
                </button>
            </div>
            <div class="col-12 col-md-auto px-md-0 mt-3 mt-md-0">
                <a href="{{ url('/admin/products/attributes') }}" class="cancel-button btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark line-height-1 d-flex h-100 align-items-center">Back</a>
            </div>
            <div class="col-12 col-md-auto ml-md-auto mt-3 mt-md-0">
                <a href="#delete-confirm-modal" class="delete-button btn btn-danger btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1" data-id="{{ $attribute->id }}">
                    <i class="bx bx-trash text-4 mr-2"></i> Delete Attribute
                </a>
            </div>
        </div>
    </form>

    @include('admin.common.modals.delete-confirm')
@endsection

@section('vendor-js')
    <script src="{{ asset('vendor/ios7-switch/ios7-switch.js') }}"></script>
@endsection

@section('page-js')
    <script src="{{ asset('server/js/products/attributes/edit.min.js') }}"></script>
@endsection

@if( $errors->has('slug') )
    @push('scripts')
        <script>
            $(document).ready(function() {
                new PNotify({
                    title: 'Warning',
                    text: 'Attribute with the same slug already exists.',
                    type: 'error',
                    addclass: 'notification-error',
                    icon: 'fas fa-times'
                });
            })
        </script>
    @endpush
@endif