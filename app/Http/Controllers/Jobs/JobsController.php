<?php

namespace App\Http\Controllers\Jobs;

use App\Models\Job\Job;
use App\Models\Job\Search;
use App\Models\Job\JobSaved;
use Illuminate\Http\Request;
use App\Models\Job\Application;
use App\Models\Category\Category;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JobsController extends Controller
{
    public function single($id)
    {
        // Fetch the job by its ID
        $job = Job::find($id);
        $totaljobs = Job::all();

        if (!$job) {
            abort(404); // Optional: Handle the case where the job is not found
        }

        // Get related jobs based on the same category, excluding the current job
        $relatedJobs = Job::where('category', $job->category)
            ->where('id', '!=', $id) // Exclude the current job
            ->take(5) // Limit the number of related jobs to 5
            ->get();

        // Count all related jobs (excluding the current job)
        $relatedJobsCount = Job::where('category', $job->category)
            ->where('id', '!=', $id)
            ->count();        

        // Categories with job counts
        $categories = DB::table('categories')
        ->join('jobs', 'jobs.category', '=', 'categories.name')
        ->select('categories.id', 'categories.name', DB::raw('COUNT(jobs.category) AS total'))
        ->groupBy('categories.id', 'categories.name')
        ->get();

            // Save Jobs
        if(auth::user()){
            
            $savedJob = JobSaved::where('job_id', $id)
            ->where('user_id', Auth::user()->id)
            ->count();

            // Verfining if user applied to job
            
            $appliedJob = Application::where('user_id', Auth::user()->id)
            ->where('job_id', $id)
            ->count();
        
        
        // Pass data to the view
        return view('jobs.single', compact('job', 'relatedJobs', 'relatedJobsCount', 'savedJob', 'appliedJob', 'categories'));

        } else {
            return view('jobs.single', compact('job', 'relatedJobs', 'relatedJobsCount', 'categories'));
        } 
    
    }

    public function saveJob(Request $request) {

            $saveJob = JobSaved::create([
                'job_id' => $request->job_id,
                'user_id' => $request->user_id,
                'job_image' => $request->job_image,
                'job_title' => $request->job_title,
                'job_region' => $request->job_region,
                'job_type' => $request->job_type,
                'company' => $request->company,
            ]);

        if($saveJob)    {
            return redirect()->route('single.job', ['id' => $request->job_id])->with('success', 'Job saved successfully');
        }
    }

    public function jobApply(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'job_id' => 'required|integer|exists:jobs,id',
            'job_image' => 'required|string',
            'job_title' => 'required|string',
            'job_region' => 'required|string',
            'job_type' => 'required|string',
            'company' => 'required|string',
        ]);

        // Check if the user has uploaded a CV
        if (Auth::user()->cv == "") {
            return redirect()->route('single.job', ['id' => $request->job_id])
                ->with('apply', 'Upload your CV first on the profile page.');
        }

        // Create the job application
        $applyJob = Application::create([
            'user_id' => Auth::user()->id,
            'job_id' => $request->job_id,
            'cv' => Auth::user()->cv,
            'job_image' => $request->job_image,
            'job_title' => $request->job_title,
            'email' => Auth::user()->email,
            'job_region' => $request->job_region,
            'job_type' => $request->job_type,
            'company' => $request->company,
        ]); 

        // Redirect with success message if the application was successful
        if ($applyJob) {
            return redirect()->route('single.job', ['id' => $request->job_id])
            ->with('applied', 'You have applied for this job successfully.');
        
        }

        // Redirect with an error message if the application was not successful
        return redirect('/job/single/' . $request->job_id)
            ->with('apply', 'There was an error applying for this job. Please try again.');
    }

    public function search(Request $request)
    {
        // Initialize the query
        $query = Job::query();
    
        // Log the search keyword
        Search::create([
            'keyword' => $request->job_title
        ]);
    
        // Apply filters based on user input
        if ($request->filled('job_title')) {
            $query->where('job_title', 'like', '%' . $request->job_title . '%');
        }
    
        if ($request->filled('job_region') && $request->job_region != 'Anywhere') {
            $query->where('job_region', 'like', '%' . $request->job_region . '%');
        }
    
        if ($request->filled('job_type')) {
            $query->where('job_type', 'like', '%' . $request->job_type . '%');
        }
    
        // Execute the query and get the results
        $searches = $query->get();
    
        // Return the view with search results
        return view('jobs.search', compact('searches'));
    }
    


}
