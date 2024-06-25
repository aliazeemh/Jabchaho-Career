<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipAndGuide;

class TipAndGuideController extends Controller
{
   /**
     * Tips and Guides Page
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
   
    public function index($slug='')
    {
        try
		{ 
            $tipsAndGuidesObject = new TipAndGuide();

            $data= array();
            $data['tipAndGuideRow'] = $tipsAndGuidesObject->getTipsAndGuidesBySlug($slug);
            $data['tipsAndGuides']  = $tipsAndGuidesObject->getAllTipsAndGuides();

            return view('frontend.candidates.tips_and_guides.index')->with($data);

        }
        catch(\Exception $e)
        {
            return $this->getCustomExceptionMessage($e);
        }
   
    }
}
