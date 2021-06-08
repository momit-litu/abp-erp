@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @if ($errors->count() > 0 )
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <h6>The following errors have occurred:</h6>
                    <ul>
                        @foreach( $errors->all() as $message )
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (Session::has('message'))
                <div class="alert alert-success" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ Session::get('message') }}
                </div>
            @endif
            @if (Session::has('errormessage'))
                <div class="alert alert-danger" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ Session::get('errormessage') }}
                </div>
            @endif
        </div>
    </div>

	<div class="row text-center" style="padding:5px;">
	<h2>{{ (isset($data['centerName']) && $data['centerName'] != "")?$data['centerName']:'' }}</h2>
		<div class="col-md-12 text-center">
			<div class="row  col-md-12 " style=" display: flex; justify-content:center; flex-wrap: wrap">
				@foreach ($dashboardComponents as $component)
					
					<div class="alert" style="width:29% !important; background-color:{{$component['backgroundColor']}}; margin:0 1.5% 1.5% 1.5%; ">
						<!--<a href="{{url('/'.$component['redirectTo'])}}" style="text-decoration:none"> -->
							<div class="values">
								<h3 style="height: 40px; color:#fff">{{$component['name']}}</h3>
								<h1 style="color:#fff; font-weight:800">{{$component['totalNo']}}</h1>
							</div>
						<!--</a> -->
					</div>
					
				@endforeach
			</div>
		</div>
	</div>
@endsection





