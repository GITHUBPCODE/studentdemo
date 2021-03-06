<!DOCTYPE html>
<html>
<head>
    <title>Student Report</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
	
	
	
	
	
	<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
 
  <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
  
</head>
<body>
<div class="container">
    <div class="card bg-light mt-3">
        <div class="card-header">
            Student report &nbsp;&nbsp;&nbsp;<a href="{{url('upload')}}"><button class="btn btn-warning" >Back</button></a>
        </div>
    <div class="row">
        <div class="col-12 table-responsive">
		
			<select name="class" id="class" CLASS="form-control" style="backround-color:red;background-color: #84b5ff;">
			<option value="">ALL</option>
			@foreach($ClassList as $ClassLists)
			<option value="{{ $ClassLists->CLASS }}">{{ $ClassLists->CLASS }}</option>
			@endforeach
			</select>
			<br></br>
			
            <table class="table table-bordered user_datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Class</th>
                        <th>Total</th>
                        <th>Grade</th>
                        <th width="100px">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>




  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
		<h6 class="modal-title">Mark Detail</h6>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
            <table class="table table-bordered mark_datatable">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Mark</th>
                     </tr>
                </thead>
                <tbody id="table_body"></tbody>
            </table>          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>




</body>
<script type="text/javascript">

$( function() {
    $( document ).tooltip();
  } );

  $(function () {
	  
	  
    var table = $('.user_datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('viewreport') }}",
        columns: [
            {data: 'student_id', name: 'student_id'},
            {data: 'name', name: 'name'},
            {data: 'CLASS', name: 'CLASS'},
            {data: 'TOTAL', name: 'TOTAL'},
            {data: 'GRADE', name: 'GRADE'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
		"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
            
                $('td:eq(0)', nRow).html( '<span title="'+aData['address']+'" data-toggle="tooltip" data-placement="left">'+aData['student_id']+'</span>' );
                $('td:eq(4)', nRow).html( '<b title="'+aData['GRADE']+'">'+aData['GRADE']+'</b>' );
                $('td:eq(5)', nRow).html( '<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal"  onclick="showdata(\''+aData['student_id']+'\',\''+aData['CLASS']+'\'  )">Detail</button>' );
         
        },
    });

	$('#class').on('change', function(){
	   table.columns(2).search(this.value).draw();   
	});
  });
  
  function showdata(sid,classname){
   


        $.ajax({
           type:'get',
           url:"{{ url('showmark') }}/"+sid+"/"+classname,
           success:function(data){
						  var aRC = JSON.parse(JSON.stringify(data));
						  $("#table_body").html('');
						  for (var i = 0; i < aRC.length; i++) {
							$("#table_body").append("<tr><td>"+aRC[i].subject+"</td><td>"+aRC[i].marks+"</td></tr>");
						  }
           }
        });
  
  }
  
</script>
</html>