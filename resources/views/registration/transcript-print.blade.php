<style>
	h1{
		font-size:48px;
	}
	.page{
		width: 97%;
		height: 25cm; 
		padding:50px 0px 50 0px; 
		flex-direction: column;
		
	}
	.certificate-body{
		height: 18cm;
	}
	.certificate-footer{
		height: 7cm; 
	}
	.paddding-top-100{
		padding-top:100px;
	}
	
	.paddding-top-20{
		padding-top:100px;
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
		 
		padding:2px !important;
	}
	table.transcript-table tr, table.transcript-table td, table.transcript-table th{
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

	.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
		border-top: 0px;
	}
</style>
	
<div class="page">
	<div class="col-md-12 certificate-body paddding-top-20">
		<p>This is to certify that</p>
		<br>
		<h4 class="upper"><strong>{{ $certificateLearner->learner->first_name.' '.$certificateLearner->learner->last_name}}</strong></h4>
		<br>
		<p>has been awarded</p>
		<h5 class="upper"><strong>{{$certificateLearner->registration->qualification->title}}</strong></h5>
		<p>under Edupro, UK customised award service guidelines, which includes the
			following units and credits.</p>
		<br>
		<table class="table transcript-table">
			<thead style="border-top:2px solid gray; border-bottom:2px solid gray; ">
				<tr>
					<td>Unit Title</td>
					<td class='text-center'>Credits</td>
					<td  class='text-center'>Grade</td>
				</tr>
			</thead>
			<tbody style="border-bottom:2px solid gray; ">
			@foreach($certificateLearner->results as $result)
			<tr>
				<td>{{ $result->unit->name }}</td>
				<td class='text-center'>{{ $result->unit->credit_hour }}</td>
				<td class='text-center'>
					@php
						if($result->result =='P') echo "Pass";
						else if($result->result =='M') echo "Merit";
						else if($result->result =='D') echo "Distinction";
					@endphp
				</td>
			</tr>
			@endforeach
			<tr>
				<td>sssssss</td>
				<td class='text-center'>55</td>
				<td class='text-center'>PASS</td>
			</tr>
			<tr>
				<td>sssssss</td>
				<td class='text-center'>55</td>
				<td class='text-center'>PASS</td>
			</tr>
			<tr>
				<td>sssssss</td>
				<td class='text-center'>55</td>
				<td class='text-center'>PASS</td>
			</tr>
			<tr>
				<td>sssssss</td>
				<td class='text-center'>55</td>
				<td class='text-center'>PASS</td>
			</tr>
			<tr>
				<td>sssssss</td>
				<td class='text-center'>55</td>
				<td class='text-center'>PASS</td>
			</tr>
			<tr>
				<td>sssssss</td>
				<td class='text-center'>55</td>
				<td class='text-center'>PASS</td>
			</tr>
			
			</tbody>
		</table>
		<p style="font-size:11px"><i>Grading scheme: Pass- 50%, Merit- 65%, Distinction- 80%</i></p>
		
	</div> 
	<div class="col-md-12 certificate-footer">
	<h5>Programme designed & delivered by: ABP </h5>
		<br>
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
						<image style="max-height:60px" src="{{ $images['signetureImage']}}" />
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


