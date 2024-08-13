<?php

namespace App\Http\Controllers\Admins;

use App\Models\Job\Job;
use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use App\Models\Job\Application;
use App\Models\Category\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



class AdminsController extends Controller
{
    public function viewLogin(){

        return view('admins.view-login');
    }
    
   $remember_me = $request->has('remember_me') ? true : false;

        if (auth()->guard('admin')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)) {
            
            return redirect() -> route('admin.dashboard');
        }
        return redirect()->back()->with(['error' => 'error logging in']);
    }


    public function index(){

        $jobs = Job::select()->count();
        $categories = Category::select()->count();
        $admins = Admin::select()->count();
        $applications = Application::select()->count();

        return view('admins.index', compact('jobs', 'categories', 'admins', 'applications'));
    }

    public function admins(){
        
        $admins = Admin::all();

        return view('admins.AllAdmins.all-admins', compact('admins'));
    } 
    
    public function createAdmins(){
        
        return view('admins..AllAdmins.create-admins');
    }
    
    public function storeAdmins(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:8',
        ]);

        $createAdmins = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($createAdmins) {
            return redirect('admin/all-admins/')->with('create', 'Admin created successfully');
        }

        return back()->withInput()->withErrors(['msg' => 'Failed to create admin. Please try again.']);
    }

    public function displayCategories(){

        $categories = Category::all();

        return view("admins.categories.display-categories", compact('categories'));
    }

    public function createCategories()
    {
        return view('admins.categories.create-categories');
    }

    public function storeCategories(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:40',
        ]);

        // Create a new category
        $createCategory = Category::create([
            'name' => $request->input('name'),
        ]);

        // Check if the category was created successfully
        if ($createCategory) {
            return redirect()->route('display.categories')->with('create', 'Category created successfully');
        }

        // If creation fails, redirect back with an error message
        return back()->withInput()->withErrors(['msg' => 'Failed to create category. Please try again.']);
    }

    public function editCategories($id)
    
    {
        $category = Category::findOrFail($id); // Using findOrFail to handle cases where the category is not found
        return view('admins.categories.edit-categories', compact('category'));
    }


    public function updateCategories(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:40',
        ]);

        // Find the category
        $category = Category::findOrFail($id);

        // Update the category
        $category->update([
            'name' => $request->input('name'),
        ]);

        // Redirect with success message
        return redirect()->route('display.categories')->with('update', 'Category updated successfully');
    }

    public function deleteCategory($id)
    {
        // Find the category by ID
        $category = Category::find($id);

        // Check if the category exists
        if (!$category) {
            return redirect()->route('display.categories')->withErrors(['message' => 'Category not found.']);
        }

        // Delete the category
        $category->delete();

        // Redirect back with a success message
        return redirect()->route('display.categories')->with('success', 'Category deleted successfully.');
    }

    public function allJobs(){

        $displayjobs = Job::all();

        return view("admins.jobs.displayjobs", compact('displayjobs'));
    }

    public function createJobs(){

        $categories = Category::all();
        return view("admins.jobs.create-jobs", compact('categories'));
    
    }

    public function storeJobs(Request $request)
    {
        // Log the request data
        \Log::info($request->all());

        // Validate the request
        $request->validate([
            'job_title' => 'required|string|max:50',
            'job_region' => 'required|string|max:50',
            'company' => 'required|string|max:50',
            'category' => 'required|string|max:70',
            'job_type' => 'required|string|max:40',
            'gender' => 'required|string|max:10',
            'vacancy' => 'required|integer',
            'experience' => 'required|string|max:50',
            'salary' => 'required|string|max:50',
            'application_deadline' => 'required|date',
            'jobdescription' => 'required|string',
            'responsibilities' => 'required|string',
            'education_experience' => 'required|string',
            'otherbenifits' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // Handling Image Upload
        $destinationPath = 'assets/cvs/';
        $myimage = $request->image->getClientOriginalName();
        $request->image->move(public_path($destinationPath), $myimage);

        // Inserting Data
        $createJobs = Job::create([
            'job_title' => $request->job_title,
            'job_region' => $request->job_region,
            'company' => $request->company,
            'category' => $request->category,
            'job_type' => $request->job_type,
            'gender' => $request->gender,
            'vacancy' => $request->vacancy,
            'experience' => $request->experience,
            'salary' => $request->salary,
            'application_deadline' => $request->application_deadline,
            'jobdescription' => $request->jobdescription,
            'responsibilities' => $request->responsibilities,
            'education_experience' => $request->education_experience,
            'otherbenifits' => $request->otherbenifits,
            'image' => $myimage,
        ]);

        // Check if the job was created successfully
        if ($createJobs) {
            return redirect('admin/display-jobs/')->with('create', 'Job created successfully');
        }

        return back()->withInput()->withErrors(['msg' => 'Failed to create job. Please try again.']);
    }

    public function deleteJobs($id)
    {
        // Find the job by ID
        $deleteJobs = Job::find($id);

        // Check if the job exists
        if (!$deleteJobs) {
            return redirect()->route('display.jobs')->withErrors(['message' => 'Job not found.']);
        }

        // Delete the image file if it exists
        if ($deleteJobs->image && file_exists(public_path($deleteJobs->image))) {
            unlink(public_path($deleteJobs->image));
        }

        // Delete the job record
        $deleteJobs->delete();

        // Redirect back with a success message
        return redirect()->route('display.jobs')->with('success', 'Job deleted successfully.');
    }

    public function DisplayApps(){

        $displayApps = Application::all();

        return view("admins.applications.all-apps", compact('displayApps'));
    }

    public function deleteApps($id)
    {
        // Find the application by ID
        $deleteApps = Application::find($id);

        // Check if the application exists
        if (!$deleteApps) {
            return redirect()->route('display.apps')->withErrors(['message' => 'Application not found.']);
        }

        // Delete the application
        $deleteApps->delete();

        // Redirect back with a success message
        return redirect()->route('display.apps')->with('success', 'Application deleted successfully.');
    }

    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout(); // Admin guard se logout karein

        $request->session()->invalidate(); // Session ko invalidate karein
        $request->session()->regenerateToken(); // CSRF token regenerate karein

        return redirect()->route('view.login'); // Login page par redirect karein
    }

}
