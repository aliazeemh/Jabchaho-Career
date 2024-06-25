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

Route::group(['namespace' => 'App\Http\Controllers\Frontend\Auth','middleware' => ['candidate.guest:candidate']], function()
{
   #signup
   Route::get('/drop-your-cv', 'SignupController@signupForm')->name('drop.your.cv');
   Route::get('/signup', 'SignupController@signupForm')->name('signup.show');
   Route::post('/signup', 'SignupController@signup')->name('signup.perform');

   #signin 
   Route::get('/signin', 'SigninController@signinForm')->name('signin.show');
   Route::post('/signin', 'SigninController@signin')->name('signin.perform');

   #Forgot Password
   Route::get('/forgot-password', 'ForgotPasswordController@forgotPasswordForm')->name('forgot.password.show');
   Route::post('/forgot-password', 'ForgotPasswordController@forgotPassword')->name('forgot.password.perform');

   #Reset Password
   Route::get('reset-password/{token}', 'ResetPasswordController@resetPasswordForm')->name('reset.password.show');
   Route::post('reset-password', 'ResetPasswordController@resetPassword')->name('reset.password.perform');
   
});

#Guest For App\Http\Controllers\Frontend 
Route::group(['namespace' => 'App\Http\Controllers\Frontend'], function()
{  
   #landingPage
   Route::get('/', 'JobController@landingPage')->name('landing.page');

   #Google URL
   Route::prefix('google')->name('google.')->group( function(){
      Route::get('login', 'GoogleController@loginWithGoogle')->name('login');
      Route::any('callback', 'GoogleController@callbackFromGoogle')->name('callback');
   });
  

   // Facebook Login URL
   Route::prefix('facebook')->name('facebook.')->group( function(){
      Route::get('auth', 'FaceBookController@loginUsingFacebook')->name('login');
      Route::get('callback', 'FaceBookController@callbackFromFacebook')->name('callback');
   });

   #cms
   Route::get('/page/{url}', 'CMSController@index')->name('cms.pages');
 
   #jobs 
   Route::get('jobs/{id?}', 'JobController@index')->name('jobs.list');
   Route::get('/jobs-detail/{id?}', 'JobController@jobDetail')->name('jobs.detail');

   #Refer Candidate
   Route::get('/candidate-refer', 'CandidateReferController@candidateReferForm')->name('candidate.refer');
   Route::post('/candidate-refer', 'CandidateReferController@candidateRefer')->name('candidate.perform');
   
   #Complete Essential Profile
   Route::get('/candidate-essential-profile', 'HomeController@candidateEssentialProfileForm')->name('candidate.essential.profile');
   Route::post('/candidate-essential-profile', 'HomeController@candidateEssentialProfile')->name('candidate.essential.profile.perform');
});


Route::group(['namespace' => 'App\Http\Controllers\Frontend','middleware' => ['candidate.auth:candidate']], function()
{   
      #dashboard
      Route::get('/home', 'HomeController@index')->name('index');
     
      
      #change-password
      Route::post('/change-password', 'ChangePasswordController@changePassword')->name('change.password.perform');

      #file upload controller
      #cover image upload 
      Route::post('/cover-image-upload', 'ManageFileController@coverImageUpload')->name('cover.image.upload');
      #UpdateCoverImagePosition
      Route::post('/cover-image-position-update', 'ManageFileController@coverImagePositionUpdate')->name('cover.image.position.update');
      #remove cover image
      Route::post('/cover-image-remove', 'ManageFileController@coverImageRemove')->name('cover.image.remove');

      #profile image upload 
      Route::post('/profile-image-upload', 'ManageFileController@profileImageUpload')->name('profile.image.upload');
      Route::post('/profile-image-remove', 'ManageFileController@profileImageRemove')->name('profile.image.remove');

      #Profile
      Route::get('/view-profile', 'ViewProfileController@index')->name('view.profile');

      
      #Professional Experience
      #Create
      Route::get('/professional-experience/{id?}', 'ProfessionalExperienceController@professionalExperienceForm')->name('professional.experience.show');
      Route::match(array('PUT','POST'),'/professional-experience', 'ProfessionalExperienceController@professionalExperience')->name('professional.experience.perform');
      Route::get('/professional-experience-delete/{id}', 'ProfessionalExperienceController@delete')->name('professional.experience.delete');
            
      #Educational Qualification 
      Route::get('/educational-qualification/{id?}', 'EducationalQualificationController@educationalQualificationForm')->name('educational.qualification.show');
      Route::match(array('PUT','POST'),'/educational-qualification', 'EducationalQualificationController@educationalQualification')->name('educational.qualification.perform');
      Route::get('/educational-qualification-delete/{id}', 'EducationalQualificationController@delete')->name('educational.qualification.delete');

      #diploma
      Route::get('/diploma/{id?}', 'DiplomaController@diplomaForm')->name('diploma.show');
      Route::match(array('PUT','POST'),'/diploma', 'DiplomaController@diploma')->name('diploma.perform');
      Route::get('/diploma-delete/{id}', 'DiplomaController@delete')->name('diploma.delete');
      
      #Certification
      Route::get('/certification/{id?}', 'CertificationController@certificationForm')->name('certification.show');
      Route::match(array('PUT','POST'),'/certification', 'CertificationController@certification')->name('certification.perform');
      Route::get('/certification-delete/{id}', 'CertificationController@delete')->name('certification.delete');

      #SkillSet
      Route::get('/skill-set', 'SkillSetController@skillSetForm')->name('skillset.show');
      Route::post('/skill-set', 'SkillSetController@skillSet')->name('skillset.perform');

      Route::get('skill-set-search', 'SkillSetController@skillSetSearch')->name('skillset.search');

      #Portfolio 
      Route::get('/portfolio', 'PortfolioController@portfolioForm')->name('portfolio.show');
      Route::post('/portfolio', 'PortfolioController@portfolio')->name('portfolio.perform');
      #files upload
      Route::post('/portfolio-attachments-upload', 'ManageFileController@portfolioAttachmentsUpload')->name('portfolio.attachments.upload');
      Route::get('/attachment-delete/{id}', 'ManageFileController@portfolioAttachmentRemove')->name('attachment.delete');
      #personal detail
      Route::get('/personal-details', 'PersonalDetailController@personalDetailForm')->name('personal.details.show');
      Route::match(array('PUT','POST'),'/personal-details', 'PersonalDetailController@personalDetail')->name('personal.details.perform');

      #Referral
      Route::get('/referral', 'ReferralController@referralForm')->name('referral.show');
      Route::match(array('PUT','POST'),'/referral', 'ReferralController@referral')->name('referral.perform');

      #familydetails
      Route::get('/family-details/{id?}', 'FamilyDetailController@familyDetailForm')->name('family.details.show');
      Route::match(array('PUT','POST'),'/family-details', 'FamilyDetailController@familyDetail')->name('family.details.perform');
      Route::get('/family-details-delete/{id}', 'FamilyDetailController@delete')->name('family.details.delete');
      Route::get('/family-details-picture-remove/{id}', 'FamilyDetailController@pictureRemove')->name('family.details.picture.remove');
      
      #uploaddocuments
      Route::get('/upload-documents', 'UploadDocumentController@uploadDocumentsForm')->name('upload.documents.show');
      Route::post('/upload-documents', 'ManageFileController@uploadDocuments')->name('upload.documents.perform');
      Route::get('/document-delete/{id}', 'ManageFileController@candidateDocumentRemove')->name('document.delete');
      Route::get('/upload-documents-mark-saved', 'UploadDocumentController@uploadDocumentsMarkSaved')->name('upload.documents.mark.saved');

      #tips and Guides
      Route::get('/tips-and-guides/{slug?}', 'TipAndGuideController@index')->name('tips-and-guides.index');

      #apply for job
      Route::get('/apply-for-job/{job}', 'JobController@applyForJob')->name('apply.job');
      Route::post('/applicant-apply', 'ApplicantController@apply')->name('applicant.apply');
      Route::get('/jobs-history', 'JobController@history')->name('jobs.history');
      Route::get('/history-jobs-detail/{jobId?}', 'JobController@historyJobDetail')->name('history.jobs.detail');

      #signout
      Route::get('/signout', 'SignoutController@signout')->name('signout.perform');

      #CandidateInstituteSearch
      Route::get('institute-search', 'InstituteController@searchInstitutes')->name('institute.search');

      #FieldOfStudySearch
      Route::get('fieldofstudy-search', 'FieldOfStudyController@searchFieldOfStudy')->name('field.search');

      #CompanySearch
      Route::get('company-search', 'CompanyController@searchCompanies')->name('company.search');

      #JobTitleSearch
      Route::get('job-search', 'JobTitleController@searchjobTitle')->name('job.search');
});