@extends('layouts.app')

@section('content')

<section class="section-hero overlay inner-page bg-image" style="background-image: url('images/hero_1.jpg');" id="home-section">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1 class="text-white font-weight-bold">Update CV</h1>
                <div class="custom-breadcrumbs">
                    <a href="#">Home</a> <span class="mx-2 slash">/</span>
                    <a href="#">Job</a> <span class="mx-2 slash">/</span>
                    <span class="text-white"><strong>Update CV</strong></span>
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
                        <h2>Update User CV</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-lg-12">
                <form class="p-4 p-md-5 border rounded" action="{{ route('update.cv') }}" enctype="multipart/form-data" method="post">
                    @csrf <!-- CSRF Token for Security -->
        
                    <!-- Name -->
                    <div class="form-group">
                        <label for="name">CV</label>
                        <input type="file" name="cv" class="form-control">
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