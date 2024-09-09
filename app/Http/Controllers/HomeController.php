<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Location;
use App\Models\SavedJobs;
use App\Models\SearchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    // // This method will show home page
    public function index(Request $request)  {
        $categories = Category::where('status', 1)->orderBy('name', 'ASC')->take(8)->get();
        $newCategories = Category::where('status', 1)->orderBy('name', 'ASC')->get();
        $featuredJobs = Job::where('status', 1)->orderBy('created_at', 'DESC')->with('jobType','location')->where('isFeatured', 1)->take(6)->get();
        $latestJobs = Job::where('status', 1)->with('jobType', 'location')->orderBy('created_at', 'DESC')->take(5)->get();
        $locations = Location::where('status', 1)->orderBy('name', 'ASC')->take(8)->get();

        $suggestedJobs = $this->getSuggestedJobs();

        return view('front.home', [
            'categories' => $categories,
            'featuredJobs' => $featuredJobs,
            'latestJobs' =>   $latestJobs,
            'newCategories' => $newCategories,
            'locations' => $locations, 
            'suggestedJobs' => $suggestedJobs, 

        ]);
    }

    protected function getSuggestedJobs() {
        $userId = Auth::id();
        
        $savedJobs = SavedJobs::where('user_id', $userId)->with('job')->get();

        $suggestedJobs = collect();


        foreach ($savedJobs as $savedJob) {
            $savedJobData = $savedJob->job;


            $matchingJobs = Job::where('status', 1)
                ->where(function ($query) use ($savedJobData) {
                    $query->where('location_id', $savedJobData->location_id)
                          ->orWhere('category_id', $savedJobData->category_id)
                          ->orWhere('job_type_id', $savedJobData->job_type_id);
                })
                ->with('jobType', 'location')
                ->get();

            foreach ($matchingJobs as $match) {
                $score = 0;

                if ($match->location_id == $savedJobData->location_id) {
                    $score++;
                }
                if ($match->category_id == $savedJobData->category_id) {
                    $score++;
                }
                if ($match->job_type_id == $savedJobData->job_type_id) {
                    $score++;
                }

                if ($score >= 2) {

                    $suggestedJobs->push([
                        'job' => $match,
                        'score' => $score,
                    ]);
                }
            }
        }

        $sortedSuggestedJobs = $suggestedJobs->sortByDesc('score')->take(5);


        return $sortedSuggestedJobs->pluck('job')->unique('id');
    }
}

