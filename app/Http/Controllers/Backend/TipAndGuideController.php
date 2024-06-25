<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipAndGuide;
use Illuminate\Support\Arr;
use App\Helpers\Helper;
use App\Http\Requests\Backend\TipAndGuideRequest;

class TipAndGuideController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipsAndGuides = TipAndGuide::latest()->paginate(config('constants.per_page'));

        return view('backend.tips_and_guides.index', compact('tipsAndGuides'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.tips_and_guides.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TipAndGuideRequest $request)
    {
       #summary
       $summary = $this->fileUpload('summary',$request->summary);

       #content
       $content = $this->fileUpload('content',$request->content);

       if($request->publish){
            $publishDate  = date('Y-m-d H:i:s');
       }else{
            $publishDate = NULL;
       }
      
       TipAndGuide::create([
            'title'   => $request->title,
            'slug'    => Helper::sluggify($request->title),
            'summary' => $summary,
            'content' => $content,
            'created_by' => auth()->id(),
            'publish_date'  =>$publishDate
       ]);

        return redirect()->route('tips_and_guides.index')
            ->withSuccess(__('Tips and Guides created successfully.'));
    }

    //FileUpload
    function fileUpload($fieldName = '', $fieldData='')
    {
       
        $domObjectWithImages = $this->getDomObjectAndImagesFromString($fieldData);
        
        $domObject        = Arr::get($domObjectWithImages, 'htmlDom','');
        $imageFile        = Arr::get($domObjectWithImages, 'imageTags','');
    
        if(!empty($imageFile))
        {  
            $userId = auth()->id(); 
            $filePath = '/'.config('constants.files.tipsandguides');
           //$filePath = '/'.$uploadFolderPath; //public_path($uploadFolderPath);


            foreach($imageFile as $item => $image)
            {
                $data = $image->getAttribute('src');

                if (!str_contains($data, $filePath)) // if file uploaded and contain uploded path then skip
                {
                    list($type, $data) = explode(';', $data);
                    list(, $data)      = explode(',', $data);

                    $imgeData = base64_decode($data);
                    
                   
                    $imageName= $filePath.$fieldName."-".time().$item.'-'.$userId.'.png';
                    $path = public_path() . $imageName;
                    file_put_contents($path, $imgeData);
                    
                    $image->removeAttribute('src');
                    $image->setAttribute('src', $imageName);
                 
                }  

            }
            
        }
       
        if(is_object($domObject) && !empty($domObject)){
            return $fieldData = $domObject->saveHTML();
        }else{
            return false;
        }
        
       
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipAndGuide  $tipAndGuide
     * @return \Illuminate\Http\Response
     */
    public function show(TipAndGuide $tipAndGuide)
    {
        return view('backend.tips_and_guides.show', [
            'tipAndGuide' => $tipAndGuide
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TipAndGuide  $tipAndGuide
     * @return \Illuminate\Http\Response
     */
    public function edit(TipAndGuide $tipAndGuide)
    {
        return view('backend.tips_and_guides.edit', [
            'tipAndGuide' => $tipAndGuide
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TipAndGuide  $tipAndGuide
     * @return \Illuminate\Http\Response
     */
    public function update(TipAndGuideRequest $request, TipAndGuide $tipAndGuide)
    {
        $this->compareAndRemovedSavedImages($request->summary,$tipAndGuide->summary);
        $this->compareAndRemovedSavedImages($request->content,$tipAndGuide->content);
        
        #summary
       $summary = $this->fileUpload('summary',$request->summary);

       #content
       $content = $this->fileUpload('content',$request->content);

        if(!empty($tipAndGuide->publish_date) && !empty($request->publish))
        {
            $publishDate = $tipAndGuide->publish_date;
        }else if(empty($tipAndGuide->publish_date) && !empty($request->publish))
        {
            $publishDate  = date('Y-m-d H:i:s');
        }else{
            $publishDate  = NULL;
        }

        $tipAndGuide->update(
            [
                'title'         => $request->title,
                'slug'          => Helper::sluggify($request->title),
                'summary'       => $summary,
                'content'       => $content,
                'publish_date'  => $publishDate,
                'updated_by'    => auth()->id(),
           ]
        );

        return redirect()->route('tips_and_guides.index')
            ->withSuccess(__('Tips and Guides updated successfully.'));
    }

    #compare post and saved image and remove old file if delete from editor.
    function compareAndRemovedSavedImages($postField='',$savedField='')
    {
    
        $domObjectWithSavedImages = $this->getDomObjectAndImagesFromString($savedField);
        $domObjectWithPostImages  = $this->getDomObjectAndImagesFromString($postField);

        $savedImages              = Arr::get($domObjectWithSavedImages, 'imageTags');
        $postImages               = Arr::get($domObjectWithPostImages, 'imageTags');

        $savedImagesArray = array();
        if(!empty($savedImages))
        foreach($savedImages as $savedImage)
        {
            $savedImagesArray[] = $savedImage->getAttribute('src');
        }

        $postImagesArray = array();
        if(!empty($postImages))
        foreach($postImages as $postImage)
        {
            $postImagesArray[] = $postImage->getAttribute('src');
        }

        $resultantArray=array_diff($savedImagesArray,$postImagesArray);
       
        if(!empty($resultantArray))
        foreach($resultantArray as $image)
        {
            $fileWithPath = public_path() .$image;
            $this->removeFile($fileWithPath);
        }    
    
        return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipAndGuide  $tipAndGuide
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipAndGuide $tipAndGuide)
    {
        
        $domObjectWithSummaryImages = $this->getDomObjectAndImagesFromString($tipAndGuide->summary);
        $this->removeImages(Arr::get($domObjectWithSummaryImages, 'imageTags'));

        $domObjectWithContentImages = $this->getDomObjectAndImagesFromString($tipAndGuide->content);
        $this->removeImages(Arr::get($domObjectWithContentImages, 'imageTags'));
       
        $tipAndGuide->delete();

        return redirect()->route('tips_and_guides.index')
            ->withSuccess(__('Tips and Guides deleted successfully.'));
    }

    #get dom object with images
    public function getDomObjectAndImagesFromString($htmlString=''){
        
        //Create an array to add extracted images to.
        $domObjectWithImages = array();
        if(!empty($htmlString))
        {
            //Create a new DOMDocument object.
            $htmlDom = new \DomDocument();

            //Load the HTML string into our DOMDocument object.
            //@$htmlDom->loadHTML($htmlString);
           // @$htmlDom->loadHtml($htmlString, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
           
           @$htmlDom->loadHtml(mb_convert_encoding($htmlString, 'HTML-ENTITIES', 'UTF-8'));
           
            //Extract all img elements / tags from the HTML.
            $imageTags = $htmlDom->getElementsByTagName('img');

            $domObjectWithImages['htmlDom']     = $htmlDom;
            $domObjectWithImages['imageTags']   = $imageTags;
    
        }
        return $domObjectWithImages;
    }

    #remove Images
    function removeImages($images = array()){
        
        if(!empty($images))
        {
            foreach($images as $image){
                
                $imgSrc = public_path() .$image->getAttribute('src');
                $this->removeFile($imgSrc);
            }
        }
        
        return true;
    }


    public function removeFile($fileWithPath=''){
        
        if(\File::exists($fileWithPath)){ //image with path
            \File::delete($fileWithPath);
        }
        return true;
    }
}
