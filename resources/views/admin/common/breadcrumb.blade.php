<header class="page-header page-header-left-inline-breadcrumb">
    <h2 class="font-weight-bold text-6">{{ $current_page }}</h2>
    <div class="right-wrapper">
        <ol class="breadcrumbs">
            @foreach($paths as $key => $path)
                <li><a href="{{ url('/admin') }}{{ $path }}"><span>{{ $key }}</span></a></li>
            @endforeach
        </ol>
    </div>
</header>