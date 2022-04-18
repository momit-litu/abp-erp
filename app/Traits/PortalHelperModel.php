<?php
namespace App\Traits;
use Auth;
use App\Models\Batch;
use App\Models\Course;
use Illuminate\Support\Str;
use App\Models\BatchStudent;
use App\Models\StudentBook;
use App\Models\StudentPayment;
use Illuminate\Support\Facades\DB;
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
                                      $q->where('student_id',$studentId)/* ->where('current_batch','Yes') */;
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
					$batchesQuery->where('draft','No');					
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

				$books  =  DB::select("SELECT bb.book_no
							FROM student_books sb
							LEFT JOIN batch_books bb ON bb.id=sb.batch_book_id
							WHERE sb.STATUS='Active' AND bb.STATUS='Active'   AND student_id=$studentId AND bb.batch_id=$batchId");
				
				$batch->books = $books;
		}
			else
				$batch   = Batch::with('course','batch_fees','batch_fees.installments', 'course.units','students')->find($batchId);
		         
				
				//dd($batch);
       
			//$payments = "";
			if($batch->students->count()  >0){
				$enrollmentId 	= $batch->students[0]->pivot->id;
				$batch['payments']		=StudentPayment::with('enrollment','enrollment.batch_fee','enrollment.batch_fee.installments')->where('student_enrollment_id',$enrollmentId)->get();
				
				if (Auth::check())
				    $resultHtml = $this->getResultList($enrollmentId);
				else
				     $resultHtml = "";
				  
				$batch['studentResultHtml']	= $resultHtml;
			}
			
					   
			return $batch;
        }catch(\Exception $e){
			return 0;
        }
    }	


	public function getResultList($enrollmentId){

		$sql = "SELECT student_no, student_id, student_name,student_enrollment_id,student_status,
		GROUP_CONCAT(student_result_details) student_result_details, batch_student_id, balance, result_published_status, certificate_status, certificate_no
		FROM (
				SELECT  s.student_no as student_no, s.name AS student_name, bs.student_enrollment_id, bs.status AS student_status, s.id as student_id, bs.id as batch_student_id, balance, result_published_status, cs.name as certificate_status, certificate_no, 
				CONCAT(bsu.id,'@', u.unit_code, '@',ifnull(rs.name,''), '@',ifnull(bsu.score,'')) AS student_result_details
				FROM batch_students bs 
				left join batch_student_units bsu ON bsu.batch_student_id=bs.id
				LEFT JOIN units u ON u.id = bsu.unit_id
				LEFT JOIN students s ON s.id = bs.student_id
				left join result_states rs ON rs.id = bsu.result 
				left join certificate_states cs ON cs.id = bs.certificate_status
				WHERE bs.id=$enrollmentId  AND bs.status = 'Active'
				ORDER BY bs.id ASC
		)A
		GROUP BY student_name 
		ORDER BY  student_name";

		$studentResults   = DB::select($sql);
		$table  = "";
		
		if(count($studentResults) > 0){
			$tableHead = $tableBody = "";
			$once= 1;
			foreach ($studentResults as $studentResult) {  
				$certificateNo = ($studentResult->certificate_no == null)?"N/P":$studentResult->certificate_no;
				$tableBody .= "<tr role='row'>
					<td class='text-center'>".$studentResult->certificate_status."</td>
					<td class='text-center'>".$certificateNo."</td>
				";
				$resultInfoArr        = explode(',',$studentResult->student_result_details);
				foreach($resultInfoArr as $resultInfo){
					$singleResultArr    = explode('@',$resultInfo);
				// $studentResultId  = $singleResultArr[0];
					$studentUnitCode  = $singleResultArr[1];
					$studentResultStatus    = ($singleResultArr[2]!="")?"<span class='text-success'>$singleResultArr[2]</span>":"<span class='text-danger'>NP</span>";
					$tableBody .= "<td class='text-center'>".$studentResultStatus."</td>";                   
					if($once)$tableHead .=  "<th class='text-center'>".$studentUnitCode."</th>";
				}
				$once =0;
				$tableBody .= "</tr>";
			}

			$table = "
			    <h5 class='card-title'>RESULTS</h5>
				<table class='table table-bordered dataTable no-footer' id='student_result_table'  style='width:100% !important' >
				<thead>
					<tr>						
						<th>Certificate Status</th>
						<th>Certificate Number</th>
						$tableHead
					</tr>
				</thead>
				<tbody>
					$tableBody
				</tbody>
			</table>
			";
		}
		return $table;
	}



}
