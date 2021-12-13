<?php
namespace App\Traits;
use Auth;
use App\Models\Batch;
use App\Models\Course;
use Illuminate\Support\Str;
use App\Models\StudentPayment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait PortalHelperModel
{
	public function paginationResponse($total_pages, $page, $countTotalItems, $limit){	
		return collect([
			'total_pages' 	=> $total_pages > 0 ? strval($total_pages) : 1,
			'current_page' 	=> $page,
			'requested_page'=> strval($page > 0 && $page < $total_pages ? ($page + 1) : 1),
			'total_items' 	=> strval($countTotalItems),
			'per_page' 		=> strval($limit)
		]);
	}

	public function courseList($page=1, $limit=20, $type, $my=""){ 
        // $type = 'Featured', //  'Completed','Running','Upcoming'
        try{
			$studentId 		= (Auth::check())?Auth::user()->student_id:"";
			if($my!=""){
				$batchesQuery   = Batch::with('course','batch_fees', 'course.units')
								->whereHas('students',	function ($query) use ($studentId) {
									$query/*->where('batch_students.status','Active')*/->where('student_id',$studentId);
								})
								->with(['students'=> function($q) use ($studentId){
                                      $q->where('student_id',$studentId);
                                }]);
				$batchesQuery 	= ($type=='Registered')?$batchesQuery->where('running_status','!=','Completed'):$batchesQuery->where('running_status','Completed');
				
				$batchesQuery->where('status','Active');
			}
			else{
				if($studentId!="")
					$batchesQuery   = Batch::with('course','batch_fees', 'course.units')
									->with(['students' => 	function ($query) use ($studentId) {
										$query->where('student_id',$studentId);
									}]);
				else
					$batchesQuery   = Batch::with('course','batch_fees', 'course.units','students');
									/*->with(['students' => 	function ($query) use ($studentId) {
										$query->where('student_id',$studentId);
									}]);*/
									
				$batchesQuery 	= ($type=='Featured')?$batchesQuery->where('featured','Yes'):$batchesQuery->where('running_status',$type)->where('status','Active');
			}
			
            $totalBatches   = $batchesQuery->count();
            $batches        = $batchesQuery->orderBy('created_at','desc')->limit($limit)->offset(($page - 1) * $limit)->get();
			
			//dd($batches);
			/*foreach($batches as $batch){
				dd($batch->students[0]);
			}*/
		
			$total_pages 	= ($totalBatches > 0 ? ceil($totalBatches / $limit) : 0);
            $paginationData = $this->paginationResponse($total_pages, $page, $totalBatches, $limit);
			return array('batches'=>$batches, 'paging'=>$paginationData);


        }catch(\Exception $e){
            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
			echo $message;
			//return $this->errorResponse($message,404);
        }
    }

	
	public function courseDetailsByBatchId($batchId){ 
        try{
			if (Auth::check()){
				$studentId 		= Auth::user()->student_id;
				$batch   = Batch::with('course','batch_fees','batch_fees.installments', 'course.units')
										->with(['students' => 	function ($query) use ($studentId) {
											$query->where('student_id',$studentId); //->where('batch_students.status','Active');
										}])
										->find($batchId);
			}
			else
				$batch   = Batch::with('course','batch_fees','batch_fees.installments', 'course.units','students')->find($batchId);
									 
			//$payments = "";
			if($batch->students->count()  >0){
				$enrollmentId 	= $batch->students[0]->pivot->id;
				$batch['payments']		=StudentPayment::with('enrollment','enrollment.batch_fee','enrollment.batch_fee.installments')->where('student_enrollment_id',$enrollmentId)->get();
			}
			//dd($batch);
			return $batch;
        }catch(\Exception $e){
			return 0;
        }
    }	
}
