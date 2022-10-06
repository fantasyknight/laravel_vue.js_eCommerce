@extends('admin.layout')

@section('vendor-css')
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => ucfirst($type . ' tags'), 'paths' => ['home' => '/dashboard', $type . 's' => '/' . $type . 's' ]])

    <div class="row">
        <div class="col-xl-4">
            <form method="post" action="{{ url('/admin/tags/') }}">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}" id="tag-type">
                <div class="card card-modern">
                    <div class="card-body">
                        <div class="form-group align-items-center">
                            <label class="control-label">Name</label>
                            <input type="text" maxlength="20" class="form-control form-control-modern" name="name" value="" required />
                            <span class="help-block">Name for the tag.</span>
                        </div>
                        <div class="form-group align-items-center">
                            <label class="control-label">Slug</label>
                            <input type="text" maxlength="20" class="form-control form-control-modern" name="slug" value="" />
                            <span class="help-block">Unique slug/reference for the tag.</span>
                        </div>
                        <div class="form-group align-items-center">
                            <label class="control-label">Description</label>
                            <textarea class="form-control form-control-modern" name="description" rows="5" maxlength="200"></textarea>
                            <span class="help-block">Unique slug/reference for the tag.</span>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Add Tag</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-xl-8 mt-xl-0 mt-3">
            <form id="tags-list-form" method="get">
                <div class="card card-modern">
                    <div class="card-body">
                        <div class="datatables-header-footer-wrapper">
                            <div class="datatable-header">
                                <div class="row align-items-center mb-3">
                                    <div class="col col-sm-auto ml-auto pl-lg-1">
                                        <div class="search search-style-1 mx-lg-auto w-auto">
                                            <div class="input-group">
                                                <input type="text" class="search-term form-control" name="search-term" id="search-term" placeholder="Search" value="{{ old('search-term') }}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-ecommerce-simple table-striped mb-0" id="datatable-ecommerce-list" style="min-width: 750px">
                                    <thead>
                                        <tr>
                                            <th width="30"><input type="checkbox" class="select-all checkbox-style-1 p-relative" value="" /></th>
                                            <th>@sortablelink('name')</th>
                                            <th>@sortablelink('slug')</th>
                                            <th width="45%">@sortablelink('description')</th>
                                            <th width="12%">@sortablelink($type . 's_count', 'Count')</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($tags->isNotEmpty())
                                            @foreach($tags as $tag)
                                                <tr>
                                                    <td><input type="checkbox" class="checkbox-style-1 p-relative" data-id="{{ $tag->id }}" /></td>
                                                    <td>
                                                        @cannot('vendor-role')
                                                            <a href="{{ url('admin/tags/' . $tag->id . '/edit') }}"><strong>{{ $tag->name }}</strong></a>
                                                        @else
                                                            <a href="#"><strong>{{ $tag->name }}</strong></a>
                                                        @endcannot
                                                        <a href="javascript:;" class="slide-content d-block d-lg-none"></a>
                                                    </td>
                                                    <td data-column="Slug">{{ $tag->slug }}</td>
                                                    <td data-column="Description">{{ $tag->description }}</td>
                                                    <td data-column="Count">
                                                        @if($type == 'product')
                                                            <a href="#">{{ $tag->products_count }}</a>
                                                        @else
                                                            <a href="#">{{ $tag->posts_count }}</a>
                                                        @endif
                                                    </td>
                                                    <td class="actions" data-column="Actions">
                                                        @cannot('vendor-role')
                                                            <a href="{{ url('admin/tags/' . $tag->id . '/edit') }}" class="on-default edit-row"><i class="fas fa-pencil-alt"></i></a>
                                                            <a href="javscript:;" class="on-default remove-row"><i class="far fa-trash-alt"></i></a>
                                                        @endcannot
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center">No tags found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <hr class="solid mt-5 opacity-4">
                            <div class="datatable-footer">
                                <div class="row align-items-center justify-content-between mt-3">
                                    <div class="col-md-auto order-1 mb-3 mb-lg-0">
                                        @cannot('vendor-role')
                                        <div class="d-flex align-items-stretch">
                                            <select class="form-control select-style-1 bulk-action w-auto mr-3">
                                                <option value="" selected>Bulk Actions</option>
                                                <option value="delete">Delete</option>
                                            </select>
                                            <a href="javascript:;" class="bulk-action-apply btn btn-light border font-weight-semibold text-color-dark text-3">Apply</a>
                                        </div>
                                        @endcannot
                                    </div>
                                    <div class="col-lg-auto text-center order-3 order-lg-2">
                                        <div class="results-info-wrapper"></div>
                                    </div>
                                    <div class="col-lg-auto order-2 order-lg-3 mb-3 mb-lg-0">
                                        {!! $tags->appends(\Request::except('page'))->render() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('admin.common.modals.delete-confirm')
@endsection

@section('vendor-js')
@endsection

@section('page-js')
    <script src="{{ asset('server/js/tags/list.min.js') }}"></script>
@endsection