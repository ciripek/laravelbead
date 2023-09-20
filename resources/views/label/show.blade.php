@extends("layouts.app")

@section('title', $label->name)

@section("edit")
    @if(Auth::user()?->is_admin)
        <li class="nav-item">
            <a class="nav-link" href="{{ route("labels.edit", $label) }}">Cimke módositás</a>
        </li>
    @endif


    @if(Auth::user()?->is_admin)
        <form method="POST" action="{{ route('labels.destroy', $label) }}" id="label-delete-form">
            @csrf
            @method('DELETE')
            <a href="{{ route('labels.destroy', $label) }}"
               onclick="event.preventDefault(); document.querySelector('#label-delete-form').submit();"
               class="nav-link">Törlés</a>
        </form>
    @endif
@endsection

@section("content")
    <h1 class="text-center"> {{ $label->name }}</h1>
    <div class="container">
        <div class="col-12 col-lg-9">
            <div class="row">
                @forelse ($label_items as $item)
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
                                    alt="Item cover"
                            >
                            <div class="card-body">
                                <h5 class="card-title mb-0">{{ $item->name }}</h5>

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
                {{ $label_items->links() }}
            </div>
        </div>
    </div>
@endsection
