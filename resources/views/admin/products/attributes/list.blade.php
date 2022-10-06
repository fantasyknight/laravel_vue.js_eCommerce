@extends('admin.layout')

@section('vendor-css')
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Product Attributes', 'paths' => ['home' => '/dashboard', 'products' => '/products' ]])

        <div class="row">
            <div class="col-xl-4">
                <form method="post">
                    @csrf
                    <div class="card card-modern">
                        <div class="card-body">
                            <div class="form-group align-items-center">
                                <label class="control-label">Name</label>
                                <input type="text" maxlength="20" class="form-control form-control-modern" name="name" value="" required />
                                <span class="help-block">Name for the attribute.</span>
                            </div>
                            <div class="form-group align-items-center">
                                <label class="control-label">Slug</label>
                                <input type="text" maxlength="20" class="form-control form-control-modern" name="slug" value="" />
                                <span class="help-block">Unique slug/reference for the attribute.</span>
                            </div>
                            <div class="form-group align-items-center">
                                <label class="control-label">Default sort order</label>
                                <select class="form-control form-control-modern w-auto" name="sort_by">
                                    <option value="custom_ordering">Custom Ordering</option>
                                    <option value="name">Name</option>
                                    <option value="name_numeric">Name (numeric)</option>
                                    <option value="term_id">Term ID</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Add attribute</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xl-8 mt-xl-0 mt-3">
                <div class="card card-modern">
                    <div class="card-body">
                        <div class="datatables-header-footer-wrapper">
                            <div class="table-responsive">
                                <table class="table table-ecommerce-simple table-striped mb-0" id="datatable-ecommerce-list">
                                    <thead>
                                        <tr>
                                            <th width="30"><input type="checkbox" class="select-all checkbox-style-1 p-relative" value="" /></th>
                                            <th>Name</th>
                                            <th>Slug</th>
                                            <th>Order by</th>
                                            <th width="33%">Terms</th>
                                            <th width="80">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($attributes->isNotEmpty())
                                            @foreach($attributes as $attribute)
                                                <tr>
                                                    <td><input type="checkbox" class="checkbox-style-1 p-relative" data-id="{{ $attribute->id }}" /></td>
                                                    <td>
                                                        @cannot('vendor-role')
                                                            <a href="{{ url('admin/products/attributes/' . $attribute->id . '/edit') }}"><strong>{{ $attribute->name }}</strong></a>
                                                        @else
                                                            <a href="#"><strong>{{ $attribute->name }}</strong></a>
                                                        @endcannot
                                                        <a href="javascript:;" class="slide-content d-block d-lg-none"></a>
                                                    </td>
                                                    <td data-column="Slug">{{ $attribute->slug }}</td>
                                                    <td data-column="Order by">{{ $attribute->sort_by }}</td>
                                                    <td data-column="Terms">
                                                        <div class="terms">
                                                            {{ $attribute->terms->implode('name', ', ') }}
                                                        </div>
                                                        <a href="{{ action('Admin\AttributeTermController@index', ['attribute' => $attribute->id]) }}">Configure terms</a>
                                                    </td>
                                                    <td class="actions" data-column="Actions">
                                                        @cannot('vendor-role')
                                                            <a href="{{ url('admin/products/attributes/' . $attribute->id) }}/edit" class="on-default edit-row"><i class="fas fa-pencil-alt"></i></a>
                                                            <a href="javscript:;" class="on-default remove-row"><i class="far fa-trash-alt"></i></a>
                                                        @endcannot
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center">No attributes found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @include('admin.common.modals.delete-confirm')
@endsection

@section('vendor-js')
@endsection

@section('page-js')
    <script src="{{ asset('server/js/products/attributes/list.min.js') }}"></script>
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