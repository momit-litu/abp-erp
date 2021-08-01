<?php
namespace App\Traits;
use App\Models\Batch;
use App\Models\Course;

use Illuminate\Support\Str;
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

	public function courseList($page=1, $limit=20, $type){ 
        // $type = 'Featured', //  'Completed','Running','Upcoming'
        try{
			$batchesQuery   = Batch::with('course','batch_fees', 'course.units');
		
			$batchesQuery 	= ($type=='Featured')?$batchesQuery->where('featured','Yes'):$batchesQuery->where('running_status',$type)->where('status','Active');
			
            $totalBatches   = $batchesQuery->count();
            $batches        = $batchesQuery->orderBy('created_at','desc')->limit($limit)->offset(($page - 1) * $limit)->get();
			
			$total_pages 	= ($totalBatches > 0 ? ceil($totalBatches / $limit) : 0);
            $paginationData = $this->paginationResponse($total_pages, $page, $totalBatches, $limit);
			return array('batches'=>$batches, 'paging'=>$paginationData);


        }catch(\Exception $e){
            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
			return $this->errorResponse($message,404);
        }
    }

	
	public function courseDetailsByBatchId($batchId){ 
        try{
			$batchesQuery   = Batch::with('course','batch_fees','batch_fees.installments', 'course.units')->first();
			return $batchesQuery;


        }catch(\Exception $e){
            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
			return $this->errorResponse($message,404);
        }
    }
	

    public function getBatchList($param){
		
		return true;
	}

}
