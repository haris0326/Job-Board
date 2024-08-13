@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-5 d-inline">Update Categories</h5>
                <form method="POST" action="{{ route('update.categories', $category->id) }}" enctype="multipart/form-data">
                    
                    <!-- CSRF token -->
                    @csrf
                    @method('PUT') <!-- Specify that this is an update request -->

                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="name" id="form2Example1" class="form-control" placeholder="Name" value="{{ old('name', $category->name) }}" />
                        
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Submit button -->
                    <button type="submit" name="submit" class="btn btn-primary mb-4 text-center">Update</button>

                </form>
            </div>
        </div>
    </div>
</div>


@endsection