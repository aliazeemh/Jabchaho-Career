<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateReview extends Model
{
    use HasFactory;

     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'candidate_reviews';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'candidate_id',
        'review',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];


     /**
     * Get the phone associated with the user.
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }


    public function getCandidateReview($candidateId=0)
    {
        return CandidateReview::with('user')->where(['candidate_id' => $candidateId])->latest()->get();
    }
}



