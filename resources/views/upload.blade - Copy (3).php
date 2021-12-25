<!DOCTYPE html>
<html>
<head>
    <title>student details</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
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
  
<div class="container">
    <div class="card bg-light mt-3">
        <div class="card-header">
            Upload Student Details 
			&nbsp;&nbsp;&nbsp;<a href="{{url('viewreport')}}"><button class="btn btn-warning" >View Report</button></a>
			&nbsp;&nbsp;&nbsp;<a href="{{url('viewchart')}}"><button class="btn btn-warning" >View Chart</button></a>
        </div>
        <div class="card-body">
            <form  method="POST" enctype="multipart/form-data" id="studentform">
            <!--<form action="{{ route('importstudent') }}" method="POST" enctype="multipart/form-data">-->
                @csrf
                <input type="file" name="file" class="form-control">
                <br>
                <button class="btn btn-success" type="submit">Import Student Data</button>
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


<script>
/*
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
*/
   $('#studentform').submit(function(e) {
       e.preventDefault();
	   var fmdat = $('#studentform').serialize();
       let formData = new FormData($(fmdat)[1]);
       //let formData = new FormData(this);
       $('#image-input-error').text('');

       $.ajax({
          type:'POST',
          url: "{{ url('importstudent')}}",
           data: formData,
           contentType: false,
           processData: false,
		   
           success: (response) => {
             if (response) {
               this.reset();
               alert('Image has been uploaded successfully');
             }
           },
           error: function(response){
              console.log(response);
                $('#image-input-error').text(response.responseJSON.errors.file);
           }
       });
  });

</script>
<!---
<script type="text/javascript">
$(document).ready(function (e) {
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$('#studentform').submit(function(e) {
e.preventDefault();
var formData = new FormData(this);
$.ajax({
type:'POST',
url: "{{ url('importstudent')}}",
data: formData,
cache:false,
contentType: false,
processData: false,
success: (data) => {
this.reset();
alert('File has been uploaded successfully');
console.log(data);
},
error: function(data){
console.log(data);
}
});
});
});
</script>


-->


</html>