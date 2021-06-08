<style>
	h1{
		font-size:48px;
	}
	.page{
		width: 97%;
		height: 25cm; 
		padding:80px 0px; 
		flex-direction: column;
		
	}
	.certificate-body{
		height: 13.5cm;
	}
	.certificate-footer{
		height: 11.5cm; 
	}
	.paddding-top-110{
		padding-top:95px;
	}
	
	.paddding-top-20{
		padding-top:20px;
	}
	
	/*
	
	display: flex;
		flex-direction: column;
		justify-content: flex-end;
	*/
	table tr,table td,table th{
		 font-size: 12px !important;
	}
	
	table.no-border tr,table.no-border td,table.no-border th{
		 border: none !important;
		 font-size: 12px !important;
		 padding:2px !important;
	}
	.left-padding-0{
		padding-left:0 !important ;
	}
	.right-padding-0{
		padding-right:0 !important ;
	}
	
	.bordered{border:1px solid red;}
	.upper{
		text-transform:uppercase;
	}
	@media print {
	  * { overflow: visible !important; } 
	  /*.pageNo1 { page-break-after:always; }*/
	}
	p{
		font-size:14px;
	}

</style>

	<div class="page pageNo1">
		<div class="col-md-12 certificate-body paddding-top-110">
			<h1><b>Certificate</b> of</h1>
			<h1>Achievement</h1>
			<br><br>
			<p>has been awarded to</p>
			<br>
			<h4 class='learner-name upper'><strong>{{ $certificateLearner->learner->first_name.' '.$certificateLearner->learner->last_name}}</strong></h4>
			<br>
			<p>who has completed</p>
			<h5 class="upper"><strong>{{$certificateLearner->registration->qualification->title}}</strong></h4>
			<p>under the Edupro, UK customised award service guidelines.</p>
			<br>
			<h5>Programme designed & delivered by: ABP </h5>
		</div>
		
		<div class="col-md-12 certificate-footer">
			<br><br>
			<br><br>
			<table class="table no-border">
				<tr>
					<td>| Learner Number: {{ str_pad($certificateLearner->id, 6,'0', STR_PAD_LEFT) }}</td>
					<td>| Credits Achieved: {{$totalCredit}}</td>
					<td>| Centre Number: {{$certificateLearner->registration->center->id}}</td>
				</tr>
				<tr>
					<td>| Date of Birth: {{ date('j F Y', strtotime($certificateLearner->learner->date_of_birth)) }}</td>
					<td>| Comparable EP Level: {{$certificateLearner->registration->qualification->level->name}}</td>
					<td>| Award Date: {{ date('M Y', strToTime($certificateLearner->updated_at))}}</td>
				</tr>
				<tr>
					<td>| Qualification Number: {{$certificateLearner->registration->qualification->code}}</td>
					<td>| Certificate Number: {{$certificateLearner->certificate_no}}</td>
					<td></td>
				</tr>
			</table>
			<br>
			<div class="col-md-12 left-padding-0">	
				<table class="table no-border">
					<tr>
						<td class="text-left">
							<image style="max-height:120px" src="{{ $images['signetureImage']}}" />
							<p>
								Responsible Officer <br>
								Edupro
							</p>
						</td>
						@php
							$qrCode = 	strToUpper($certificateLearner->learner->first_name.' '.$certificateLearner->learner->last_name)."\n".
										"Learner # ".str_pad($certificateLearner->id, 6,'0', STR_PAD_LEFT)."\n".
										"Completed  ".$certificateLearner->registration->qualification->title."\n".
										"Awarded and Quality Assured by Edupro, UK  "."\n".
										"e-mail: service@edupro.com"."\n".
										"web: www.eduprouk.com"."\n"; 
						@endphp
						<td class="text-right">
							 {!! QrCode::size(100)->generate($qrCode); !!}
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	


