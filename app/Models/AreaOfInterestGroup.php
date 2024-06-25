<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaOfInterestGroup extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'area_of_interest_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'is_enabled',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function getAreaOfInterests()
    {
        $areaOfInterests = AreaOfInterestGroup::join("area_of_interest_options", "area_of_interest_groups.id", "=", "area_of_interest_options.area_of_interest_group_id")
        ->select('area_of_interest_groups.name as group_name','area_of_interest_options.id','area_of_interest_options.name')
        ->where(['area_of_interest_groups.is_enabled'=> 1, 'area_of_interest_options.is_enabled' => 1])
        ->orderBy('area_of_interest_options.area_of_interest_group_id', 'asc')
        ->get();
        return $areaOfInterests;
    }

    //Get data for options listing with group name
    public function getAreaOfInterestsOptionsWithGroupName()
    {
        $areaOfInterests = AreaOfInterestGroup::join("area_of_interest_options", "area_of_interest_groups.id", "=", "area_of_interest_options.area_of_interest_group_id")
        ->select('area_of_interest_groups.name as group_name','area_of_interest_options.id','area_of_interest_options.name','area_of_interest_options.is_enabled')
        ->orderBy('area_of_interest_options.id', 'desc')
        ->paginate(config('constants.per_page'));
        
        return $areaOfInterests;
    }

    public function getAllEnabledgetAreaOfInterestGroups(){
        $areaOfInterestGroup =  AreaOfInterestGroup::select('id','name')->where(['is_enabled' => 1])->orderBy('name', 'desc')->get();
        return $areaOfInterestGroup;
    }

}
