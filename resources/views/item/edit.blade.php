@extends("layouts.app")

@section('title', $item->name)


@section("content")
    <h1 class="ps-3 text-center">Tárgy modósitása</h1>
    <hr/>
    <div class="container">
        <form method="post" action="{{ route("items.update", $item) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="name" class="form-label">
                    Tárgy neve:
                </label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old("name", $item->name ?? "") }}">
            </div>

            <div class="text-danger">
                <p>
                    {{  $errors->first('name') }}
                </p>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Tárgy leirása</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                          name="description" rows="3">{{ old("description", $item->description ?? "") }}</textarea>
            </div>

            <div class="text-danger">
                <p>
                    {{  $errors->first('description') }}
                </p>
            </div>

            <div class="mb-3">
                <label for="obtained" class="form-label">Tárgy dátuma:</label>
                <input type="date" id="obtained" name="obtained" value="{{ old("obtained", $item->obtained ?? "") }}"
                       class="form-control-date @error('obtained') is-invalid @enderror">
            </div>

            <div class="text-danger">
                <p>
                    {{  $errors->first('obtained') }}
                </p>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Tárgy képe:</label>
                <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"
                       value="{{ old("image", $item->image ?? "") }}">
            </div>

            <div class="text-danger">
                <p>
                    {{  $errors->first('image') }}
                </p>
            </div>

            <label for="labels" class="form-label">
                Tárgy cimkéi:
            </label><select class="form-select form-select-lg mb-3 @error('labels[]') is-invalid @enderror" name="labels[]" id="labels" multiple>
                @foreach($labels as $label)
                    <option value="{{ $label->id }}"
                    @if($item->labels->contains($label->id))
                        selected
                    @endif
                    >{{ $label->name }}</option>
                @endforeach
            </select>

            <div class="text-danger">
                <p>
                    {{  $errors->first('labels[]') }}
                </p>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection