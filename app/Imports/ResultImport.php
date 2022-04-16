<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use App\Models\BatchStudentUnit;
use App\Models\BatchStudent;
use App\Models\ResultState;
use phpDocumentor\Reflection\Types\Null_;

use function PHPSTORM_META\map;

class ResultImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $studentEnrollmentId = $row['student_enrollment_id'];

        foreach($row as $key=>$value){
           if($key != 'course_batch' && $key != 'student_name' &&  $key != 'student_enrollment_id'){
                
                $unitName = str_replace('_',' ',$key);
                $score    = $value;

                $sql = "SELECT bsu.id as bsu_id, bs.id as bs_id
                        FROM batch_students bs 
                        LEFT JOIN batch_student_units bsu ON bsu.batch_student_id = bs.id
                        LEFT JOIN units u ON u.id = bsu.unit_id
                        WHERE bs.student_enrollment_id = '$studentEnrollmentId' AND u.unit_code='$unitName'            
                    ";

                $studentResult = DB::select($sql);
                $batchStudent  = BatchStudent::find($studentResult[0]->bs_id);
                $studentResult = BatchStudentUnit::where('id',$studentResult[0]->bsu_id)->first();
     
                if(is_numeric($score)){                    
                    $result = ResultState::where('heighest_mark','>=',$score)->where('lowest_mark','<=',$score)->first();
                    $studentResult->score   = $score;
                    $studentResult->result  = $result->id;
                    $studentResult->save();
                }
                else{
                    $studentResult->score   = '';
                    $studentResult->result  = Null;
                    $studentResult->save();
                }

                if($batchStudent->balance == 0 ) {
                    $unPublishedResult  =  BatchStudentUnit::where('batch_student_id',$batchStudentId)->whereNull('result')->first();
                    if(empty($unPublishedResult))
                        $batchStudent->certificate_status = 2;
                }
                $batchStudent->update();

            }
        }
    }
}
