@extends('admin.layout')

@section('vendor-css')
    <link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-bs4.css') }}" />
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Product Reviews', 'paths' => ['home' => '/dashboard', 'products' => '/products']])

    <div class="row">
        <div class="col">
            <form id="post-replies-list-form" method="get">
                <div class="card card-modern">
                    <div class="card-body">
                        <div class="datatables-header-footer-wrapper">
                            <div class="datatable-header">
                                <div class="row align-items-center mb-3">
                                    <div class="col col-sm-auto ml-auto pl-lg-1">
                                        <div class="search search-style-1 mx-lg-auto w-auto">
                                            <div class="input-group">
                                                <input type="text" maxlength="50" class="search-term form-control" name="search-term" id="search-term" placeholder="Search" value="{{ old('search-term') }}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-ecommerce-simple table-striped mb-0" id="datatable-ecommerce-list">
                                    <thead>
                                        <tr>
                                            <th width="30"><input type="checkbox" class="select-all checkbox-style-1 p-relative" value="" /></th>
                                            <th>@sortablelink('author_name', 'Author')</th>
                                            <th width="30%">Comment</th>
                                            <th>@sortablelink('product.name', 'Product Name')</th>
                                            <th>@sortablelink('rating')</th>
                                            <th>@sortablelink('created_at', 'Submitted On')</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($comments as $comment)
                                            <tr>
                                                <td><input type="checkbox" class="select-item checkbox-style-1 p-relative" data-id="{{ $comment->id }}" /></td>
                                                <td>
                                                    <div>{{ $comment->author_name }}</div>
                                                    <a href="mailto:{{ $comment->author_email }}" class="mt-1">{{ $comment->author_email }}</a>
                                                    <a href="javascript:;" class="slide-content d-block d-lg-none"></a>
                                                </td>
                                                <td data-column="Comment">
                                                    @if($comment->parent)
                                                        <div>In reply to <a href="{{ action('Admin\PostCommentController@index', Arr::add(\Request::except(['page', 'author']),'author', $comment->parent_author_name)) }}">{{ $comment->parent_author_name }}</a></div>
                                                    @endif
                                                    <div class="truncate">
                                                        {!! $comment->content !!}
                                                    </div>
                                                </td>
                                                <td data-column="Product Name" data-product-id="{{ $comment->product_id }}" class="response-to"><a href="{{ url('admin/products/' . $comment->product_id . '/edit') }}"><strong>{{ $comment->product->name }}</strong></a></td>
                                                <td data-column="Rating">{{ $comment->rating }}</td>
                                                <td data-column="Submitted On">{{ $comment->created_at }}</td>
                                                <td data-column="Status">
                                                    <input type="checkbox" class="approved-toggle checkbox-style-1 p-relative" {{ $comment->approved ? 'checked' : '' }} />
                                                </td>
                                                <td class="actions" data-column="Actions">
                                                    <a href="javascript:;" class="on-default modal-sizes reply-review"><i class="fas fa-reply"></i></a>
                                                    <a href="{{ url('admin/products/comments/' . $comment->id . '/edit') }}" class="on-default edit-row"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="javascript:;" class="on-default remove-row"><i class="far fa-trash-alt"></i></a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">No Comments found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <hr class="solid mt-5 opacity-4">
                            <div class="datatable-footer">
                                <div class="row align-items-center justify-content-between mt-3">
                                    <div class="col-md-auto order-1 mb-3 mb-lg-0">
                                        <div class="d-flex align-items-stretch">
                                            <select class="form-control select-style-1 bulk-action w-auto mr-3">
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
                                        {!! $comments->appends(\Request::except('page'))->render() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="d-none">
                <table>
                    <tbody class="reply">
                        <tr class="reply-row">
                            <td colspan="8">
                                <label class="control-label">Reply to comment</label>
                                <div class="summernote" data-plugin-summernote data-plugin-options='{ "height": 180, "codemirror": { "theme": "ambiance" } }'></div>
                                <div class="reply-actions mt-3">
                                    <a href="javascript:;" class="submit-reply btn btn-primary btn-px-2 py-2 align-items-center font-weight-semibold line-height-1" data-loading-text="Loading...">Reply</a>
                                    <a href="javascript:;" class="cancel-reply btn btn-light btn-px-2 py-2 ml-3 border font-weight-semibold text-color-dark line-height-1 h-100 align-items-center">Cancel</a>
                                </div>
                                <input type="hidden" id="username" value="{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}">
                                <input type="hidden" id="useremail" value="{{ Auth::user()->email }}">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('admin.common.modals.delete-confirm')
@endsection

@section('vendor-js')
    <script src="{{ asset('vendor/ios7-switch/ios7-switch.js') }}"></script>
    <script src="{{ asset('vendor/summernote/summernote-bs4.min.js') }}"></script>
@endsection

@section('page-js')
    <script src="{{ asset('server/js/comments/products/list.min.js') }}"></script>
@endsection