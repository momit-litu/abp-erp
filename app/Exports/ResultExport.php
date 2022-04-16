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
        $sql = "SELECT student_name,student_enrollment_id,student_status, book_status, 
        GROUP_CONCAT(student_book_details) student_book_details, batch_name
            FROM (
                SELECT  s.name AS student_name, bb.id, bs.student_enrollment_id, bs.status AS student_status, bb.status AS book_status, 
                CONCAT(sb.id,'@', bb.book_no, '@', IFNULL(sb.sent_date,''), '@',sb.`status`) AS student_book_details,
                CONCAT(c.short_name,', Batch:',b.batch_name) AS batch_name            
                FROM batch_books bb
                LEFT JOIN student_books sb ON sb.batch_book_id = bb.id
                LEFT JOIN batch_students bs ON bs.id = sb.batch_student_id
                LEFT JOIN students s ON s.id = sb.student_id
                LEFT JOIN batches b ON b.id =  bs.batch_id
                LEFT JOIN courses c ON c.id = b.course_id
                WHERE bb.batch_id=".$this->batchId."   AND bb.status='Active'
                ORDER BY bb.id ASC
            )A
            GROUP BY student_name 
            ORDER BY  id,student_name";
   
        $studentBooks   = DB::select($sql);

        if(count($studentBooks) > 0){
            $table = array();     
            $tableHead = array(); 
            $tableHead[] = "Course & Batch";
            $tableHead[] = "Student Enrollment ID";
            $tableHead[] = "Student Name";

            $once= 1;     
            foreach ($studentBooks as $studentBook) {  
                $tableTR = array();
                $tableTR[] = $studentBook->batch_name;
                $tableTR[] = $studentBook->student_enrollment_id;
                $tableTR[] = $studentBook->student_name;

                $bookInfoArr = explode(',',$studentBook->student_book_details);

                foreach($bookInfoArr as $bookInfo){
                    $singleBookArr  = explode('@',$bookInfo);
                    $studentBookId  = $singleBookArr[0];
                    $studentBookNo  = $singleBookArr[1];
                    $studentBooKstatus  = $singleBookArr[3];
                    $tableTR[] = ($studentBooKstatus =="Active")?"Sent":"Not-Sent";
                    // for sample print feedback blank
                    // for reopprt print all feedback
                    if($this->type == 'report'){
                        $feedbackHtml = "";
                        $bookfeedbacks = StudentBooksFeedback::with('createdBy')->where('student_book_id',$studentBookId)->get();
                        //dd($bookfeedbacks);
                        if(count($bookfeedbacks)>0){
                            foreach($bookfeedbacks as $bookfeedback){
                                $feedbackHtml .=$bookfeedback->feedback." (".$bookfeedback->createdBy->first_name." @".date('Y-m-d', strToTime($bookfeedback->created_at)).")";
                            }
                        }
                        $tableTR[] = $feedbackHtml;
                    }
                    else
                        $tableTR[] = "";

                    if($once){
                        $tableHead[] = "$studentBookNo";
                        $tableHead[] = "$studentBookNo Feedback";
                    }
                }
                if($once)   $table[] = $tableHead;
                $once = 0;

                $table[] = $tableTR;
            }
        }

        $data = collect($table)->map(function($tr){
            return (Object) $tr;
        });

       // $data = (object)$data;
       // dd($data);
        return $data;
    }
}
