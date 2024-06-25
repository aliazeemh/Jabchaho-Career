<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityGroup extends Model
{
    use HasFactory;
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'facility_groups';

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

    public function getFacilityGroupWithOptions()
    {
        $facilityGroupWithOptions= FacilityGroup::join("facility_options", "facility_groups.id", "=", "facility_options.facility_group_id")
        ->select('facility_groups.name as group_name','facility_groups.id as group_id','facility_options.id','facility_options.name')
        ->where(['facility_groups.is_enabled'=> 1, 'facility_options.is_enabled' => 1])
        ->orderBy('facility_options.facility_group_id', 'asc')
        ->orderBy('facility_options.name', 'asc')
        ->get();
        return $facilityGroupWithOptions;
    }


    //Get data for options listing with group name
    public function getfacilitiesOptionsWithGroupName()
    {
        $facilityGroupWithOptions= FacilityGroup::join("facility_options", "facility_groups.id", "=", "facility_options.facility_group_id")
        ->select('facility_groups.name as group_name','facility_groups.id as group_id','facility_options.id','facility_options.name','facility_options.is_enabled')
        ->orderBy('facility_options.id', 'desc')
        ->paginate(config('constants.per_page'));
        return $facilityGroupWithOptions;
    }
}
