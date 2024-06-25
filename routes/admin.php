<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'App\Http\Controllers\Backend','prefix' => config('constants.admin_url_prefix')], function()
{   
    /**
     * Home Routes
     */
  
    Route::group(['middleware' => ['guest']], function() {

     
        /**
         * Register Routes
         */
        #Route::get('/register', 'RegisterController@show')->name('register.show');
        #Route::post('/register', 'RegisterController@register')->name('register.perform');

        /**
         * Login Routes
         */
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');

    });

    Route::group(['middleware' => ['auth', 'permission']], function() {
        /**
         * Logout Routes
         */
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');

        Route::get('/', 'HomeController@index')->name('home.index');
        Route::post('/get-jobs-graph-data', 'HomeController@getJobsGraphData')->name('jobs.graph.data');
        Route::post('/get-count-data', 'HomeController@getCountData')->name('get.count.data');


            /**
             * User Routes
             */
            Route::group(['prefix' => 'users'], function() {
                Route::get('/', 'UsersController@index')->name('users.index');
                Route::get('/create', 'UsersController@create')->name('users.create');
                Route::post('/create', 'UsersController@store')->name('users.store');
                Route::get('/{user}/show', 'UsersController@show')->name('users.show');
                Route::get('/{user}/edit', 'UsersController@edit')->name('users.edit');
                Route::patch('/{user}/update', 'UsersController@update')->name('users.update');
                Route::delete('/{user}/delete', 'UsersController@destroy')->name('users.destroy');
            });

            // // posts
            // Route::group(['prefix' => 'posts'], function() {
            //     Route::get('/', 'PostsController@index')->name('posts.index');
            //     Route::get('/create', 'PostsController@create')->name('posts.create');
            //     Route::post('/create', 'PostsController@store')->name('posts.store');
            //     Route::get('/{post}/show', 'PostsController@show')->name('posts.show');
            //     Route::get('/{post}/edit', 'PostsController@edit')->name('posts.edit');
            //     Route::patch('/{post}/update', 'PostsController@update')->name('posts.update');
            //     Route::delete('/{post}/delete', 'PostsController@destroy')->name('posts.destroy');
            // });


            // Candidates
            Route::group(['prefix' => 'candidates'], function() {
                Route::get('/', 'CandidateController@index')->name('candidates.index');
                Route::get('/create', 'CandidateController@create')->name('candidates.create');
                Route::post('/create', 'CandidateController@store')->name('candidates.store');
                Route::get('/{candidate}/show', 'CandidateController@show')->name('candidates.show');
                Route::get('/{candidate}/edit', 'CandidateController@edit')->name('candidates.edit');
                Route::patch('/{candidate}/update', 'CandidateController@update')->name('candidates.update');
                Route::delete('/{candidate}/delete', 'CandidateController@destroy')->name('candidates.destroy');
                Route::get('/document-delete/{candidateId}/{id}', 'CandidateController@candidateDocumentRemoveByIds')->name('candidate.document.delete');
                Route::get('/portfolio-delete/{candidateId}/{id}', 'CandidateController@candidatePortfolioRemoveByIds')->name('candidate.portfolio.delete');



                #review
                Route::post('/create-review', 'CandidateController@reviewStore')->name('candidates.reviewStore');
                Route::delete('/{candidateReview}/delete-review', 'CandidateController@reviewDestroy')->name('candidates.reviewDestroy');

                #phoneConversationStore
                Route::post('/create-phone-conversation', 'CandidateController@phoneConversationStore')->name('candidates.phoneConversationStore');
                Route::delete('/{candidatePhoneConversation}/delete-phone-conversation', 'CandidateController@phoneConversationDestroy')->name('candidates.phoneConversationDestroy');

                #candidate Schedule
                Route::post('/candidate-schedule', 'CandidateController@candidateScheduleStore')->name('candidates.scheduleStore');
                Route::delete('/{candidateSchedule}/delete-candidate-schedule', 'CandidateController@scheduleDestroy')->name('candidates.scheduleDestroy');

                #Referred 
                Route::get('/referred', 'CandidateReferController@index')->name('candidates.referred.index');
                Route::get('/{refercandidate}/referred/show', 'CandidateReferController@show')->name('candidates.referred.show');
            });

            //Tips and Guides
            Route::group(['prefix' => 'tips-and-guides'], function() {
                Route::get('/', 'TipAndGuideController@index')->name('tips_and_guides.index');
                Route::get('/create', 'TipAndGuideController@create')->name('tips_and_guides.create');
                Route::post('/create', 'TipAndGuideController@store')->name('tips_and_guides.store');
                Route::get('/{tipAndGuide}/show', 'TipAndGuideController@show')->name('tips_and_guides.show');
                Route::get('/{tipAndGuide}/edit', 'TipAndGuideController@edit')->name('tips_and_guides.edit');
                Route::patch('/{tipAndGuide}/update', 'TipAndGuideController@update')->name('tips_and_guides.update');
                Route::delete('/{tipAndGuide}/delete', 'TipAndGuideController@destroy')->name('tips_and_guides.destroy');
            });

            // Shifts
        Route::group(['prefix' => 'shifts'], function() {
            Route::get('/', 'ShiftController@index')->name('shifts.index');
            Route::get('/create', 'ShiftController@create')->name('shifts.create');
            Route::post('/create', 'ShiftController@store')->name('shifts.store');
            Route::get('/{shift}/show', 'ShiftController@show')->name('shifts.show');
            Route::get('/{shift}/edit', 'ShiftController@edit')->name('shifts.edit');
            Route::patch('/{shift}/update', 'ShiftController@update')->name('shifts.update');
            Route::delete('/{shift}/delete', 'ShiftController@destroy')->name('shifts.destroy');
        });

        // Area of intrest
        Route::group(['prefix' => 'area-of-interests'], function() {
            Route::get('groups/', 'AreaOfInterestController@groupIndex')->name('area_of_interest_groups.index');
            Route::get('/groups-create', 'AreaOfInterestController@groupCreate')->name('area_of_interest_groups.create');
            Route::post('/groups-create', 'AreaOfInterestController@groupStore')->name('area_of_interest_groups.store');
            Route::get('/{areaOfInterestGroup}/groups-edit', 'AreaOfInterestController@groupEdit')->name('area_of_interest_groups.edit');
            Route::patch('/{areaOfInterestGroup}/groups-update', 'AreaOfInterestController@groupUpdate')->name('area_of_interest_groups.update');
            Route::delete('/{areaOfInterestGroup}/groups-delete', 'AreaOfInterestController@groupDestroy')->name('area_of_interest_groups.destroy');


            //options
            Route::get('/options', 'AreaOfInterestController@optionIndex')->name('area_of_interest_options.index');
            Route::get('/options-create', 'AreaOfInterestController@optionCreate')->name('area_of_interest_options.create');
            Route::post('/options-create', 'AreaOfInterestController@optionStore')->name('area_of_interest_options.store');
            Route::get('/{areaOfInterestOption}/options-edit', 'AreaOfInterestController@optionEdit')->name('area_of_interest_options.edit');
            Route::patch('/{areaOfInterestOption}/options-update', 'AreaOfInterestController@optionUpdate')->name('area_of_interest_options.update');
            Route::delete('/{areaOfInterestOption}/options-delete', 'AreaOfInterestController@optionDestroy')->name('area_of_interest_options.destroy');

        });
        

        //Facilities
        Route::group(['prefix' => 'facilities'], function() {
            Route::get('groups/', 'FacilityController@groupIndex')->name('facility_groups.index');
            Route::get('/groups-create', 'FacilityController@groupCreate')->name('facility_groups.create');
            Route::post('/groups-create', 'FacilityController@groupStore')->name('facility_groups.store');
            Route::get('/{facilityGroup}/groups-edit', 'FacilityController@groupEdit')->name('facility_groups.edit');
            Route::patch('/{facilityGroup}/groups-update', 'FacilityController@groupUpdate')->name('facility_groups.update');
            Route::delete('/{facilityGroup}/groups-delete', 'FacilityController@groupDestroy')->name('facility_groups.destroy');


            //options
            Route::get('/options', 'FacilityController@optionIndex')->name('facility_options.index');
            Route::get('/options-create', 'FacilityController@optionCreate')->name('facility_options.create');
            Route::post('/options-create', 'FacilityController@optionStore')->name('facility_options.store');
            Route::get('/{facilityOption}/options-edit', 'FacilityController@optionEdit')->name('facility_options.edit');
            Route::patch('/{facilityOption}/options-update', 'FacilityController@optionUpdate')->name('facility_options.update');
            Route::delete('/{facilityOption}/options-delete', 'FacilityController@optionDestroy')->name('facility_options.destroy');
            
        });    
        //job_types
        Route::group(['prefix' => 'job-types'], function() {
            Route::get('/', 'JobTypeController@index')->name('job_types.index');
            Route::get('/create', 'JobTypeController@create')->name('job_types.create');
            Route::post('/create', 'JobTypeController@store')->name('job_types.store');
            Route::get('/{jobType}/show', 'JobTypeController@show')->name('job_types.show');
            Route::get('/{jobType}/edit', 'JobTypeController@edit')->name('job_types.edit');
            Route::patch('/{jobType}/update', 'JobTypeController@update')->name('job_types.update');
            Route::delete('/{jobType}/delete', 'JobTypeController@destroy')->name('job_types.destroy');
        });

        //home content
        Route::group(['prefix' => 'home-content'], function() {
            Route::get('/', 'HomeContentController@index')->name('home_content.index');
            Route::get('/create', 'HomeContentController@create')->name('home_content.create');
            Route::post('/create', 'HomeContentController@store')->name('home_content.store');
            Route::get('/{homeContent}/show', 'HomeContentController@show')->name('home_content.show');
            Route::get('/{homeContent}/edit', 'HomeContentController@edit')->name('home_content.edit');
            Route::patch('/{homeContent}/update', 'HomeContentController@update')->name('home_content.update');
            Route::delete('/{homeContent}/delete', 'HomeContentController@destroy')->name('home_content.destroy');
        });

        //CMS Pages
        Route::group(['prefix' => 'cms'], function() {
            Route::get('/', 'CMSController@index')->name('cms.index');
            Route::get('/create', 'CMSController@create')->name('cms.create');
            Route::post('/create', 'CMSController@store')->name('cms.store');
            Route::get('/{cms}/show', 'CMSController@show')->name('cms.show');
            Route::get('/{cms}/edit', 'CMSController@edit')->name('cms.edit');
            Route::patch('/{cms}/update', 'CMSController@update')->name('cms.update');
            Route::delete('/{cms}/delete', 'CMSController@destroy')->name('cms.destroy');
        });


         // Skill Set 
        Route::group(['prefix' => 'skill-set'], function() {
            Route::get('/', 'SkillSetController@index')->name('skill_sets.index');
            Route::get('/create', 'SkillSetController@create')->name('skill_sets.create');
            Route::post('/create', 'SkillSetController@store')->name('skill_sets.store');
            Route::get('/{skillSet}/show', 'SkillSetController@show')->name('skill_sets.show');
            Route::get('/{skillSet}/edit', 'SkillSetController@edit')->name('skill_sets.edit');
            Route::patch('/{skillSet}/update', 'SkillSetController@update')->name('skill_sets.update');
            Route::delete('/{skillSet}/delete', 'SkillSetController@destroy')->name('skill_sets.destroy');
        });


        // jobs
        Route::group(['prefix' => 'jobs'], function() {
            Route::get('/', 'JobController@index')->name('jobs.index');
            Route::get('/create', 'JobController@create')->name('jobs.create');
            Route::post('/create', 'JobController@store')->name('jobs.store');
            Route::get('/{job}/show', 'JobController@show')->name('jobs.show');
            Route::get('/{job}/edit', 'JobController@edit')->name('jobs.edit');
            Route::post('/{job}/job-comment', 'JobController@commentJob')->name('jobs.comment');
            Route::patch('/{job}/update', 'JobController@update')->name('jobs.update');
            Route::delete('/{job}/delete', 'JobController@destroy')->name('jobs.destroy');
            Route::delete('/{jobComment}/delete-job-comment', 'JobController@jobCommentDestroy')->name('jobs.commentDestroy');
        });

        //Applicants
        Route::group(['prefix' => 'applicants'], function() {
            Route::get('/', 'ApplicantController@index')->name('applicants.index');
            Route::get('/{applicant}/show', 'ApplicantController@show')->name('applicants.show');
            Route::post('/{applicant}/applicant-comment', 'ApplicantController@applicantComment')->name('applicants.comment');
            Route::delete('/{applicantComment}/delete-applicant-comment', 'ApplicantController@applicantCommentDestroy')->name('applicants.commentDestroy');
        });

        //job_benefits
        Route::group(['prefix' => 'job-benefits'], function() {
            Route::get('/', 'JobBenefitController@index')->name('job_benefits.index');
            Route::get('/create', 'JobBenefitController@create')->name('job_benefits.create');
            Route::post('/create', 'JobBenefitController@store')->name('job_benefits.store');
            Route::get('/{jobBenefit}/show', 'JobBenefitController@show')->name('job_benefits.show');
            Route::get('/{jobBenefit}/edit', 'JobBenefitController@edit')->name('job_benefits.edit');
            Route::patch('/{jobBenefit}/update', 'JobBenefitController@update')->name('job_benefits.update');
            Route::delete('/{jobBenefit}/delete', 'JobBenefitController@destroy')->name('job_benefits.destroy');
        });

        Route::resource('roles', RolesController::class);
        Route::resource('permissions', PermissionsController::class);



    });

            
});