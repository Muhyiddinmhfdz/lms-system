@extends('layouts.main_layout', [
    'title' => $course->title,
    'breadcrum' => ['Course - Detail']
])

@section('content')
<div class="container py-5">

    <!-- Row Thumbnail & Info -->
    <div class="row">
        <!-- Thumbnail -->
        <div class="col-md-5 mb-4">
            <img src="{{ $course->path_thumbnail ? asset('storage/'.$course->path_thumbnail) : asset('assets/media/programming.jpg') }}"
                 alt="{{ $course->title }}" 
                 class="img-fluid rounded shadow-sm"
                 style="max-height: 400px; object-fit: cover;">
        </div>

        <!-- Info -->
        <div class="col-md-7">
            <h2 class="fw-bold">{{ $course->title }}</h2>

            <span class="badge bg-primary">{{ $course->category->name ?? '-' }}</span>

            <p class="mt-2 text-muted">
                By <strong>{{ $course->publisher }}</strong><br>
                <small>{{ $course->working_publisher }}</small>
            </p>

            <!-- Duration & Level -->
            <div class="d-flex gap-4 my-3 text-muted">
                <span><i class="bi bi-clock"></i> {{ $course->duration }} min</span>
                <span><i class="bi bi-bar-chart"></i> 
                    @if($course->level_id == 1) Beginner
                    @elseif($course->level_id == 2) Intermediate
                    @else Advanced
                    @endif
                </span>
            </div>

            <!-- Description -->
            <p class="text-gray-700">{{ $course->description }}</p>

            <a href="{{ route('course.my_course') }}" class="btn btn-secondary mt-3">
                <i class="bi bi-arrow-left"></i> Kembali ke My Course
            </a>
        </div>
    </div>

    <!-- Course Detail List -->
    @if($course->details && count($course->details) > 0)
    <div class="mt-5">
        <h4 class="fw-bold mb-3">Materi Kursus</h4>
        <div class="accordion" id="courseDetailAccordion">
            @foreach($course->details as $index => $detail)
                <div class="accordion-item mb-2">
                    <h2 class="accordion-header" id="heading{{ $index }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}">
                            {{ $index+1 }}. {{ $detail->sub_title }}
                        </button>
                    </h2>
                    <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#courseDetailAccordion">
                        <div class="accordion-body">
                            <!-- Video -->
                            @if($detail->url)
                                @php
                                    // Convert youtu.be or normal YouTube link to embed link
                                    $embedUrl = str_replace('watch?v=', 'embed/', $detail->url);
                                    $embedUrl = str_replace('youtu.be/', 'www.youtube.com/embed/', $embedUrl);
                                @endphp
                                <div class="ratio ratio-16x9 mb-3">
                                    <iframe src="{{ $embedUrl }}" frameborder="0" allowfullscreen></iframe>
                                </div>
                            @endif

                            <!-- Description -->
                            @if($detail->description)
                                <p class="text-muted">{{ $detail->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection