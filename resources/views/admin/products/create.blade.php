@extends('admin.layout')

@section('vendor-css')
    <link rel="stylesheet" href="{{ asset('vendor/dropzone/basic.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/dropzone/dropzone.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/jstree/themes/default/style.css') }}" />
    <style> 
        .datepicker {
            position: static;
        }
    </style>
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => empty($product) ? 'New Product' : 'Edit Product', 'paths' => ['home' => '/dashboard', 'products' => '/products']])
    <!-- start: page -->
    @if(empty($product)) 
        <new-product-component 
            :product-tags="{{ $product_tags }}"
            :settings="{{ json_encode(config('setting')) }}"
            :tax-types="{{ $tax_types }}"
            :attributes="{{ $attributes }}"
            base-url="{{ asset('/') }}"
            token="{{ csrf_token() }}"
        >
        </new-product-component>
    @else
        <new-product-component 
            :initial-product="{{ $product }}"
            :product-tags="{{ $product_tags }}"
            :settings="{{ json_encode(config('setting')) }}"
            :tax-types="{{ $tax_types }}"
            :attributes="{{ $attributes }}"
            :v-products="{{ $variations }}"
            :upsells="{{ $upsells }}"
            :cross_sells="{{ $cross_sells }}"
            base-url="{{ asset('/') }}"
            token="{{ csrf_token() }}"
        >
        </new-product-component>
    @endif

    <!-- end: page -->
    @include('admin.common.modals.delete-confirm')
@endsection

@section('vendor-js')
    <script src="{{ asset('vendor/jstree/jstree.js') }}"></script>
    <script src="{{ asset('vendor/common/common.js') }}"></script>
@endsection

@section('page-js')
    <script src="{{ asset('server/js/products/create.min.js') }}"></script>
@endsection

@push('scripts')
<script>
    window.jQuery(document).ready(function($) {
        $('#treeCheckbox').jstree({
            'core' : {
                'data' : {!! $categories !!},
                'themes' : {
                    'responsive': false
                }
            },
            'plugins': ['types', 'checkbox'],
            'checkbox': {
                'three_state': false,
                'tie_selection': false,
                'whole_node': true
            }
        });

        @if(! empty($current_categories))
            $('#treeCheckbox').on('loaded.jstree', function() {
                $('#treeCheckbox').jstree().check_node({!! $current_categories !!});
            });
        @endif
    });
</script>

@endpush