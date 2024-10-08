<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\JobApplicationController;
use App\Http\Controllers\admin\JobController;
use App\Http\Controllers\admin\JobTypeController;
use App\Http\Controllers\admin\LocationController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\recruiter\MyApplicantsController;
use App\Http\Controllers\recruiter\MyJobsController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\RoleChangeRequestController;
use App\Models\Category;
use App\Models\JobType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


// Home page and job-related pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [JobsController::class, 'index'])->name('jobs');
Route::get('/jobs/detail/{id}', [JobsController::class, 'detail'])->name('jobDetail');

// Email verification for users
Route::get('/email/verify/{id}/{hash}', [AccountController::class, 'verifyEmail'])->name('verification.verify');
Route::post('/resend-verification-email', [AccountController::class, 'resendVerificationEmail'])->name('account.resendVerificationEmail');
Route::get('/email/verify', function() {return view('front.account.verify_email_warning');})->middleware('auth')->name('verification.notice');
Route::get('/verify-email-warning', function() {return view('front.account.verify_email_warning');})->name('account.verifyEmailWarning');

// Forgot password and reset password
Route::get('/forgot-password', [AccountController::class, 'forgotPassword'])->name('account.forgotPassword');
Route::post('/process-forgot-password', [AccountController::class, 'processForgotPassword'])->name('account.processForgotPassword');
Route::get('/reset-password/{token}',[AccountController::class,'resetPassword'])->name('account.resetPassword');
Route::post('/process-reset-password',[AccountController::class,'processResetPassword'])->name('account.processResetPassword');

// Admin-related routes
Route::group(['prefix' => 'admin', 'middleware' => ['checkRole:admin']], function(){
    // Admin dashboard and statistics pages
    Route::get('/dashboard',[DashboardController::class,'indexAdmin'])->name('admin.dashboard');
    Route::get('/statistics', [DashboardController::class, 'statisticsAdmin'])->name('admin.statisticsAdmin');

    // Manage accounts
    Route::get('/users',[UserController::class,'index'])->name('admin.users');
    Route::get('/users/{id}',[UserController::class,'edit'])->name('admin.users.edit');
    Route::put('/users/{id}',[UserController::class,'update'])->name('admin.users.update');
    Route::delete('/users',[UserController::class,'delete'])->name('admin.users.delete');

    // Manage jobs
    Route::get('/jobs',[JobController::class,'index'])->name('admin.jobs');
    Route::get('/jobs/edit/{id}',[JobController::class,'edit'])->name('admin.jobs.edit');
    Route::put('/jobs/{id}',[JobController::class,'update'])->name('admin.jobs.update');
    Route::delete('/jobs',[JobController::class,'delete'])->name('admin.jobs.delete');

    // Manage job applications
    Route::get('/job-applications',[JobApplicationController::class,'index'])->name('admin.jobApplications');
    Route::delete('/job-applications',[JobApplicationController::class,'delete'])->name('admin.jobApplication.delete');

    // Manage categories
    Route::get('/categories',[CategoryController::class,'index'])->name('admin.categories');
    Route::get('admin/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('admin/categories/save', [CategoryController::class, 'saveCategroy'])->name('admin.categories.save');
    Route::get('/categories/{id}',[CategoryController::class,'edit'])->name('admin.categories.edit');
    Route::put('/categories/{id}',[CategoryController::class,'update'])->name('admin.categories.update');
    Route::delete('/categories',[CategoryController::class,'delete'])->name('admin.categories.delete');

    // Manage locations
    Route::get('/locations',[LocationController::class,'index'])->name('admin.locations');
    Route::get('admin/locations/create', [LocationController::class, 'create'])->name('admin.locations.create');
    Route::post('admin/locations/save', [LocationController::class, 'saveLocation'])->name('admin.locations.save');
    Route::get('/locations/{id}',[LocationController::class,'edit'])->name('admin.locations.edit');
    Route::put('/locations/{id}',[LocationController::class,'update'])->name('admin.locations.update');
    Route::delete('/locations',[LocationController::class,'delete'])->name('admin.locations.delete');

    // Manage job types
    Route::get('/jobtypes',[JobTypeController::class,'index'])->name('admin.jobtypes');
    Route::get('admin/jobtypes/create', [JobTypeController::class, 'create'])->name('admin.jobtypes.create');
    Route::post('admin/jobtypes/save', [JobTypeController::class, 'saveJobType'])->name('admin.jobtypes.save');
    Route::get('/jobtypes/{id}',[JobTypeController::class,'edit'])->name('admin.jobtypes.edit');
    Route::put('/jobtypes/{id}',[JobTypeController::class,'update'])->name('admin.jobtypes.update');
    Route::delete('/jobtypes',[JobTypeController::class,'delete'])->name('admin.jobtypes.delete');

});

// Recruiter-related routes
Route::group(['prefix' => 'recruiter', 'middleware' => ['checkRole:recruiter']], function(){
    // Recruiter dashboard and statistics pages
    Route::get('/dashboard',[DashboardController::class,'indexRecruiter'])->name('recruiter.dashboard');
    Route::get('/statistics', [DashboardController::class, 'statisticsRecruiter'])->name('recruiter.statisticsRecruiter');

    // Manage job of recruiter
    Route::get('/my-jobs',[MyJobsController::class,'myJobs'])->name('recruiter.myJobs');  
    Route::get('/my-jobs/edit/{jobId}',[MyJobsController::class,'editJob'])->name('recruiter.editJob');  
    Route::post('/update-job/{jobId}',[MyJobsController::class,'updateJob'])->name('recruiter.updateJob');   
    Route::post('/delete-job',[MyJobsController::class,'removeMyJobs'])->name('recruiter.removeMyJobs');

    // Manage applications of recruiter
    Route::get('/applications', [MyApplicantsController::class, 'showApplications'])->name('recruiter.applications');
    Route::post('/applications/approve/{id}', [MyApplicantsController::class, 'approveApplication'])->name('recruiter.applications.approve');
    Route::post('/applications/reject/{id}', [MyApplicantsController::class, 'rejectApplication'])->name('recruiter.applications.reject');
    Route::post('/delete-applications',[MyApplicantsController::class,'removeMyApplicants'])->name('recruiter.removeMyApplicants');
    Route::get('/applications/{id}/detail', [MyApplicantsController::class, 'viewApplicationDetail'])->name('recruiter.applications.detail');
    Route::get('/resume/{id}', [MyApplicantsController::class, 'viewResumeDetail'])->name('viewResumeDetail');

    // Routes require verify their email
    Route::group(['middleware' => 'verified'], function() {
        // Post Job
        Route::get('/create-job',[MyJobsController::class,'createJob'])->name('recruiter.createJob');   
        Route::post('/save-job',[MyJobsController::class,'saveJob'])->name('recruiter.saveJob');
    });
});

Route::group(['prefix' => 'account'], function() {

    // Routes require the user to be a guest
    Route::group(['middleware' => 'guest'], function(){
        Route::get('/register',[AccountController::class,'registration'])->name('account.registration');
        Route::post('/process-register',[AccountController::class,'processRegistration'])->name('account.processRegistration');
        Route::get('/login',[AccountController::class,'login'])->name('account.login');
        Route::post('/authenticate',[AccountController::class,'authenticate'])->name('account.authenticate');
    });

    // Routes require the user to be logged in but not have their email verified
    Route::group(['middleware' => ['auth']], function(){
        // If the user has not verified their email, go to the warning page
        Route::get('/verify-email-warning', function() {
            return view('front.account.verify_email_warning');
        })->name('account.verifyEmailWarning');

        // Applies to routes that users can access even without email verification
        Route::get('/profile',[AccountController::class,'profile'])->name('account.profile');
        Route::put('/update-profile',[AccountController::class,'updateProfile'])->name('account.updateProfile');
        Route::get('/logout',[AccountController::class,'logout'])->name('account.logout');
        Route::post('/update-profile-pic',[AccountController::class,'updateProfilePic'])->name('account.updateProfilePic');
        Route::post('/save-job', [JobsController::class, 'saveJob'])->name('saveJob');

        Route::get('/my-job-applications',[AccountController::class,'myJobApplications'])->name('account.myJobApplications');
        Route::post('/remove-job-application',[AccountController::class,'removeAppliedJobs'])->name('account.removeAppliedJobs');
        Route::get('/saved-jobs',[AccountController::class,'listSavedJobs'])->name('account.savedJobs');
        Route::post('/remove-saved-job',[AccountController::class,'removeSavedJob'])->name('account.removeSavedJob');
        Route::post('/update-password',[AccountController::class,'updatePassword'])->name('account.updatePassword');
      
        // Resume-related routes
        Route::get('/resume', [ResumeController::class, 'index'])->name('account.resume');
        Route::get('/resume/{id}', [ResumeController::class, 'view'])->name('resume.view');
        Route::get('/create', [ResumeController::class, 'createResume'])->name('resume.create');
        Route::post('/save', [ResumeController::class, 'saveResume'])->name('save');
        Route::get('/resume/{id}/edit', [ResumeController::class, 'editResume'])->name('resume.edit');
        Route::post('/resume/{id}/update', [ResumeController::class, 'updateResume'])->name('resume.update');
        Route::delete('/resume',[ResumeController::class,'delete'])->name('resume.delete');
        Route::get('/resumes', [ResumeController::class, 'showResume'])->name('resumes');
        Route::get('resumes/download-doc/{id}', [ResumeController::class, 'downloadDoc'])->name('resume.downloadDoc');
        Route::post('/resumes/toggle-status/{id}', [ResumeController::class, 'toggleResumeStatus'])->name('resume.toggleStatus');
        
        // Routes require verify their email
        Route::group(['middleware' => 'verified'], function() {
            Route::post('/apply-job', [JobsController::class, 'applyJob'])->name('applyJob');
        });
    });
});