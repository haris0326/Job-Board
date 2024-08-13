@extends('layouts.app')

@section('content')

<section class="section-hero overlay inner-page bg-image" style="margin-top: -24px; background-image: url({{ asset('assets/images/hero_1.jpg') }});" id="home-section">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1 class="text-white font-weight-bold">Update Profile</h1>
                <div class="custom-breadcrumbs">
                    <a href="#">Home</a> <span class="mx-2 slash">/</span>
                    <a href="#">Job</a> <span class="mx-2 slash">/</span>
                    <span class="text-white"><strong>Update Profile</strong></span>
                </div>
            </div>
        </div>
    </div>
</section>

    @if (session('update'))
        <div class="alert alert-success">
            {{ session('update') }}
        </div>
    @endif

<section class="site-section">

    <div class="container">

        <div class="row align-items-center mb-5">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="d-flex align-items-center">
                    <div>
                        <h2>Update Details</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-lg-12">
                <form class="p-4 p-md-5 border rounded" action="{{ route('update.details') }}" method="post">
                    @csrf <!-- CSRF Token for Security -->
                
                    <!-- Name -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" value="{{ $userDetails->name }}" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                
                    <!-- Job Title -->
                    <div class="form-group">
                        <label for="job-title">Job Title</label>
                        <input type="text" name="job_title" value="{{ $userDetails->job_title }}" class="form-control @error('job_title') is-invalid @enderror" id="job-title" placeholder="Job Title">
                        @error('job_title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                
                    <!-- Bio -->
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label class="text-black" for="bio">Bio</label>
                            <textarea id="bio" name="bio" cols="30" rows="7" class="form-control @error('bio') is-invalid @enderror" placeholder="Bio">{{ $userDetails->bio }}</textarea>
                            @error('bio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                
                    <!-- Facebook -->
                    <div class="form-group">
                        <label for="facebook">Facebook</label>
                        <input type="text" name="facebook" value="{{ $userDetails->facebook }}" class="form-control @error('facebook') is-invalid @enderror" id="facebook" placeholder="Facebook">
                        @error('facebook')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                
                    <!-- Twitter -->
                    <div class="form-group">
                        <label for="twitter">Twitter</label>
                        <input type="text" name="twitter" value="{{ $userDetails->twitter }}" class="form-control @error('twitter') is-invalid @enderror" id="twitter" placeholder="Twitter">
                        @error('twitter')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                
                    <!-- Linkedin -->
                    <div class="form-group">
                        <label for="linkedin">Linkedin</label>
                        <input type="text" name="linkedin" value="{{ $userDetails->linkedin }}" class="form-control @error('linkedin') is-invalid @enderror" id="linkedin" placeholder="Linkedin">
                        @error('linkedin')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                
                    <!-- Update Button -->
                    <div class="form-group text-right">
                        <input type="submit" name="submit" class="btn btn-primary btn-md" value="Update">
                    </div>
                </form>                

            </div>
        </div>

    </div>
</section>

@endsection
