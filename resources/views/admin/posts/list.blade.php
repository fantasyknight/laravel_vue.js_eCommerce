@extends('admin.layout')

@section('vendor-css')
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'All Posts', 'paths' => ['home' => '/dashboard']])

    <div class="row">
        <div class="col">
            <form id="posts-list-form" method="get">
                <div class="card card-modern">
                    <div class="card-body">
                        <div class="datatables-header-footer-wrapper">
                            <div class="datatable-header">
                                <div class="row align-items-lg-center mb-3">
                                    <div class="col-xl-auto mb-2 mt-1 mb-xl-0">
                                        <a href="{{ url('/admin/posts/create') }}" class="btn btn-primary btn-md font-weight-semibold">+ Add Post</a>
                                    </div>
                                    <div class="col-lg-auto mb-2 mb-lg-0 ml-xl-auto pl-xl-1">
                                        <div class="d-flex align-items-lg-center flex-wrap">
                                            <label class="d-none d-xl-block ws-nowrap mr-3 mb-0">Filter By:</label>
                                            <select class="form-control select-style-1 filter-by w-auto my-1 mr-2" name="date">
                                                <option value="*" {{ old('date') == '*' ? 'selected' : '' }}>All dates</option>
                                                @foreach($dates as $date)
                                                    <option value="{{ $date->month }}" {{ old('date') == $date->month ? 'selected' : '' }}>{{ $date->month }}</option>
                                                @endforeach
                                            </select>
                                            <select class="form-control select-style-1 filter-by w-auto my-1 mr-2" name="category">
                                                <option value="0" {{ old('category') == '0' ? 'selected' : '' }}>No Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>{!! $category->name !!}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-primary filter-btn my-1">Filter</button>
                                        </div>
                                    </div>
                                    <div class="col-auto pl-lg-1">
                                        <div class="search search-style-1 mx-lg-auto w-auto">
                                            <div class="input-group">
                                                <input type="text" maxlength="20" class="search-term form-control" name="search-term" id="search-term" placeholder="Search" value="{{ old('search-term') }}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-ecommerce-simple table-posts table-striped table-responsive-lg mb-0" id="datatable-ecommerce-list" style="min-width: 950px">
                                    <thead>
                                        <tr>
                                            <th width="30"><input type="checkbox" name="select-all" class="select-all checkbox-style-1 p-relative" value="" /></th>
                                            <th width="30%">@sortablelink('title')</th>
                                            <th>Author</th>
                                            <th>Categories</th>
                                            <th>Tags</th>
                                            <th>@sortablelink('comments_count', 'Replies')</th>
                                            <th width="8%">@sortablelink('created_at', 'Date')</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($posts->isNotEmpty())
                                            @foreach($posts as $post)
                                                <tr>
                                                    <td><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative" value="" data-id="{{ $post->id }}" /></td>
                                                    <td>
                                                        <a href="{{ url('/admin/posts/' . $post->id . '/edit') }}"><strong>{{ $post->title }}</strong></a>
                                                        <a href="javascript:;" class="slide-content d-block d-lg-none"></a>
                                                    </td>
                                                    <td data-column="Author"><a href="{{ action('Admin\PostController@index', Arr::add(\Request::except('page'), 'author', $post->author->id)) }}">{{ $post->author->first_name }}</a></td>
                                                    <td data-column="Categories">{{ $post->categories->implode('name', ', ') }}</td>
                                                    <td data-column="Tags">{{ $post->tags->implode('name', ', ') }}</td>
                                                    <td data-column="Replies">
                                                        @cannot('vendor-role')
                                                            <a href="{{ action('Admin\PostCommentController@index', ['post' => $post->id]) }}">{{ $post->comments_count }}</a>
                                                        @else
                                                            <a href="#">{{ $post->comments_count }}</a>
                                                        @endcannot
                                                    </td>
                                                    <td data-column="Date">{{ date('m/d/Y', strtotime($post->created_at)) }}</td>
                                                    <td class="actions" data-column="Actions">
                                                        <a href="{{ url('admin/posts/' . $post->id . '/edit') }}" class="on-default edit-row"><i class="fas fa-pencil-alt"></i></a>
                                                        <a href="javscript:;" class="on-default remove-row"><i class="far fa-trash-alt"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else 
                                            <tr>
                                                <td colspan="8" class="text-center">No posts available.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <hr class="solid mt-5 opacity-4">
                            <div class="datatable-footer">
                                <div class="row align-items-center justify-content-between mt-3">
                                    <div class="col-md-auto order-1 mb-3 mb-lg-0">
                                        <div class="d-flex align-items-stretch">
                                            <select class="form-control select-style-1 bulk-action mr-3" style="min-width: 120px;">
                                                <option value="" selected>Bulk Actions</option>
                                                <option value="delete">Delete</option>
                                            </select>
                                            <a href="javascript:;" class="bulk-action-apply btn btn-light border font-weight-semibold text-color-dark text-3">Apply</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-auto text-center order-3 order-lg-2">
                                        <div class="results-info-wrapper"></div>
                                    </div>
                                    <div class="col-lg-auto order-2 order-lg-3 mb-3 mb-lg-0">
                                        {!! $posts->appends(\Request::except('page'))->render() !!}
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
    <script src="{{ asset('server/js/posts/list.min.js') }}"></script>
@endsection