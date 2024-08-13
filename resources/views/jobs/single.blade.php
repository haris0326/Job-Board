@extends('layouts.app')

@section('content')

<!-- HOME -->
<section class="section-hero overlay inner-page bg-image" style="margin-top: -24px; background-image: url({{ asset('assets/images/hero_1.jpg') }}); id="home-section">
    <div class="container">
      <div class="row">
        <div class="col-md-7">
          <h1 class="text-white font-weight-bold">{{ $job->job_title }}</h1>
          <div class="custom-breadcrumbs">
            <a href="#">Home</a> <span class="mx-2 slash">/</span>
            <a href="#">Job</a> <span class="mx-2 slash">/</span>
            <span class="text-white"><strong>{{ $job->job_title }}</strong></span>
          </div>
        </div>
      </div>
    </div>
  </section>


  <section class="site-section">
      <div class="container">

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('apply'))
        <div class="alert alert-success">
            {{ session('apply') }}
        </div>
    @endif

    @if (session('applied'))
        <div class="alert alert-success">
            {{ session('applied') }}
        </div>
    @endif
    

      <div class="row align-items-center mb-5">
        <div class="col-lg-8 mb-4 mb-lg-0">
          <div class="d-flex align-items-center">
            <div class="border p-2 d-inline-block mr-3 rounded image-container">
              <img src="{{ asset('assets/images/' . $job->image) }}" alt="Image" class="img-small img-fluid">
          </div>
          
          
            <div>
              <h2>{{ $job->job_title }}</h2>
              <div>
                <span class="ml-0 mr-2 mb-2"><span class="icon-briefcase mr-2"></span>{{ $job->company }}</span>
                <span class="m-2"><span class="icon-room mr-2"></span>{{ $job->job_region }}</span>
                <span class="m-2"><span class="icon-clock-o mr-2"></span><span class="text-primary">{{ $job->job_type }}</span></span>
              </div>
            </div>
          </div>
        </div>
  
      <div class="row">
        <div class="col-lg-8">
          <div class="mb-5">
            <figure class="mb-5"><img src="{{ asset('assets/images/job_single_img_1.jpg') }}" alt="Image" class="img-fluid rounded"></figure>
            <h3 class="h5 d-flex align-items-center mb-4 text-primary"><span class="icon-align-left mr-3"></span>Job Description</h3>
                {{ $job->jobdescription }}
          </div>
          <div class="mb-5">
            <h3 class="h5 d-flex align-items-center mb-4 text-primary"><span class="icon-rocket mr-3"></span>Responsibilities</h3>
            <ul class="list-unstyled m-0 p-0">
              <li class="d-flex align-items-start mb-2"><span class="icon-check_circle mr-2 text-muted"></span><span>{{ $job->responsibilities }}</span></li>
            </ul>
          </div>

          <div class="mb-5">
            <h3 class="h5 d-flex align-items-center mb-4 text-primary"><span class="icon-book mr-3"></span>Education + Experience</h3>
            <ul class="list-unstyled m-0 p-0">
              <li class="d-flex align-items-start mb-2"><span class="icon-check_circle mr-2 text-muted"></span><span> {{ $job->education_experience }} </span></li>
             </ul>
          </div>

          <div class="mb-5">
            <h3 class="h5 d-flex align-items-center mb-4 text-primary"><span class="icon-turned_in mr-3"></span>Other Benifits</h3>
            <ul class="list-unstyled m-0 p-0">
              <li class="d-flex align-items-start mb-2"><span class="icon-check_circle mr-2 text-muted"></span><span>{{ $job->otherbenifits }}</span></li>
            </ul>
          </div>

          <div class="row mb-5">
            <div class="col-6">
              @if (isset(Auth::user()->id))
                  
              <form action="{{ route('save.job') }}" method="POST">
                @csrf
                
                <input type="hidden" name="job_id" value="{{ $job->id }}">
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <input type="hidden" name="job_image" value="{{ $job->image }}">
                <input type="hidden" name="job_title" value="{{ $job->job_title }}">
                <input type="hidden" name="job_region" value="{{ $job->job_region }}">
                <input type="hidden" name="job_type" value="{{ $job->job_type }}">
                <input type="hidden" name="company" value="{{ $job->company }}">
              
              
                @if($savedJob > 0)
                   
                    <button type="submit" class="btn btn-block btn-light btn-md" disabled>
                        <i class="icon-heart"></i> Job Saved
                    </button>

                @else

                    <button type="submit" class="btn btn-block btn-light btn-md">
                        <i class="icon-heart"></i> Save Job
                    </button>

                @endif

            </form>
            
            @endif 
            
              <!--add text-danger to it to make it read-->
            </div>
            <div class="col-6">

              <form action="{{ route('apply.job') }}" method="POST" enctype="multipart/form-data">
                @csrf
            
                <!-- Hidden fields for job details -->
                <input type="hidden" name="job_id" value="{{ $job->id }}">
                <input type="hidden" name="job_image" value="{{ $job->image }}">
                <input type="hidden" name="job_title" value="{{ $job->job_title }}">
                <input type="hidden" name="job_region" value="{{ $job->job_region }}">
                <input type="hidden" name="job_type" value="{{ $job->job_type }}">
                <input type="hidden" name="company" value="{{ $job->company }}">

                @if (isset(Auth::user()->id))
                @if ($appliedJob > 0)
                <button class="btn btn-block btn-primary btn-md" disabled>You applied for this job</button>
                @else
                <button type="submit" name="submit" class="btn btn-block btn-primary btn-md">Apply Now</button>
                @endif
                @else
                  <a href="{{ route('login') }}" class="btn btn-block btn-primary btn-md">You applied for this job</a>
                @endif

            </form>            

            </div>
          </div>

        </div>
        <div class="col-lg-4">
          <div class="bg-light p-3 border rounded mb-4">
            <h3 class="text-primary  mt-3 h5 pl-3 mb-3 ">Job Summary</h3>
            <ul class="list-unstyled pl-3 mb-0">
              <li class="mb-2"><strong class="text-black">Published on:</strong> {{ $job->created_at }} </li>
              <li class="mb-2"><strong class="text-black">Vacancy:</strong> {{ $job->vacancy }}</li>
              <li class="mb-2"><strong class="text-black">Employment Status:</strong>{{ $job->job_type}}</li>
              <li class="mb-2"><strong class="text-black">Experience:</strong>{{ $job->experience }}</li>
              <li class="mb-2"><strong class="text-black">Job Location:</strong>{{ $job->job_region}}</li>
              <li class="mb-2"><strong class="text-black">Salary:</strong> {{ $job->salary }} </li>
              <li class="mb-2"><strong class="text-black">Gender:</strong> {{ $job->gender }} </li>
              <li class="mb-2"><strong class="text-black">Category:</strong> {{ $job->category }} </li>
              <li class="mb-2"><strong class="text-black">Application Deadline:</strong> {{ $job->application_deadline }} </li>
              
            </ul>
          </div>

          <div class="bg-light p-3 border rounded">
            <h3 class="text-primary  mt-3 h5 pl-3 mb-3 ">Share</h3>
            <div class="px-3">
              <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('single.job', $job->id)) }}&quote={{ urlencode($job->job_title) }}" class="pt-3 pb-3 pr-3 pl-0">
                <span class="icon-facebook"></span>
            </a>            
            <a href="https://twitter.com/intent/tweet?text={{ urlencode($job->job_title) }}&url={{ urlencode(route('single.job', $job->id)) }}" class="pt-3 pb-3 pr-3 pl-0" target="_blank">
              <span class="icon-twitter"></span>
            </a>          
          
          <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('single.job', $job->id)) }}&title={{ urlencode($job->job_title) }}" class="pt-3 pb-3 pr-3 pl-0" target="_blank">
            <span class="icon-linkedin"></span>
        </a>
        
        
            </div>
          </div>

          <div class="bg-light p-3 border mt-5 rounded mb-4">
            <h3 class="text-primary mt-3 h5 pl-3 mb-3">Categories</h3>
            <ul class="list-unstyled pl-3 mb-0">
                @foreach ($categories as $category)
                    <li class="mb-2">
                        <a class="text-decoration-none text-primary" href="{{ route('categories.single', $category->name) }}">
                            {{ $category->name }} ({{ $category->total }})
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        

        </div>
      </div>
    </div>
  </section>

  <section class="site-section" id="next">
    <div class="container">

        <div class="row mb-5 justify-content-center">
            <div class="col-md-7 text-center">
                <h2 class="section-title mb-2">{{ $relatedJobsCount }} Related Jobs</h2>
            </div>
        </div>
        
      
       <ul class="job-listings mb-5">
    @foreach ($relatedJobs as $relatedJob)
        <li class="job-listing d-block d-sm-flex pb-3 pb-sm-0 align-items-center">
            <a href="{{ route('single.job', $relatedJob->id) }}"></a>
            <div class="job-listing-logo">
                <img src="{{ asset('assets/images/'.$relatedJob->image) }}" alt="Image" class="img-fluid">
            </div>
            <div class="job-listing-about d-sm-flex custom-width w-100 justify-content-between mx-4">
                <div class="job-listing-position custom-width w-50 mb-3 mb-sm-0">
                    <h2>{{ $relatedJob->job_title }}</h2>
                    <strong>{{ $relatedJob->company }}</strong>
                </div>
                <div class="job-listing-location mb-3 mb-sm-0 custom-width w-25">
                    <span class="icon-room"></span> {{ $relatedJob->job_region }}
                </div>
                <div class="job-listing-meta">
                    <span class="badge badge-danger">{{ $relatedJob->job_type }}</span>
                </div>
            </div>
        </li>
    @endforeach

    </div>
  </section>
  

  <section class="pt-5 bg-image overlay-primary fixed overlay" style="background-image: url('images/hero_1.jpg');">
    <div class="container">
      <div class="row">
        <div class="col-md-6 align-self-center text-center text-md-left mb-5 mb-md-0">
          <h2 class="text-white">Get The Mobile Apps</h2>
          <p class="mb-5 lead text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit tempora adipisci impedit.</p>
          <p class="mb-0">
            <a href="#" class="btn btn-dark btn-md px-4 border-width-2"><span class="icon-apple mr-3"></span>App Store</a>
            <a href="#" class="btn btn-dark btn-md px-4 border-width-2"><span class="icon-android mr-3"></span>Play Store</a>
          </p>
        </div>
        <div class="col-md-6 ml-auto align-self-end">
          <img src="{{ asset('assets/images/apps.png') }}" alt="Image" class="img-fluid">
        </div>
      </div>
    </div>
  </section>

@endsection
<style>


.image-container {
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden; /* Hide any part of the image that exceeds the container size */
}

.img-small {
    width: 80px; /* Define the width you want */
    height: 80px; /* Define the height to match width */
    object-fit: cover; /* Cover the container without distortion */
}


</style>