<?php

namespace App\Http\Controllers;

use App\Models\Job\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');  
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $duplicates = DB::table('searches') // 'searches' table se data ko query karte hain
        ->select('keyword', DB::raw('COUNT(*) as count')) // 'keyword' ko select karte hain aur COUNT(*) ko 'count' ke naam se show karte hain
        ->groupBy('keyword') // 'keyword' ke basis par group banate hain
        ->havingRaw('COUNT(*) > 1') // Sirf un groups ko rakhte hain jahan keyword ka count 1 se zyada hai (matlab duplicate keywords)
        ->take(3) // Sirf top 3 results ko retrieve karte hain
        ->orderBy('count', 'asc') // 'count' ke basis par ascending order (chhoti se badi) mein sort karte hain
        ->get(); // Query execute karke results ko retrieve karte hain



        $jobs = Job::select()->take(5)->orderBy('id', 'desc')->get();
        $totaljobs = Job::all()->count();
        return view('home', compact('jobs', 'totaljobs', 'duplicates'));
    }
    public function about()
    {
        return view('pages.about');
    }
    public function contact()
    {
        return view('pages.contact');
    }
    
}
