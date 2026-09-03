<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title my-auto">{{ $title }}</h1>
    <div>
        <ol class="breadcrumb mb-0">
            @foreach ($breadcrumbs as $breadcrumb)
                <li class="breadcrumb-item">
                    <a href="{{ route($breadcrumb['route']) }}">
                        {{ $breadcrumb['title'] }}
                    </a>
                </li>
            @endforeach
            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->
