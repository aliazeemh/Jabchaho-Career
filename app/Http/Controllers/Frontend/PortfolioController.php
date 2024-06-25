<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CandidatePortfolioAttachment;
use App\Models\CandidatePortfolio;
use App\Helpers\Helper;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Frontend\CandidatePortfolioDetailRequest;

class PortfolioController extends ProfileController
{
   /**
    * Profile Page --portfolio Form --
    *
    * @param Request $request
    *
    * @return \Illuminate\Http\Response
    */
    public function portfolioForm(Request $request)
    {
        $candidateId  = Auth::guard('candidate')->user()->id;

        $candidatePortfolioAttachmentsObject    = new CandidatePortfolioAttachment();
        $candidatePortfolioObject              = new CandidatePortfolio();

        $data['booleanOptions']       = config('constants.boolean_options'); 

        $data['candidateAttachments']       =  $candidatePortfolioAttachmentsObject->getCandidatePortfolioAttachmentsByCandidateId($candidateId);
        $data['candidatePortfolioDetail']   =  $candidatePortfolioObject->getCandidatePortfolioDetailByCandidateId($candidateId);
        
        return view('frontend.candidates.profile.portfolio')->with($data);
    }
    
    /**
     * Handle Diploma save request
     *
     * @param CandidatePortfolioDetailRequest $request
     *
     * @return \Illuminate\Http\Response
     */

    public function portfolio(CandidatePortfolioDetailRequest $request)
    {
        try
		{
        
            $validateValues = $request->validated();
            $isPortfolioSaved             = Arr::get($validateValues, 'is_portfolio_saved');

            if (!empty($validateValues))
            {
                $candidateId            = Auth::guard('candidate')->user()->id;
                //$diplomaId              = Arr::get($validateValues, 'id');

                $title                  = Arr::get($validateValues, 'title');
                $url                    = Arr::get($validateValues, 'url');

                $candidatePortfolio = array();
                if(!empty($title)){
                    foreach($title  as $key=>$value){

                        if(!empty($title[$key]) || !empty($url[$key])){

                            $candidatePortfolio[] = array(
                                'candidate_id'      => $candidateId,
                                'title'             => $title[$key],
                                'url'               => $url[$key],
                            );

                        }

                    }

                    CandidatePortfolio::where(['candidate_id'=> $candidateId])->delete();

                    $candidatePortfolioAttachmentsCount =CandidatePortfolioAttachment::where(['candidate_id'=> $candidateId])->count();
                    $candidatePortfolioCount =CandidatePortfolio::where(['candidate_id'=> $candidateId])->count();
                }
                
                #if not empty then delete all and add.
                if(!empty($candidatePortfolio)){
                  
                    CandidatePortfolio::insert($candidatePortfolio);   
                }
                $params = array('fieldName' => 'is_portfolio_saved', 'fieldValue'=>$isPortfolioSaved);
                $this->updateProfileFlag($params);

                return redirect(route('view.profile'))->with('success', "Portfolio details Saved successfully.");

            }else{
                return false;
            }
        }catch(\Exception $e)
        {
            return $this->getCustomExceptionMessage($e);
        }
       
    }

}
