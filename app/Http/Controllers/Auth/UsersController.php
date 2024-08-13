<?php

namespace App\Http\Controllers\Auth;

use App\Models\Job\JobSaved;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Job\Application;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function profile(){

        $profile = User::find(Auth::user()->id);

        return view('users.profile', compact('profile'));
    }

    public function applications(){

        $applications = Application::where('user_id', '=', Auth::user()->id)->get();

        return view('users.applications', compact('applications'));
    }
    
    public function savedJobs(){

        $savedJobs = JobSaved::where('user_id', '=', Auth::user()->id)->get();

        return view('users.savedjobs', compact('savedJobs'));
    }
    
    public function editDetails(){

        $userDetails = User::find(Auth::user()->id);

        return view('users.editdetails', compact('userDetails'));
    }
    
    public function updateDetails(Request $request)
    {   
        $request->validate([
            "name" => "required|max:40", // Name required hai aur 40 characters se zyada nahi hona chahiye
            "job_title" => "required|max:50", // Job Title required hai aur 50 characters se zyada nahi hona chahiye
            "bio" => "nullable|max:500", // Bio optional hai lekin agar diya gaya to 500 characters se zyada nahi hona chahiye
            "facebook" => "nullable|url", // Facebook optional hai lekin agar diya gaya to valid URL hona chahiye
            "twitter" => "nullable|url", // Twitter optional hai lekin agar diya gaya to valid URL hona chahiye
            "linkedin" => "nullable|url", // LinkedIn optional hai lekin agar diya gaya to valid URL hona chahiye
        ]);

        // Find the authenticated user
        $userDetailsUpdate = User::find(Auth::user()->id);
        
        // Check if the user exists
        if (!$userDetailsUpdate) {
            return redirect('/users/edit-details/')->with('error', 'User not found');
        }
        
        // Update user details
        $userDetailsUpdate->update([
            "name" => $request->name,
            "job_title" => $request->job_title,
            "bio" => $request->bio,
            "facebook" => $request->facebook,
            "twitter" => $request->twitter,
            "linkedin" => $request->linkedin,
        ]);
        
        // Check if update was successful
        if ($userDetailsUpdate) {
            return redirect('/users/edit-details/')->with('update', 'User updated successfully');
        } else {
            return redirect('/users/edit-details/')->with('error', 'Failed to update user details');
        }
    }

    public function editCV(){

        return view('users.editcv');
    }

    public function updateCV(Request $request)
    {
        // Pehle CV ki file ko validate karain ke wo sahi type ki hai ya nahi (jaise PDF, DOC, DOCX)
        $request->validate([
            'cv' => 'required|mimes:pdf,doc,docx|max:2048', // MIME type aur file size ka check
        ]);

        // User ka data nikaalain jo ke currently login hai
        $user = User::find(Auth::user()->id);

        // Purani CV ko delete karne se pehle check karain ke wo file mojood hai ya nahi
        if ($user->cv) {
            $file_path = public_path('assets/cvs/' . $user->cv);
            if (file_exists($file_path)) {
                unlink($file_path); // Agar file hai to usay delete kar do
            }
        }

        // Nai CV ko store karain aur uska naam unique banain (timestamp ke sath)
        $destinationPath = 'assets/cvs/';
        $mycv = time() . '_' . $request->cv->getClientOriginalName(); // Timestamp add kar ke file ka naam unique banao
        $request->cv->move(public_path($destinationPath), $mycv); // Nai CV ko public directory mein move karo

        // User ki CV ko database mein update karo
        $user->update([
            'cv' => $mycv
        ]);

        // User ko profile page par redirect karo aur success message dikhao
        return redirect('/users/profile')->with('update', 'CV Updated Successfully');
    }



}
