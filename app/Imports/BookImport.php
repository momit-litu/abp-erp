<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use App\Models\StudentBook;
use App\Models\StudentBooksFeedback;
use App\Traits\StudentNotification;

use function PHPSTORM_META\map;

class BookImport implements ToModel, WithHeadingRow
{
    use StudentNotification;
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
                $statusOrFeedback = strpos($key, 'feedback');
                //feedback of the book
                if($statusOrFeedback){
                    $bookArr = explode('_feedback',$key);
                    $bookName = $bookArr[0];
                    $sql = "SELECT sb.*, bb.book_no
                        FROM batch_students bs 
                        LEFT JOIN student_books sb ON sb.batch_student_id=bs.id
                        LEFT JOIN batch_books bb ON bb.id=sb.batch_book_id
                        WHERE bs.student_enrollment_id = '$studentEnrollmentId' AND book_no='$bookName'
                        ";
                    $studentBook = DB::select($sql);
                    $data = [                   
                        'feedback'          => $value,
                        'student_book_id'   => $studentBook[0]->id,
                        'created_by'		=> Auth::user()->id
                    ];
                    StudentBooksFeedback::create($data);

                }
                else{
                    $bookName = $key;
                    $sql = "SELECT sb.*, bb.book_no
                        FROM batch_students bs 
                        LEFT JOIN student_books sb ON sb.batch_student_id=bs.id
                        LEFT JOIN batch_books bb ON bb.id=sb.batch_book_id
                        WHERE bs.student_enrollment_id = '$studentEnrollmentId' AND book_no='$bookName'
                        ";
                    $studentBook = DB::select($sql);

                    $studentBook = StudentBook::with('student', 'book','book.batch','book.batch.course')->where('id',$studentBook[0]->id)->first();
                    if($value=='Sent'){
                        $studentBook->sent_date = date('Y-m-d');
                        $studentBook->status    = 'Active';
                        $sent = $studentBook->save();
                        if($sent)
                            $this->bookSentNotificationForStudent($studentBook);  
                    }
                    else{
                        $studentBook->sent_date = Null;
                        $studentBook->status    = 'Inactive';
                        $studentBook->save();
                    }
                }
            }
        }
    }
}
