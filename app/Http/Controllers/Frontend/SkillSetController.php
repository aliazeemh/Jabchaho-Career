<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SkillSet;
use App\Models\CandidateSkillSet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use App\Http\Requests\Frontend\CandidateSkillSetRequest;


class SkillSetController extends ProfileController
{
   /**
    * Profile Page --Skill Set Form --
    *
    * @param Request $request
    *
    * @return \Illuminate\Http\Response
    */
    public function skillSetForm(Request $request){     
        
        $candidateSkillSet  = new CandidateSkillSet();
        $candidateId  = Auth::guard('candidate')->user()->id;
        $data['skillSets']  = $candidateSkillSet->getCandidateSkillSetByCandidateId($candidateId);
        return view('frontend.candidates.profile.skill-set')->with($data);
    }


     /**
     * Handle Skill sets save request
     *
     * @param CandidateSkillSetRequest $request
     *
     * @return \Illuminate\Http\Response
     */

    public function skillSet(CandidateSkillSetRequest $request)
    {
        try
		{
            $validateValues = $request->validated();
            $candidateId    = Auth::guard('candidate')->user()->id;


            $skills             = Arr::get($validateValues, 'name');
           
            $candidateSkillSet = array();
           
            CandidateSkillSet::where(['candidate_id' => $candidateId])->delete();
            
            $skillSetData       = array();
            $newSkillSetData    = array();

            if(!empty($skills))
            {
                foreach($skills as $skill)
                {
                    
                    $isExistSkillSet = SkillSet::select("id")
                    ->where('name','=',$skill)
                    ->first();
                    
                    if(!empty(Arr::get($isExistSkillSet,'id')))
                    {
                        $skillSetData[] = array(
                            'candidate_id' =>$candidateId,
                            'skill_set_id' => Arr::get($isExistSkillSet,'id'),
                        );
                    }
                    else{
                        
                       $newSkillSet=  SkillSet::create(['name'=>$skill, 'is_viewable'=>0]);
                       if(!empty($newSkillSet)){
                            $skillSetData[] = array(
                                'candidate_id' =>$candidateId,
                                'skill_set_id' => Arr::get($newSkillSet,'id'),
                            );
                        }
                    }
                }
                
                $candidateSkillSet = CandidateSkillSet::insert($skillSetData);

            }

            $fieldValue = 0;
            if($candidateSkillSet)
            {
                $fieldValue = 1;
            }
             
            // if is_skill_set_saved set 
            $params = array('fieldName' => 'is_skill_set_saved', 'fieldValue'=>$fieldValue);
            $this->updateProfileFlag($params);
  

            return redirect(route('referral.show'))->with('success', "Skills Saved successfully.");
                       

        }catch(\Exception $e)
		{
			return $this->getCustomExceptionMessage($e);
            
        }	    
    } 

    /**
    * Profile Page --Skill Set Form --
    *
    * @param Request $request
    *
    * @return \Illuminate\Http\Response
    */
    public function skillSetSearch(Request $request)
    {
        $skillSets = [];

        if($request->has('q')){
            $search = $request->q;
            $skillSets =SkillSet::select("id", "name")
                    ->where('name', 'LIKE', "%$search%")
                    ->where('is_viewable','=',1)
                    ->get();
        }
        return response()->json($skillSets);
    }


}
