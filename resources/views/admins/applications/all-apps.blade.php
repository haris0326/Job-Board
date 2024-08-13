@extends('layouts.admin')
@section('content')

    <div class="row">
        <div class="col">
        <div class="card">
            <div class="card-body">
            <h5 class="card-title mb-4 d-inline">Job Applications</h5>

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">CV</th>
                    <th scope="col">Email</th>
                    <th scope="col">Job_title</th>
                    <th scope="col">View Job</th>
                    <th scope="col">Company</th>
                    <th scope="col">Delete</th>
                </tr>
                </thead>
                <tbody>

               @foreach ($displayApps as $application)
                    
               <tr>
                    <th scope="row">{{ $application->id }}</th>
                    <td><a class="btn btn-success" href="{{ asset('assets/cvs/'.$application->cv.'')}}">CV</a></td>
                    <td>{{ $application->email }}</td>
                    <td>{{ $application->job_title }}</td>
                    <td><a class="btn btn-success" href="{{ route('single.job', $application->id) }}">Go to Job</a></td>
                    
                    <td>{{ $application->company }}</td>
                    <td>
                        <form action="{{ route('delete.apps', $application->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this application?');">
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

@endsection