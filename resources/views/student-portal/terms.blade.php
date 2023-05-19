@extends('student-portal.layout.master')
@section('content')
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-notebook  icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>ABP Terms & Conditions
                        <div class="page-title-subheading opacity-10">
                            <nav class="" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a>
                                            <i aria-hidden="true" class="fa fa-home"></i>&nbsp;ABP
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{url('dashboard')}}">Dashboards</a>
                                    </li>
                                    <li class="active breadcrumb-item" aria-current="page">
                                        <a href="{{\Request::url()}}">
                                            {{isset($page_title) ? $page_title : ''}}
                                        </a>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>   
            </div>
        </div> 


        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card ">
                    <div class="card-body"> 
                        <div class=" col-md-12">
                            <h2>ABP Terms and Conditions </h2>

							<p>&nbsp;</p>

							<p>I Confirm that I
							understand and agree to abide by the regulations and conditions of course(s)
							and admission set out below: </p>

							<p>&nbsp;</p>

							<p>I will make the payment before the last date of admission or registration.</p>

							<p>I understand that for
							making payment online additional ‘bank/online charge’ will be applied over the
							regular fees.</p>

							<p>I will make payment of
							any dues (if any) within agreed time as set out during my admission to the
							course. And ABP reserves the right to cancel my studentship or withheld my exam
							results for late payment of any dues. </p>

							<p>My studentship will be
							automatically void for involvement in any activity/organisation which is
							subversive to the country or state-law.</p>

							<p>I acknowledge that ABP
							reserves the right to verify the information (including certificates, NID)
							given with the admission form and have the authority to cancel my studentship
							for any kind of false or misleading information. </p>

							<p>I will not engage in
							any political discussion at ABP which would be against the rules or law of the
							state.</p>

							<p>During the class and
							my presence at ABP I will maintain courtesy, code of conduct and
							professionalism with the teachers, administrators, supporting staff and
							co-learners.</p>

							<p>I will take maximum
							care of books, tools and assets at ABP.</p>

							<p>I agree
							that ABP cannot take any responsibility for any external factors in respect of
							my circumstances, payment or enrolment, nor for informing me or any other
							parties of changes in immigration or other legislation.  ABP takes no
							responsibility for incorrect or misleading information given by any
							international representative or agent.  In the event of circumstances requiring
							urgent medical care where it is not possible to contact the parent/guardian, I
							authorise ABP to seek and provide appropriate medical care within their
							capacity.</p>

							<p>As a student of ABP,
							everyone is liable to behave in professional and disciplined manner. Any
							misconduct will lead to termination of studentship without any refund of the
							fees.</p>

							<p>I will maintain the
							dress code which are formal, professional and generally accepted in Bangladesh. </p>

							<p>&nbsp;</p>
							<h5>Refund Policy:</h5>
							<p></p>
							<p>I acknowledge that
							fees and payments made to ABP are non-refundable and non-transferrable to any
							other courses or semester whatever the circumstances arise in future.</p>

							<p>Bank processing fee
							will be deducted if any refund is made for any unavoidable circumstances.</p>

							<p>&nbsp;</p>
							<h5>Examination and Results Policy::</h5>
							<p></p>


							<p>I acknowledge that
							during the exam, possession of a mobile phone or other unauthorised material is
							considered as breaking the rules, even if I don’t intend to use it, and I will
							be subject to penalty and possible disqualification.</p>

							<p>If I commit any kind
							of malpractice in an examination, my script will be void and cancelled, and no
							marks will be awarded.</p>

							<p>I will not communicate
							with, receive assistance from or copy from the paper of another student during
							an examination. I acknowledge that I must take reasonable steps to ensure that
							my assessments are kept secure so that I do not enable another person to copy
							my work.</p>

							<p>I acknowledge that ABP
							owns all exam materials including scripts. No exam scripts and question paper
							are handed over to me either electronically or in hard copy.</p>

							<p>I am informed that ABP
							has no provision for re-marking of exam results. However, students have the
							right to request for an administrative review of the assessed exam script
							through an application by email to <u>contact@abpbd.org</u>. I understand that
							if any appeal is made the actual marks for each question will not be disclosed
							and examination scripts will not be returned. As part of the review ABP will
							only confirm whether or not student reached the pass standard in the exam
							he/she has attempted.</p>


							<p>&nbsp;</p>
							<h5>Certification Policy::</h5>
							<p></p>


							<p>I admit that PGD
							certificates are issued by Edupro, UK within 4-6 weeks after successful
							completion of the qualification to ABP. I will need to collect my PGD
							certificate in my own responsibility from ABP within two months after getting
							the notification from ABP.</p>

							<p>As a student of ABP
							and Edupro (if appropriate), I will abide by all the professional and ethical
							code of conduct of ABP and Edupro.</p>

							<p>I admit that
							‘Certificate of Participation’ are issued by ABP for participating in any
							Workshop/ Seminar arranged by ABP. I will need to collect my certificate in my
							own responsibility from ABP within one months.</p>

                        </div>
                    </div>
                </div>
            </div>
		</div>             
    </div>   
</div>
@endsection

