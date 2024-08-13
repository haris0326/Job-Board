@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body">

            @if (session('create'))
            <div class="alert alert-success">
                {{ session('create') }}
            </div>
            @endif

          <h5 class="card-title mb-4 d-inline">Jobs</h5>
          <a  href="{{ route('create.jobs') }}" class="btn btn-primary mb-4 text-center float-right">Create Jobs</a>

          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">job title</th>
                <th scope="col">category</th>
                <th scope="col">company</th>
                <th scope="col">job_region</th>
                <th scope="col">delete</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($displayjobs as $job)

              <tr>
                <th scope="row">{{ $job->id }}</th>
                <td>{{ $job->job_title }}</td>
                <td>{{ $job->category }}</td>
                <td>{{ $job->company}}</td>
                <td>{{ $job->job_region }}</td>
                <td><form action="{{ route('delete.jobs', $job->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this job?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger text-center">Delete</button>
                </form>
                </td>
              </tr>

            @endforeach
            </tbody>
          </table> 
        </div>
      </div>
    </div>
  </div>



</div>

@endsection