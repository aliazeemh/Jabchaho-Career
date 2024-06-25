<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
class TipAndGuide extends Model
{
    use HasFactory;

    protected $table = "tips_and_guides";


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'title','slug','summary','content','publish_date','created_by','updated_by','created_at', 'updated_at'
    ];


    function getAllTipsAndGuides()
    {
        return TipAndGuide::select('id','title','slug','summary')->whereNotNull('publish_date')->get()->toArray();
    }


    function getTipsAndGuidesBySlug($slug='')
    {
        if(empty($slug)){
            $tipAndGuideRow = TipAndGuide::select('slug')->whereNotNull('publish_date')->first();
            $slug             = Arr::get($tipAndGuideRow, 'slug');
        }
        
        return TipAndGuide::select('title','content')->where(['slug'=>$slug])->whereNotNull('publish_date')->first();
    }
}
