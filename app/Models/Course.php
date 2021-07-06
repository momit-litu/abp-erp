<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
	protected $table ='courses';
    protected $fillable = [
        'code','title','level_id','tqt','total_credit_hour','registration_fees','status','short_name','trainers', 'accredited_by','awarder_by', 'programme_duration','course_cover_image','semester_no','semester_details', 'assessment', 'grading_system', 'objective', 'requirements','experience_required','youtube_video_link', 'glh', 'study_mode'
    ];

	
	public function level(){
		return $this->hasOne('App\Models\Level','id','level_id');
	}
	
	public function units(){
		return $this->belongsToMany('App\Models\Unit','courses_units')->withPivot('type');
	}
	/*public function student(){
		return $this->belongsToMany('App\Models\Student','center_qualifications');	
	}*/
}
