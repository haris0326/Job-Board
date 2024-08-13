@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body">

          <h5 class="card-title mb-5 d-inline">Create Admins</h5>
         <form method="POST" action="{{ route('store.admins') }}" enctype="multipart/form-data">
            <!-- Email input -->
            @csrf

            <div class="form-outline mb-4 mt-4">
              <input type="email" name="email" id="form2Example1" class="form-control" placeholder="email" />
              @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>

            <div class="form-outline mb-4">
              <input type="text" name="name" id="form2Example1" class="form-control" placeholder="username" />
              @error('name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror  
            </div>
            

            <div class="form-outline mb-4">
              <input type="password" name="password" id="form2Example1" class="form-control" placeholder="password" />
              @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror 
              </div>
        
            
            <!-- Submit button -->
            <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">create</button>

      
          </form>

        </div>
      </div>
    </div>
  </div>


@endsection