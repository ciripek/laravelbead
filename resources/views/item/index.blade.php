@extends("layouts.app")

@section('title', 'Items')

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-9">
                <div class="row">
                    @forelse ($items as $item)
                        <div class="col-12 col-md-6 col-lg-4 mb-3 d-flex align-self-stretch">
                            <div class="card w-100">
                                <img
                                        src="
                                        @if(is_null($item->image))
                                            {{ asset("images/no-image-found.jpg") }}
                                        @else
                                            {{ Storage::url($item->image) }}
                                        @endif
                                        "
                                        class="card-img-top"
                                        alt="{{ $item->image_name ?? "no-image-found" }}"
                                >
                                <div class="card-body">
                                    <h5 class="card-title mb-0">{{$item->name }}</h5>

                                    <p class="card-text mt-1">{{ Str::limit($item->description, $limit = 100, $end = '...')  }}</p>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route("items.show", $item) }}" class="btn btn-primary">
                                        <span>View item</span> <i class="fas fa-angle-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-warning" role="alert">
                                No items found!
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="d-flex justify-content-center">
                    {{ $items->links() }}
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="col-12 mb-3">
                    <div class="card bg-light">
                        <div class="card-header">
                            Labels
                        </div>
                        <div class="card-body">
                            @foreach ($labels as $label)
                                <a href="{{ route('labels.show', $label->id) }}" class="text-decoration-none">
                                    <span class="badge"
                                          style="background-color: {{ $label->color }}">{{ $label->name }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
