<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\JobApplicationController;
use App\Http\Controllers\admin\JobController;
use App\Http\Controllers\admin\JobTypeController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\ResumeController;
use App\Models\Category;
use App\Models\JobType;
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



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [JobsController::class, 'index'])->name('jobs');
Route::get('/jobs/detail/{id}', [JobsController::class, 'detail'])->name('jobDetail');
Route::post('/apply-job', [JobsController::class, 'applyJob'])->name('applyJob')->middleware('auth');
Route::post('/save-job', [JobsController::class, 'saveJob'])->name('saveJob')->middleware('auth');

Route::get('/forgot-password', [AccountController::class, 'forgotPassword'])->name('account.forgotPassword');
Route::post('/process-forgot-password', [AccountController::class, 'processForgotPassword'])->name('account.processForgotPassword');
Route::get('/reset-password/{token}',[AccountController::class,'resetPassword'])->name('account.resetPassword');
Route::post('/process-reset-password',[AccountController::class,'processResetPassword'])->name('account.processResetPassword');

Route::group(['prefix' => 'admin', 'middleware' => 'checkRole'], function(){
    Route::get('/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');

    Route::get('/users',[UserController::class,'index'])->name('admin.users');
    Route::get('/users/{id}',[UserController::class,'edit'])->name('admin.users.edit');
    Route::put('/users/{id}',[UserController::class,'update'])->name('admin.users.update');
    Route::delete('/users',[UserController::class,'delete'])->name('admin.users.delete');

    Route::get('/jobs',[JobController::class,'index'])->name('admin.jobs');
    Route::get('/jobs/edit/{id}',[JobController::class,'edit'])->name('admin.jobs.edit');
    Route::put('/jobs/{id}',[JobController::class,'update'])->name('admin.jobs.update');
    Route::delete('/jobs',[JobController::class,'delete'])->name('admin.jobs.delete');

    Route::get('/job-applications',[JobApplicationController::class,'index'])->name('admin.jobApplications');
    Route::delete('/job-applications',[JobApplicationController::class,'delete'])->name('admin.jobApplication.delete');

    Route::get('/categories',[CategoryController::class,'index'])->name('admin.categories');
    Route::get('admin/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('admin/categories/save', [CategoryController::class, 'saveCategroy'])->name('admin.categories.save');
    Route::get('/categories/{id}',[CategoryController::class,'edit'])->name('admin.categories.edit');
    Route::put('/categories/{id}',[CategoryController::class,'update'])->name('admin.categories.update');
    Route::delete('/categories',[CategoryController::class,'delete'])->name('admin.categories.delete');

    Route::get('/jobtypes',[JobTypeController::class,'index'])->name('admin.jobtypes');
    Route::get('admin/jobtypes/create', [JobTypeController::class, 'create'])->name('admin.jobtypes.create');
    Route::post('admin/jobtypes/save', [JobTypeController::class, 'saveJobType'])->name('admin.jobtypes.save');
    Route::get('/jobtypes/{id}',[JobTypeController::class,'edit'])->name('admin.jobtypes.edit');
    Route::put('/jobtypes/{id}',[JobTypeController::class,'update'])->name('admin.jobtypes.update');
    Route::delete('/jobtypes',[JobTypeController::class,'delete'])->name('admin.jobtypes.delete');
});

Route::group(['prefix' => 'account'], function(){
    Route::group(['middleware' => 'guest'], function(){
        Route::get('/register',[AccountController::class,'registration'])->name('account.registration');
        Route::post('/process-register',[AccountController::class,'processRegistration'])->name('account.processRegistration');
        Route::get('/login',[AccountController::class,'login'])->name('account.login');
        Route::post('/authenticate',[AccountController::class,'authenticate'])->name('account.authenticate');
    });

    Route::group(['middleware' => 'auth'], function(){
        Route::get('/profile',[AccountController::class,'profile'])->name('account.profile');
        Route::put('/update-profile',[AccountController::class,'updateProfile'])->name('account.updateProfile');
        Route::get('/logout',[AccountController::class,'logout'])->name('account.logout');   
        Route::post('/update-profile-pic',[AccountController::class,'updateProfilePic'])->name('account.updateProfilePic'); 

        Route::get('/create-job',[AccountController::class,'createJob'])->name('account.createJob');   
        Route::post('/save-job',[AccountController::class,'saveJob'])->name('account.saveJob');

        Route::get('/my-jobs',[AccountController::class,'myJobs'])->name('account.myJobs');  
        Route::get('/my-jobs/edit/{jobId}',[AccountController::class,'editJob'])->name('account.editJob');  
        Route::post('/update-job/{jobId}',[AccountController::class,'updateJob'])->name('account.updateJob');   
        Route::post('/delete-job',[AccountController::class,'deleteJob'])->name('account.deleteJob'); 

        Route::get('/my-job-applications',[AccountController::class,'myJobApplications'])->name('account.myJobApplications');  
        Route::post('/remove-job-application',[AccountController::class,'removeJobs'])->name('account.removeJobs');

        Route::get('/saved-jobs',[AccountController::class,'savedJobs'])->name('account.savedJobs');  
        Route::post('/remove-saved-job',[AccountController::class,'removeSavedJob'])->name('account.removeSavedJob');

        Route::post('/update-password',[AccountController::class,'updatePassword'])->name('account.updatePassword'); 
        
        
        Route::get('/resume', [ResumeController::class, 'index'])->name('account.resume');
        Route::get('/resume/{id}', [ResumeController::class, 'view'])->name('resume.view');
        Route::get('/create', [ResumeController::class, 'create'])->name('resume.create');
        Route::post('/save', [ResumeController::class, 'save'])->name('save');
        Route::delete('/resume',[ResumeController::class,'delete'])->name('resume.delete');


        
    });
});