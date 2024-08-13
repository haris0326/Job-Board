@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body">

          <h5 class="card-title mb-5 d-inline">Create Categories</h5>
          <form method="POST" action="{{ route('store.categories') }}" enctype="multipart/form-data">
            @csrf
        
            <!-- Name input -->
            <div class="form-outline mb-4 mt-4">
                <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ old('name') }}" />
                
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        
            <!-- Submit button -->
            <button type="submit" class="btn btn-primary mb-4">Create</button>
        </form>
        

        </div>
      </div>
    </div>
  </div>

@endsection