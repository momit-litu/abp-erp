<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use App\Models\StudentBooksFeedback;

class ResultExport implements FromCollection
{

    private $batchId;
    private $type;

    public function __construct(int $batchId, string $type)
    {
        $this->batchId  = $batchId;
        $this->type     = $type;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $sql = "SELECT student_no, student_id, student_name,student_enrollment_id,student_status,batch_name,
                GROUP_CONCAT(student_result_details) student_result_details, batch_student_id, balance, result_published_status, certificate_status
                FROM (
                        SELECT  s.student_no as student_no, s.name AS student_name, bs.student_enrollment_id, bs.status AS student_status, s.id as student_id, bs.id as batch_student_id, balance, result_published_status, cs.name as certificate_status,
                        CONCAT(bsu.id,'@', u.unit_code, '@',ifnull(rs.name,''), '@',ifnull(bsu.score,'')) AS student_result_details, 
                        CONCAT(c.short_name,', Batch:',b.batch_name) AS batch_name 
                        FROM batch_students bs 
                        left join batch_student_units bsu ON bsu.batch_student_id=bs.id
                        LEFT JOIN units u ON u.id = bsu.unit_id
                        LEFT JOIN students s ON s.id = bs.student_id
                        left join result_states rs ON rs.id = bsu.result 
                        left join certificate_states cs ON cs.id = bs.certificate_status
                        LEFT JOIN batches b ON b.id =  bs.batch_id
                        LEFT JOIN courses c ON c.id = b.course_id
                        WHERE bs.batch_id=".$this->batchId."  AND bs.status = 'Active'
                        ORDER BY bs.id ASC
                )A
                GROUP BY student_name 
                ORDER BY  student_name";
   
        $studentResults   = DB::select($sql);

        if(count($studentResults) > 0){
            $table = array();     
            $tableHead = array(); 
            $tableHead[] = "Course & Batch";
            $tableHead[] = "Student Enrollment ID";
            $tableHead[] = "Student Name";

            $once= 1;     
            foreach ($studentResults as $studentResult) {  
                $tableTR = array();
                $tableTR[] = $studentResult->batch_name;
                $tableTR[] = $studentResult->student_enrollment_id;
                $tableTR[] = $studentResult->student_name;

                $resultInfoArr = explode(',',$studentResult->student_result_details);

                foreach($resultInfoArr as $resultInfo){
                    $singleResultArr  = explode('@',$resultInfo);

                    $studentUnitCode        = $singleResultArr[1];
                    $studentResultScore     = $singleResultArr[3];
                    $tableTR[] = $studentResultScore;
                    
                    if($once){
                        $tableHead[] = "$studentUnitCode";
                    }
                }
                if($once)   $table[] = $tableHead;
                $once = 0;

                $table[] = $tableTR;
            }
        }

        //dd($table);

        $data = collect($table)->map(function($tr){
            return (Object) $tr;
        });

       // $data = (object)$data;
       // dd($data);
        return $data;
    }
}
