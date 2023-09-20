@extends("layouts.app")

@section('title', "Új cimke")


@section("content")
    <h1 class="ps-3 text-center">Új cimke</h1>
    <hr/>
    <div class="container">
        <form method="post" action="{{ route("labels.store") }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">
                    Cimke neve:
                </label>
                <input type="text" id="name" name="name"
                       value="{{ old("name", $label->name ?? "") }}"
                       class="form-control @error('name') is-invalid @enderror">
            </div>
            <div class="text-danger">
                <p>
                    {{  $errors->first('name') }}
                </p>
            </div>

            <div class="row">
                <div class="col form-check">
                    <label for="display" class="form-check-label">
                        Láthatóság
                    </label>
                    <input type="checkbox" id="display" name="display"
                           @if(old("display", $label->display ?? false))
                               checked
                           @endif

                           class="form-check-input">

                </div>

                <div class="col">
                    <label for="color">
                        Cimke szine:
                    </label><input type="color" id="color" name="color"
                                   class="form-control-color @error('color') is-invalid @enderror"
                                   value="{{ old("color", $label->color ?? "") }}">
                </div>

                <div class="text-danger">
                    <p>
                        {{  $errors->first('color') }}
                    </p>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>

        </form>
    </div>
@endsection
