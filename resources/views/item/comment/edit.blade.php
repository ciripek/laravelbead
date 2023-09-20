@extends("layouts.app")

@section('title', "Comment edit")

@section("content")
    <h1 class="text-center">Comment szerkesztése</h1>
    <div class="container">
        <form method="post" action="{{ route("items.comments.update", [$item, $comment]) }}">
            @csrf
            @method("PATCH")
            <div class="mb-3">
                <label for="text" class="form-label">Új comment</label>
                <textarea class="form-control" id="text" name="text"
                          rows="3">{{ old("name", $comment->text ?? "") }}</textarea>
                <button type="submit" class="btn btn-secondary btn-sm">Comment Szerkesztése</button>
            </div>
        </form>
    </div>
@endsection
