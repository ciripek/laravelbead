@extends("layouts.app")

@section('title', $label->name)

@section("content")
    <h1 class="ps-3 text-center">{{$label->name}} modósitása</h1>
    <hr/>
    <div class="container">
        <form method="post" action="{{ route("labels.update", $label) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">
                    Cimke neve:
                </label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old("name", $label->name ?? "") }}">
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
                    <input type="checkbox" id="display" name="display" class="form-check-input"
                           @if($label->display)
                               checked
                           @endif
                    >

                </div>

                <div class="col">
                    <label for="color">
                        Cimke szine:
                    </label><input type="color" id="color" name="color" class="form-control-color  @error('color') is-invalid @enderror"
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
