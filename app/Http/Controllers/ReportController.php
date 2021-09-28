<?php

namespace App\Http\Controllers;


use DB;
use Auth;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Expense;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Traits\HasPermission;
use Illuminate\Http\Response;
use App\Models\StudentPayment;
use App\Models\ExpneseCategory;


class ReportController extends Controller
{
    use HasPermission;
	
	public function __construct(Request $request)
    {
        $this->page_title = $request->route()->getName();
        $description = \Request::route()->getAction();
        $this->page_desc = isset($description['desc']) ? $description['desc'] : $this->page_title;
    }
	
    public function courseReport()
    {
        $data['page_title']     = $this->page_title;
        $data['module_name']    = "Reports";
        $data['sub_module']     = "Course Report";

        $admin_user_id          = Auth::user()->id;
        $view_action_id         = 97;
        $view_permisiion        = $this->PermissionHasOrNot($admin_user_id, $view_action_id);
        $data['actions']['view_permisiion'] = $view_permisiion;

        return view('report.course-report', $data);
    }

	public function courseReportList(Request $request)
    {
		$courseSQL  = Course::with('batches','batches.students','units','level')/*->where('status','Active')*/;
        $courses = $courseSQL->get();
        //dd($expences);
        $return_arr = array();
        foreach($courses as $course){

            $totalGlh       =0;
            $totalStudents  =0;
			foreach($course->units as $unit){
				$totalGlh += $unit['glh'];
			}
            foreach($course->batches as $batch){
				$totalStudents += count($batch['students']);
			}

			$data['code'] 		= $course->code;
            $data['title'] 		= $course->title;
			$data['tqt'] 		= $course->tqt;
			$data['level'] 		= $course->level->name;
			$data['glh'] 		= $totalGlh;
			$data['noOfUnits'] 	= count($course->units);
            $data['noOfbatches']= count($course->batches);
            $data['noOfstudents']= $totalStudents;

            $return_arr[] = $data;
        }
        return json_encode(array('data'=>$return_arr));	 
	}
 
	
    public function batchReport()
    {
        $data['page_title']     = $this->page_title;
        $data['module_name']    = "Reports";
        $data['sub_module']     = "Batch Report";

        $admin_user_id          = Auth::user()->id;
        $view_action_id         = 98;
        $view_permisiion        = $this->PermissionHasOrNot($admin_user_id, $view_action_id);
        $data['actions']['view_permisiion'] = $view_permisiion;

        return view('report.batch-report', $data);
    }

	public function batchReportList(Request $request)
    {
		$batchSQL  = Batch::with('course', 'batch_fees','batch_fees.installments','students');
        
        if($request->from_date != "")
            $batchSQL->where('start_date','>=',$request->from_date);
        if($request->to_date != "")
            $batchSQL->where('start_date','<=',$request->to_date);
        if($request->running_status != "All")  
            $batchSQL->where('running_status','=',$request->running_status);
        if($request->course_id != "")
            $batchSQL->where('course_id','=',$request->course_id);
        $batches = $batchSQL->get();
        
        $return_arr = array();
        foreach($batches as $batch){
            $total_pending_student =  $batch->students->filter(function ($item) {   
                 if($item->getOriginal()['pivot_status'] =='Inactive'){
                    return 1;
                 }
                    
            })->count();
            //echo $total_pending_student; die;
			$data['batch_name'] = $batch->batch_name; 
            $data['course_name']= $batch->course->title;
            $data['start_date'] = $batch->start_date; 
			$data['end_date']   = $batch->end_date;
			$data['student_limit'] 		    = $batch->student_limit;
			$data['total_enrolled_student'] = $batch->total_enrolled_student;
            $data['total_pending_student'] = $total_pending_student;            
            $data['batch_fee']      = $batch->fees. ' ('.$batch->discounted_fees.')'; 
            $data['running_status'] = $batch->running_status; 
            $return_arr[] = $data;
        }
        return json_encode(array('data'=>$return_arr));	 
	}
 

    public function studentReport()
    {
        $data['page_title']     = $this->page_title;
        $data['module_name']    = "Reports";
        $data['sub_module']     = "Student Report";

        $admin_user_id          = Auth::user()->id;
        $view_action_id         = 99;
        $view_permisiion        = $this->PermissionHasOrNot($admin_user_id, $view_action_id);
        $data['actions']['view_permisiion'] = $view_permisiion;

        return view('report.student-report', $data);
    }

	public function studentReportList(Request $request)
    {
		$studentSQL  = Student::with('batches');
        
        if($request->from_date != "")
            $studentSQL->where('created_at','>=',$request->from_date);
        if($request->to_date != "")
            $studentSQL->where('created_at','<=',$request->to_date);
        if($request->type != "All")  
            $studentSQL->where('type','=',$request->type);
        if($request->register_type != "All")  
            $studentSQL->where('register_type','=',$request->register_type);
        if($request->status != "All")  
            $studentSQL->where('status','=',$request->status);
         if($request->study_mode != "All")  
            $studentSQL->where('study_mode','=',$request->study_mode);

        $studentes = $studentSQL->get();
        
        $return_arr = array();
        foreach($studentes as $student){
            $data['first_name'] = $student->name;
            $data['student_no'] = $student->student_no;
            $data['email']      = $student->email;
            $data['contact_no'] = $student->contact_no;
            $data['emergency_contact']  = $student->emergency_contact;
            $data['nid_no']             = $student->nid_no;
            $data['date_of_birth']      = $student->date_of_birth;
            $data['study_mode']         = $student->study_mode;
            $data['type']               = $student->type;
            $data['register_type']      = $student->register_type;
            $data['status']             = $student->status;

            $return_arr[] = $data;
        }
        return json_encode(array('data'=>$return_arr));	 
	}
 

    public function paymentScheduleReport()
    {
        $data['page_title']     = $this->page_title;
        $data['module_name']    = "Reports";
        $data['sub_module']     = "Payment Schedule Report";

        $admin_user_id          = Auth::user()->id;
        $view_action_id         = 100;
        $view_permisiion        = $this->PermissionHasOrNot($admin_user_id, $view_action_id);
        $data['actions']['view_permisiion'] = $view_permisiion;

        return view('report.payment-schedule-report', $data);
    }

	public function paymentScheduleReportList(Request $request)
    {
		$paymentSQL  =  StudentPayment::with('enrollment','enrollment.batch.course');

        if($request->from_date != "")
            $paymentSQL->where('last_payment_date','>=',$request->from_date);
        if($request->to_date != "")
            $paymentSQL->where('last_payment_date','<=',$request->to_date);
        if($request->payment_status != "All")  
            $paymentSQL->where('payment_status','=',$request->payment_status);
       
        if($request->student_id != "")  {
            $student_id = $request->student_id;
            $paymentSQL->whereHas('enrollment.student', function($query) use ($student_id){
                $query->where('id',$student_id);
            });
        }
        else
            $paymentSQL->with('enrollment.student');


        if($request->batch_id != "") {
            $batch_id = $request->batch_id;
            $paymentSQL->whereHas('enrollment.batch', function($query) use ($batch_id){
                $query->where('id',$batch_id);
            });
        }
        else
            $paymentSQL->with('enrollment.batch');
            
     

        $payments = $paymentSQL->orderBy('created_at','desc')->get();
        
        $return_arr = array();
        foreach($payments as $payment){
            $data['student_name']   =  $payment->enrollment->student->name." ".$payment->enrollment->student->student_no; 
            $data['course_name']    = $payment->enrollment->batch->course->title.' '.$payment->enrollment->batch->batch_name;
            $data['installment']    = $payment->installment_no; 
            $data['payment_month']  = date('M y', strToTime($payment->last_payment_date)); 
            $data['paid_date']      = $payment->paid_date; 
			$data['payment_status'] = ($payment->payment_status=='Paid')?$payment->payment_status:"Due";
			$data['payable_amount'] = $payment->payable_amount;
            $return_arr[] = $data;
        }
        return json_encode(array('data'=>$return_arr));	 
	}  


    public function paymentCollectionReport()
    {
        $data['page_title']     = $this->page_title;
        $data['module_name']    = "Reports";
        $data['sub_module']     = "Payment Schedule Report";

        $admin_user_id          = Auth::user()->id;
        $view_action_id         = 101;
        $view_permisiion        = $this->PermissionHasOrNot($admin_user_id, $view_action_id);
        $data['actions']['view_permisiion'] = $view_permisiion;

        return view('report.payment-collection-report', $data);
    }

	public function paymentCollectionReportList(Request $request)
    {
		$paymentSQL  =  StudentPayment::with('paidBy','enrollment','enrollment.batch.course');

        if($request->from_date != "")
            $paymentSQL->where('last_payment_date','>=',$request->from_date);
        if($request->to_date != "")
            $paymentSQL->where('last_payment_date','<=',$request->to_date);
        /*if($request->payment_status != "All")  
            $paymentSQL->where('payment_status','=',$request->payment_status);
       */
        if($request->student_id != "")  {
            $student_id = $request->student_id;
            $paymentSQL->whereHas('enrollment.student', function($query) use ($student_id){
                $query->where('id',$student_id);
            });
        }
        else
            $paymentSQL->with('enrollment.student');


        if($request->batch_id != "") {
            $batch_id = $request->batch_id;
            $paymentSQL->whereHas('enrollment.batch', function($query) use ($batch_id){
                $query->where('id',$batch_id);
            });
        }
        else
            $paymentSQL->with('enrollment.batch');
            
        $payments = $paymentSQL->where('payment_status','!=','Unpaid')->orderBy('created_at','desc')->get();
        
        $return_arr = array();
        foreach($payments as $payment){
            $data['student_name']   =  $payment->enrollment->student->name." ".$payment->enrollment->student->student_no; 
            $data['course_name']    = $payment->enrollment->batch->course->title.' '.$payment->enrollment->batch->batch_name;
            $data['installment']    = $payment->installment_no; 
            $data['payment_month']  = date('M y', strToTime($payment->last_payment_date)); 
            $data['paid_date']      = $payment->paid_date; 
            $data['paid_type']      = $payment->paid_type;
            $data['paid_by']        = ($payment->paid_by == 'Admin')?"Admin(".$payment->paidBy->first_name.")":"Student"; 
            $data['reference_no']   = $payment->payment_refference_no; 
            $data['invoice_no']     = $payment->invoice_no; 
			$data['payment_status'] = ($payment->payment_status=='Paid')?$payment->payment_status:"Due";  
			$data['paid_amount'] = $payment->paid_amount;
            $return_arr[] = $data;
        }
        return json_encode(array('data'=>$return_arr));	 
	}  

    public function scheduleCollectionReport()
    {
        $data['page_title']     = $this->page_title;
        $data['module_name']    = "Reports";
        $data['sub_module']     = "Payment Schedule Vs Collection";

        $admin_user_id          = Auth::user()->id;
        $view_action_id         = 102;
        $view_permisiion        = $this->PermissionHasOrNot($admin_user_id, $view_action_id);
        $data['actions']['view_permisiion'] = $view_permisiion;

        return view('report.schedule-collection-report', $data);
    }

	public function scheduleCollectionReportList(Request $request)
    {
		$paymentSQL  =  StudentPayment::with('enrollment','enrollment.batch.course');

        if($request->from_date != "")
            $paymentSQL->where('last_payment_date','>=',$request->from_date);
        if($request->to_date != "")
            $paymentSQL->where('last_payment_date','<=',$request->to_date);
        /*if($request->payment_status != "All")  
            $paymentSQL->where('payment_status','=',$request->payment_status);
       */
        if($request->student_id != "")  {
            $student_id = $request->student_id;
            $paymentSQL->whereHas('enrollment.student', function($query) use ($student_id){
                $query->where('id',$student_id);
            });
        }
        else
            $paymentSQL->with('enrollment.student');


        if($request->batch_id != "") {
            $batch_id = $request->batch_id;
            $paymentSQL->whereHas('enrollment.batch', function($query) use ($batch_id){
                $query->where('id',$batch_id);
            });
        }
        else
            $paymentSQL->with('enrollment.batch');
            
        $payments = $paymentSQL->orderBy('created_at','desc')->get();
        
        
        //dd($payments);
        $return_arr = array();
        foreach($payments as $payment){
            $data['student_name']   =  $payment->enrollment->student->name." ".$payment->enrollment->student->student_no; 
            $data['course_name']    = $payment->enrollment->batch->course->title.' '.$payment->enrollment->batch->batch_name;
            $data['installment']    = $payment->installment_no; 
            $data['payment_month']  = date('M y', strToTime($payment->last_payment_date)); 
            $data['paid_date']      = $payment->paid_date; 
            $data['paid_type']      = $payment->paid_type;
            $data['paid_by']        = ($payment->paid_by == 'Admin')?"Admin (".$payment->paidBy->first_name.")":"Student"; 
            $data['invoice_no']     = $payment->invoice_no; 
			$data['payment_status'] = ($payment->payment_status=='Paid')?$payment->payment_status:"Due";           
			$data['payable_amount'] = $payment->payable_amount;
            $data['paid_amount']    = $payment->paid_amount;

            $return_arr[] = $data;
        }
        return json_encode(array('data'=>$return_arr));	 
	}  

	public function expenseReport()
    {
        $data['page_title']     = $this->page_title;
        $data['module_name']    = "Reports";
        $data['sub_module']     = "Expense Report";

        $admin_user_id          = Auth::user()->id;
        $data['parentExpneseHead'] = ExpneseCategory::with('parent')->where('status','Active')->get();
        $view_action_id         = 92;
        $view_permisiion        = $this->PermissionHasOrNot($admin_user_id, $view_action_id);
        $data['actions']['view_permisiion'] = $view_permisiion;

        return view('report.expense-report', $data);
    }

	public function expenseReportList(Request $request)
    {
        
        $expencesSQL = "SELECT expense_head_id, eh.expense_head_name, ec.category_name, ec.id, ec.parent_id,amount,details,payment_status, expense_date
                FROM expenses e
                LEFT JOIN expense_heads eh ON e.expense_head_id=eh.id
                LEFT JOIN expnese_categories ec ON eh.expense_category_id=ec.id
                where e.status='Active'";


        if($request->from_date != "")
            $expencesSQL .= " And expense_date >= '".$request->from_date."'";
        if($request->to_date != "")
            $expencesSQL .= " And expense_date <= '".$request->to_date."'";     

        if($request->expense_head_id != "")
            $expencesSQL .= " And eh.id= ".$request->expense_head_id;
        else if($request->expense_category_id != "")
            $expencesSQL .= " And (ec.id=".$request->expense_category_id." OR ec.parent_id=".$request->expense_category_id.")";

        //echo $expencesSQL;die;
        $expences = DB::select($expencesSQL);
        //dd($expences);
        $return_arr = array();
        foreach($expences as $expence){
            $data['category'] 	= $expence->category_name;
			$data['head'] 	    = $expence->expense_head_name;
            $data['date'] 	    = $expence->expense_date;
            $data['details'] 	= $expence->details;
            $data['payment_status']= $expence->payment_status;            
            $data['amount'] 	= $expence->amount;
            $return_arr[] = $data;
        }
        return json_encode(array('data'=>$return_arr));	 
	}

       
	public function expenseIncome()
    {
        $data['page_title']     = $this->page_title;
        $data['module_name']    = "Reports";
        $data['sub_module']     = "Expense Vs Income";

        $admin_user_id          = Auth::user()->id;
        $view_action_id         = 93;
        $view_permisiion        = $this->PermissionHasOrNot($admin_user_id, $view_action_id);
        $data['actions']['view_permisiion'] = $view_permisiion;

        return view('report.expense-income', $data);
    }

	public function expenseIncomeList(Request $request)
    {
        $expenseCondition  = "";
        $paymentCondition = " where  payment_status != 'Unpaid' ";
        if($request->from_date != "" && $request->to_date != ""){            
            $expenseCondition =" where  expense_date between '".$request->from_date."' and '".$request->to_date."'";
            $paymentCondition ="  and paid_date between '".$request->from_date."' and '".$request->to_date."'";
        }
        

        $expenseIncomes = DB::select("
            SELECT SUM(expense_amount) as expense_amount, SUM(income_amount) as income_amount, month_year
            FROM(
                SELECT 
                    SUM(amount) AS expense_amount, 
                    0 as income_amount,
                    DATE_FORMAT(expense_date, '%M,%Y') AS month_year, 
                    YEAR(expense_date) AS year, 
                    MONTH(expense_date) AS month
                FROM expenses 
                $expenseCondition
                GROUP BY month,YEAR
                Union
                SELECT 
                    0 as expense_amount, 
                    SUM(paid_amount) AS income_amount,
                    DATE_FORMAT(paid_date, '%M,%Y') AS month_year, 
                    YEAR(paid_date) AS year, 
                    MONTH(paid_date) AS month
                FROM student_payments 
                $paymentCondition
                GROUP BY month,YEAR
            )A
            GROUP BY  month_year
        ");

        $return_arr = array();
        foreach($expenseIncomes as $key=>$expenseIncome){
            $data['serial'] 	= $key+1;
			$data['month'] 	    =$expenseIncome->month_year;
            $data['expense'] 	=$expenseIncome->expense_amount;
            $data['income'] 	=$expenseIncome->income_amount;
            $data['balance']    =($expenseIncome->income_amount-$expenseIncome->expense_amount);         
            $return_arr[] = $data;
        }
        return json_encode(array('data'=>$return_arr));	 
	}


}
