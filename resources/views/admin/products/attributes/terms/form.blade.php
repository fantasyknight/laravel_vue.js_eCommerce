@extends('admin.layout')

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => $term ? 'Edit Term' : 'Add Term', 'paths' => ['home' => '/dashboard', 'products' => '/products', 'attributes' => '/products/attributes']])

    
    <form class="ecommerce-form " action="{{ $term ? url('/admin/products/attributes/terms/'.$term->id) : url('/admin/products/attributes/terms') }}" method="post">
        @if($term) 
            @method('PUT')
        @endif
        @csrf
        <input type="hidden" name="attribute_id" id="attribute-id" value="{{ \Request::get('attribute') }}">
        <div class="row">
            <div class="col">
                <section class="card card-modern card-big-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2-5 col-xl-1-5">
                                <i class="card-big-info-icon bx bx-analyse"></i>
                                <h2 class="card-big-info-title">Attribute</h2>
                                <p class="card-big-info-desc">Edit attribute's term.</p>
                            </div>
                            <div class="col-lg-3-5 col-xl-4-5">
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Name</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="text" maxlength="20" class="form-control form-control-modern" name="name" value="{{ $term ? $term->name : '' }}" required />
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Slug</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="text" maxlength="20" class="form-control form-control-modern" name="slug" value="{{ $term ? $term->slug : '' }}" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mt-2 mb-0">Description</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <textarea class="form-control form-control-modern valid" maxlength="250" name="description" rows="4" placeholder="Enter description of term" aria-invalid="false">{{ $term ?  $term->description : '' }}</textarea>
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
                    <i class="bx bx-save text-4 mr-2"></i> Save Term
                </button>
            </div>
            <div class="col-12 col-md-auto px-md-0 mt-3 mt-md-0">
                <a href="{{ action('Admin\AttributeTermController@index', ['attribute' => \Request::get('attribute')]) }}" class="cancel-button btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark line-height-1 d-flex h-100 align-items-center">Back</a>
            </div>
            
            @if($term)
                <div class="col-12 col-md-auto ml-md-auto mt-3 mt-md-0">
                    <a href="#delete-confirm-modal" class="delete-button btn btn-danger btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1" data-id="{{ $term->id }}">
                        <i class="bx bx-trash text-4 mr-2"></i> Delete Term
                    </a>
                </div>
            @endif
        </div>
    </form>

    @include('admin.common.modals.delete-confirm')
@endsection

@section('page-js')
    <script src="{{ asset('server/js/products/attributes/terms/edit.min.js') }}"></script>
@endsection

@if( $errors->has('slug') )
    @push('scripts')
        <script>
            $(document).ready(function() {
                new PNotify({
                    title: 'Warning',
                    text: 'Term with same slug already exists.',
                    type: 'error',
                    addclass: 'notification-error',
                    icon: 'fas fa-times'
                });
            })
        </script>
    @endpush
@endif