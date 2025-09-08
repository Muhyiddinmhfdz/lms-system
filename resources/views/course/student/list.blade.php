@extends('layouts.main_layout',['title'=>'Course','breadcrum'=>['Course - List']])

@section('content')
<div class="container">

    <!-- Filter -->
    <form method="GET" action="{{ route('course.list.index') }}" class="row mb-4 g-3">
        <!-- Category -->
        <div class="col-md-3">
            <select name="category" class="form-select">
                <option value="">-- Semua Kategori --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" 
                        {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Level -->
        <div class="col-md-3">
            <select name="level" class="form-select">
                <option value="">-- Semua Level --</option>
                @foreach($levels as $key => $label)
                    <option value="{{ $key }}" 
                        {{ request('level') == $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Price -->
        <div class="col-md-3">
            <select name="price" class="form-select">
                <option value="">-- Semua Harga --</option>
                <option value="low" {{ request('price') == 'low' ? 'selected' : '' }}>
                    Rp ≤ 100.000
                </option>
                <option value="high" {{ request('price') == 'high' ? 'selected' : '' }}>
                    Rp > 100.000
                </option>
            </select>
        </div>

        <!-- Buttons -->
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
            <a href="{{ route('course.list.index') }}" class="btn btn-secondary w-100">Reset</a>
        </div>
    </form>

    <!-- Course List -->
    <div class="row">
        @forelse($courses as $item)
        <div class="col-md-4 mt-5">
            <!--begin::Course Card-->
            <div class="card shadow-sm mb-5 h-100 d-flex flex-column">
                <!-- Thumbnail -->
                <div class="card-img-top text-center p-3">
                    <img src="{{ $item->path_thumbnail ? asset('storage/'.$item->path_thumbnail) : asset('assets/media/programming.jpg') }}" 
                         alt="{{ $item->title }}" 
                         class="img-fluid rounded" 
                         style="height:200px; object-fit:cover;">
                </div>

                <!-- Body -->
                <div class="card-body text-center flex-grow-1">
                    <h5 class="fw-bold text-gray-800">{{ $item->title }}</h5>

                    <span class="badge bg-primary mb-2">{{ $item->category->name ?? '-' }}</span>
                    <p class="text-muted mb-1"><small>By {{ $item->publisher }}</small></p>
                    <p class="text-muted mb-2"><small>{{ $item->working_publisher }}</small></p>

                    <!-- Duration & Level -->
                    <div class="d-flex justify-content-center gap-3 mb-3">
                        <span class="text-gray-600"><i class="bi bi-clock"></i> {{ $item->duration }} min</span>
                        <span class="text-gray-600"><i class="bi bi-bar-chart"></i> 
                            @if($item->level_id == 1) Beginner 
                            @elseif($item->level_id == 2) Intermediate 
                            @else Advanced @endif
                        </span>
                    </div>

                    <!-- Price -->
                    <div class="mb-3">
                        @if($item->discount_price)
                            <span class="text-danger fw-bold">Rp {{ number_format($item->discount_price,0,',','.') }}</span>
                            <span class="text-muted text-decoration-line-through">Rp {{ number_format($item->price,0,',','.') }}</span>
                        @else
                            <span class="fw-bold">Rp {{ number_format($item->price,0,',','.') }}</span>
                        @endif
                    </div>

                    <!-- Short Description -->
                    <p class="text-gray-600" style="max-height:80px; overflow:hidden;">
                        {{ Str::limit(strip_tags($item->description), 120, '...') }}
                    </p>

                    <!-- Button -->
                    <a href="{{ route('course.list.detail', $item->slug) }}" class="btn btn-sm btn-primary w-100 mt-auto">Lihat Detail</a>
                </div>

                <!-- Course Details List -->
                @if($item->details && count($item->details) > 0)
                <div class="card-footer bg-light">
                    <h6 class="fw-bold mb-2">Materi Kursus:</h6>
                    <ul class="list-unstyled text-start small">
                        @foreach($item->details as $detail)
                            <li><i class="bi bi-play-circle text-success"></i> {{ $detail->sub_title }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
            <!--end::Course Card-->
        </div>
        @empty
            <div class="col-12 text-center mt-5">
                <p class="text-muted">Tidak ada kursus ditemukan</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $courses->links() }}
    </div>
</div>
@endsection