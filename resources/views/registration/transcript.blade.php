
    <div class="row ">
        <div class="col-md-12">	
			<div class='col-md-12'><h3 >Transcript Details</h3></div>			
			<div class='col-md-2'><strong>Qualification Title:</strong></div><div class='col-md-4'>{{ $registration->qualification->title }}</div>
			<div class='col-md-2'><strong>Registration No. :</strong></div><div class='col-md-4'>{{ $registration->registration_no }}</div>
			<div class='col-md-2'><strong>Centre Name:</strong></div><div class='col-md-4'>{{ $registration->center->name }}</div>
			<div class='col-md-2'><strong>Invoice No. :</strong></div><div class='col-md-4'>{{ $registration->invoice_no }}</div>
			<div class='col-md-2'><strong>Total Learners:</strong></div><div class='col-md-10'>{{ count($registration->learners) }}</div>
			<div class="col-md-12 text-right">
				                        
			</div>
			<div class='col-md-12'><h3 >Learner Unit Details</h3>
			@if($permissions['claim_permisiion']>0)
					<button type="button" id="claim_certificate" class="btn btn-info">Claim for certificate</button>                    
				@endif 
			</div>
			<form id="result_form" name="result_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
			@csrf	
			<input type="hidden" id="registration_id" name="registration_id" value="{{$registration->id}}" />
			<table class="table table-bordered table-hover">				
			@foreach ($registedLearners as $registedLearner)
				<thead>
					<tr>
						<th  class="text-center" style="max-width:20px" ></th>
						<th  class="text-center" style="max-width:40px" >SN</th>
						<th class="text-center" style="max-width:50px"  >Reg. No. </th>
						<th>Learner Name</th>	
						<th>Result Status</th>
						<th>Cirtificate No. </th>						
						@foreach ($registedLearner->results as $result)
							<th class="text-center" style="max-width:120px">{{ $result->unit->name }}</th>
						@endforeach
					</tr>
				</thead>
				@break
			@endforeach
				<tbody>
			@php $i = 1; @endphp
			@foreach ($registedLearners as $registedLearner)
			@php 				
				if($registedLearner->pass_status =='Pass') $trClass = "success";
				else if($registedLearner->pass_status =='Pass') $trClass = "warning";
				else $trClass = "";
			@endphp
					<tr class="{{$trClass}}">
						<td class="text-center">
							@if($permissions['result_permisiion']>0 && $registedLearner->pass_status =="Pass" && $registedLearner->result_claim_date=="")
							<input type='checkbox' name='claimLearners[]' value="{{ $registedLearner->id }}" />
						@endif
							
							
						</td>
						<td class="text-center">{{$i}}</td>
						<td class="text-center">
							<input type="hidden" name="registedLearners[]" value="{{ $registedLearner->id }}" />
							{{ str_pad($registedLearner->id, 6, "0", STR_PAD_LEFT ) }}
						</td>
						<td>{{ $registedLearner->learner->first_name." ".$registedLearner->learner->last_name }}</td>
						<td>{{ $registedLearner->pass_status }}</td>
						<td>{{ $registedLearner->certificate_no }}</td>
						@foreach ($registedLearner->results as $result)
							<td class="text-center">
							@php
								$counter = 1;
							@endphp
							@php
								$NA_selected =($result->result == 'NA')?'selected':'';
								$F_selected = ($result->result == 'F')?'selected':'';
								$P_selected = ($result->result == 'P')?'selected':'';
								$M_selected = ($result->result == 'M')?'selected':'';
								$D_selected = ($result->result == 'D')?'selected':'';
								
								$selectDisabled = ($permissions['result_permisiion']>0 && $registedLearner->certificate_no =="")?'':'disabled'
							@endphp
							
								<select {{$selectDisabled}}  name='learnerResults[{{ $registedLearner->id }}][{{ $result->id }}]' class="form-control resultSelect"  >
									<option {{ $NA_selected }} value="NA">Not Given</option>
									<option {{ $F_selected }} value="F">Fail</option>
									<option {{ $P_selected }} value="P">Pass</option>
									<option {{ $M_selected }} value="M">Marit</option>
									<option {{ $D_selected }} value="D">Distinction</option>
								</select>
							</td>
						@endforeach
					</tr>
				@php ($i++)
			@endforeach
				</tbody>
			</table>
			<div class="form-group">
				<div class="col-md-6 col-sm-6 col-xs-12">
					@if($permissions['result_permisiion']>0)
						<button type="submit" id="save_result" class="btn btn-success btn-lg">Save</button>                    
					@endif                         
				</div>
			</div>
			</form>
		</div>
    </div>
    <!--END PAGE CONTENT-->



