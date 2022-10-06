@extends('admin.layout')

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => $tag ? 'Edit Tag' : 'Add Tag', 'paths' => ['home' => '/dashboard', $type . 's' => '/' . $type . 's', 'tags' => '/tags/' . $type . '']])

    
    <form class="ecommerce-form " action="{{ $tag ? url('/admin/tags/' . $tag->id) : url('/admin/tags') }}" method="post">
        @if($tag)
            @method('PUT')
        @endif

        @csrf

        <input type="hidden" name="type" value="{{ $type }}" id="tag-type">
        <div class="row">
            <div class="col">
                <section class="card card-modern card-big-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2-5 col-xl-1-5">
                                <i class="card-big-info-icon bx bx-tag"></i>
                                <h2 class="card-big-info-title">Tag</h2>
                                <p class="card-big-info-desc">Add or update tag info with all details and necessary information.</p>
                            </div>
                            <div class="col-lg-3-5 col-xl-4-5">
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Tag Name</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="text" maxlength="20" class="form-control form-control-modern" name="name" value="{{ $tag ? $tag->name : '' }}" required />
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Slug</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="text" maxlength="20" class="form-control form-control-modern" name="slug" value="{{ $tag ? $tag->slug : '' }}" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mt-2 mb-0">Description</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <textarea class="form-control form-control-modern valid" name="description" maxlength="250" rows="4" placeholder="Enter description of tag." aria-invalid="false">{{ $tag ?  $tag->description : '' }}</textarea>
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
                    <i class="bx bx-save text-4 mr-2"></i> Save Tag
                </button>
            </div>
            <div class="col-12 col-md-auto px-md-0 mt-3 mt-md-0">
                <a href="{{ url('/admin/tags/' .  $type) }}" class="cancel-button btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark line-height-1 d-flex h-100 align-items-center">Back</a>
            </div>
            
            @if($tag)
                <div class="col-12 col-md-auto ml-md-auto mt-3 mt-md-0">
                    <a href="#delete-confirm-modal" class="delete-button btn btn-danger btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1" data-id="{{ $tag->id }}">
                        <i class="bx bx-trash text-4 mr-2"></i> Delete Tag
                    </a>
                </div>
            @endif
        </div>
    </form>

    @include('admin.common.modals.delete-confirm')
@endsection

@section('page-js')
    <script src="{{ asset('server/js/tags/edit.min.js') }}"></script>
@endsection

@if( $errors->has('slug') )
    @push('scripts')
        <script>
            $(document).ready(function() {
                new PNotify({
                    title: 'Warning',
                    text: 'Tag with same slug already exists.',
                    type: 'error',
                    addclass: 'notification-error',
                    icon: 'fas fa-times'
                });
            })
        </script>
    @endpush
@endif