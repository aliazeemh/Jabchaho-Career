<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\CandidateExperience;
use App\Models\CandidateEducation;
use App\Models\CandidateDiploma;
use App\Models\CandidateCertification;
use App\Models\CandidatePortfolio;
use App\Models\CandidateSkillSet;
use App\Models\CandidateDetail;
use App\Models\CandidateFamilyDetails;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ViewProfileController extends ProfileController
{
   public function index(Request $request)
   {
        $data = array();
        
        $candidateId                        = Auth::guard('candidate')->user()->id;
        
        $candidateObject                    = new Candidate();

        $data = $candidateObject->getCandidateProfileData($candidateId);
        return view('frontend.candidates.profile.view')->with($data);
   }
}
