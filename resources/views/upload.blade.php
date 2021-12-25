<!DOCTYPE html>
<html>
<head>
    <title>student details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
</head>
<body>
   
@if(Session::has('msg'))   
<div class="container">
    <div class="card bg-light mt-3">
        <div class="card-header" style="background-color: green;color:white">
			{{ Session::get('msg') }}
        </div>  
    </div>  
</div>  
@endif


                @if (count($errors) > 0)
				<div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-1">
                      <div class="alert alert-danger alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <h4><i class="icon fa fa-ban"></i> Error!</h4>
                          @foreach($errors->all() as $error)
                          {{ $error }} <br>
                          @endforeach      
                      </div>
                    </div>
                </div>
                </div>
                @endif

  
<div class="container">
    <div class="card bg-light mt-3">
        <div class="card-header">
            Upload Student Details 
			&nbsp;&nbsp;&nbsp;<a href="{{url('viewreport')}}"><button class="btn btn-warning" >View Report</button></a>
			&nbsp;&nbsp;&nbsp;<a href="{{url('viewchart')}}"><button class="btn btn-warning" >View Chart</button></a>
        </div>
        <div class="card-body">
            <form action="{{ route('importstudent') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="form-control">
                <br>
                <button class="btn btn-success">Import Student Data</button>
                <a class="btn btn-warning" href="{{ 'template/StudentDetailTemplate.xlsx' }}">Download Template</a>
            </form>
        </div>
    </div>
</div>
<div class="container">
    <div class="card bg-light mt-3">
        <div class="card-header">
            Upload Student Mark Details
        </div>
        <div class="card-body">
            <form action="{{ route('importmark') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="form-control">
                <br>
                <button class="btn btn-success">Import Student mark Data</button>
                <a class="btn btn-warning" href="{{ 'template/StudentMarkTemplate.xlsx' }}">Download Template</a>
            </form>
        </div>
    </div>
</div>   
</body>

</html>