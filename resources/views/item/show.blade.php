@extends("layouts.app")

@section('title', $item->name)

@section("edit")
    @if(Auth::user()?->is_admin)
        <li class="nav-item">
            <a class="nav-link" href="{{ route("items.edit", $item) }}">Tárgy módositás</a>
        </li>
    @endif

    @if(Auth::user()?->is_admin)
        <form method="POST" action="{{ route('items.destroy', $item) }}" id="item-delete-form">
            @csrf
            @method('DELETE')
            <a href="{{ route('items.destroy', $item) }}"
               onclick="event.preventDefault(); document.querySelector('#item-delete-form').submit();"
               class="nav-link">Törlés</a>
        </form>
    @endif
@endsection

@section("content")
    <div class="container">
        <div class="card w-20">
            <img src="@if(is_null($item->image))
                         {{ asset("images/no-image-found.jpg") }}
                      @else
                         {{ Storage::url($item->image) }}
                      @endif
                     "
                 class="card-img-top"
                 alt="{{$item->image_name}}"
            >
            <div class="card-body">
                <h5 class="card-title mb-0">{{ $item->name}}</h5>

                @foreach($labels as $label)
                    @if($label->display)
                        <a href="{{ route("labels.show", $label->id) }}">
                            <span class="badge" style="background-color: {{ $label->color}};">{{ $label->name }}</span>
                        </a>
                    @endif
                @endforeach

                <p class="card-text mt-1">{{ $item->description }}</p>
            </div>


        </div>
        <a href="{{ route('items.index') }}"><i class="fas fa-long-arrow-alt-left"></i> Back to the homepage</a>
        @if(Auth::hasUser())
            <form method="post" action="{{ route("items.comments.store", $item) }}">
                @csrf
                <div class="mb-3">
                    <label for="text" class="form-label">Új comment</label>
                    <textarea class="form-control" id="text" name="text" rows="3"></textarea>
                    <button type="submit" class="btn btn-secondary btn-sm">Új comment</button>
                </div>
            </form>
        @endif
        <h2>Comments: </h2>
        @forelse($comments as $comment)
            <div class="card mb-4">
                <div class="card-body">
                    <p> {{ $comment->text }}</p>

                    <div class="d-flex justify-content-between">
                        <div class="d-flex flex-row align-items-center">
                            <p class="small mb-0 ms-2">{{ $comment->user->name }}</p>
                            <p class="small mb-0 ms-2">{{ $comment->created_at }}</p>
                            <p class="small mb-0 ms-2">{{ $comment->updated_at }}</p>
                            @if(Auth::user()?->is_admin || Auth::id() == $comment->user_id)
                                <form method="POST" action="{{ route('items.comments.destroy', [$item,$comment]) }}"
                                      id="comment-delete-form">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="ms-2 btn btn-secondary btn-sm">Törlés</button>
                                </form>
                            <a href="{{ route('items.comments.edit', [$item, $comment]) }}"><p class="small mb-0 ms-2">Szerkesztes</p></a>
                            @endif
                        </div>
                    </div>


                </div>
            </div>

        @empty
            <p>
                No comments
            </p>
        @endforelse

    </div>
@endsection
