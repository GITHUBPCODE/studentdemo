<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
	<title>upload</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
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
@if(Session::has('error'))   
<div class="container">
    <div class="card bg-light mt-3">
        <div class="card-header" style="background-color: red;color:white">
			{{ Session::get('error') }}
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
    	<h2 class="text-center mt-4 mb-4">Upload Student</h2>
    	<div class="card">
    		<div class="card-header"><b>Select Excel File</b></div>
    		<div class="card-body">
    			
                <input type="file" id="excel_file" />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<button class="btn btn-warning" type="button" onclick="Upload()">View Student Data</button>
				<a href="{{ url('/') }}"><button class="btn btn-primary" type="button" >Back</button></a>
    		</div>
    	</div>
		<form  method="POST" enctype="multipart/form-data" id="studentform">
            <!--<form action="{{ route('importstudent') }}" method="POST" enctype="multipart/form-data">-->
                @csrf
			<div id="excel_data" class="mt-5"></div>
			<table class="table table-striped table-bordered">
				<thead>
				<th>Student Id</th><th>Name</th><th>Class</th><th>Address</th><th>DOB</th>
				</thead><tbody id="table_body"></tbody>
			</table>
			<b id="importmsg"></b>
			<button class="btn btn-success" type="submit" id="importbtn" STYLE="display:none">Import Student Data</button>
		</form>
    </div>
</body>
</html>


    <script type="text/javascript" src="{{ asset('js/xlsx.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jszip.js') }}"></script>
    <script type="text/javascript">
        function Upload() {
			
            
			//Reference the FileUpload element.
            var fileUpload = document.getElementById("excel_file");

            //Validate whether File is valid Excel file.
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;
            if (regex.test(fileUpload.value.toLowerCase())) {
                if (typeof (FileReader) != "undefined") {
                    var reader = new FileReader();

                    //For Browsers other than IE.
                    if (reader.readAsBinaryString) {
                        reader.onload = function (e) {
							//$.LoadingOverlay("show");
                            ProcessExcel(e.target.result);
                        };
                        reader.readAsBinaryString(fileUpload.files[0]);
                    } else {
                        //For IE Browser.
                        reader.onload = function (e) {
                            var data = "";
                            var bytes = new Uint8Array(e.target.result);
                            for (var i = 0; i < bytes.byteLength; i++) {
                                data += String.fromCharCode(bytes[i]);
                            }
							//$.LoadingOverlay("show");
                            ProcessExcel(data);
                        };
                        reader.readAsArrayBuffer(fileUpload.files[0]);
                    }
					$('#importbtn').show();
                } else {
                    alert("This browser does not support HTML5.");
                }
            } else {
                alert("Please upload a valid Excel file.");
            }
			//$.LoadingOverlay("hide");
        };
		
</script>
<script>
        function ProcessExcel(data) {
            //Read the Excel File data.
            var workbook = XLSX.read(data, {
                type: 'binary'
            });

			/*-------------------------   Header    -------------------------------------------*/
            //Fetch the name of First Sheet.
            var firstSheet = workbook.SheetNames[0];
			//Read all rows from First Sheet into an JSON array.
            var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);
			$('#table_body').html("");
			//Add the data rows from Excel file.
            for (var i = 0; i < excelRows.length; i++) {
				if(excelRows[i].DocNo!=''){
					var student_id	= chk(excelRows[i].student_id);
					var name	= chk(excelRows[i].name);
					var classname	= chk(excelRows[i].classname);
					var address	= chk(excelRows[i].address);
					var dob	= chk(moment(excelRows[i].dob).format('DD-MM-YYYY'));
					var date =moment(dob, 'DD-MMM-YYYY').isValid();
					//Test it!
					var currentDate = isDate(dob);
					console.log(currentDate);
					if(currentDate==false){
						var SETERR = "style='background-color: red;'";
						$('#importmsg').html("Check highlighted data and correct the value!");
						$('#importbtn').hide();
					}else{
						var SETERR = '';
					}



					$('#table_body').append("<tr ><td>"+student_id+"</td><td>"+name+"</td><td>"+classname+"</td><td>"+address+"</td><td "+SETERR+">"+dob+"</td><input type='hidden' name='student_id[]' value='"+student_id+"'><input type='hidden' name='name[]' value='"+name+"'><input type='hidden' name='classname[]' value='"+address+"'><input type='hidden' name='address[]' value='"+address+"'><input type='hidden' name='dob[]' value='2021-12-21'></tr>");
					
				}			
			}	
			};
    
</script>


<script>
 function isDate(txtDate) {
           var currVal = txtDate;
           if (currVal == '')
               return false;
           var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; 
           var dtArray = currVal.match(rxDatePattern);

           if (dtArray == null)
               return false;
           
           dtMonth = dtArray[3];
           dtDay = dtArray[1];
           dtYear = dtArray[5];

           if (dtMonth < 1 || dtMonth > 12)
               return false;
           else if (dtDay < 1 || dtDay > 31)
               return false;
           else if ((dtMonth == 4 || dtMonth == 6 || dtMonth == 9 || dtMonth == 11) && dtDay == 31)
               return false;
           else if (dtMonth == 2) {
               var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
               if (dtDay > 29 || (dtDay == 29 && !isleap))
                   return false;
           }
           return true;
       }


function chk(val){
					if((val=='')||(val=='undefined')||(val=='null')||(val==null)){
						return '';
					}else{
						return val;
					}
}
</script>
<script>
function chkVal(val){
					if((val=='')||(val=='undefined')||(val=='null')||(val==null)){
						return '';
					}else{
						return val.replace(/[^\w\s]/gi, '');
					}
}
</script>










<!--
<script>

const excel_file = document.getElementById('excel_file');

excel_file.addEventListener('change', (event) => {

    if(!['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'].includes(event.target.files[0].type))
    {
        document.getElementById('excel_data').innerHTML = '<div class="alert alert-danger">Only .xlsx or .xls file format are allowed</div>';

        excel_file.value = '';

        return false;
    }

    var reader = new FileReader();

    reader.readAsArrayBuffer(event.target.files[0]);

    reader.onload = function(event){

        var data = new Uint8Array(reader.result);

        var work_book = XLSX.read(data, {type:'array'});

        var sheet_name = work_book.SheetNames;

        var sheet_data = XLSX.utils.sheet_to_json(work_book.Sheets[sheet_name[0]], {header:1});

        if(sheet_data.length > 0)
        {
            var table_output = '<table class="table table-striped table-bordered">';
			table_output += '<th>Student Id</th><th>Name</th><th>Class</th><th>Address</th><th>DOB</th>';
            for(var row = 0; row < sheet_data.length; row++)
            {

                table_output += '<tr>';

                for(var cell = 0; cell < sheet_data[row].length; cell++)
                {

                    
					
					if(row == 0)
                    {
						
                        //table_output += '<th>'+sheet_data[row][cell]+'</th>';
                        //table_output += '<th>'+sheet_data[row][cell]+'</th>';

                    }
                    else
                    {
						if(cell==0){
							var hint = "<input type='hidden' name='student_id[]' value='"+sheet_data[row][cell]+"'> ";
						}else if(cell==1){
							var hint = "<input type='hidden' name='name[]' value='"+sheet_data[row][cell]+"'> ";
						}else if(cell==2){
							var hint = "<input type='hidden' name='classname[]' value='"+sheet_data[row][cell]+"'> ";
						}else if(cell==3){
							var hint = "<input type='hidden' name='address[]' value='"+sheet_data[row][cell]+"'> ";
						}else if(cell==4){
							var datee = moment(sheet_data[row][cell]).format('yyyy-mm-d');
							alert(datee);
							var hint = "<input type='hidden' name='dob[]' value='"+sheet_data[row][cell]+"'> ";
						}else{
							var hint = "<input type='hidden' name='other[]' value='"+sheet_data[row][cell]+"'> ";
						}
                        table_output += '<td>'+sheet_data[row][cell]+''+hint+'</td>';

                    }

                }

                table_output += '</tr>';

            }

            table_output += '</table>';

            document.getElementById('excel_data').innerHTML = table_output;
        }

        excel_file.value = '';

    }

});

</script>
  -->



<script type="text/javascript">

$('#studentform').on('submit',function(e){
    e.preventDefault();
	var fromdtd = $('#studentform').serialize();
    $.ajax({
      url: "{{ route('ajaxsubmit') }}",
      type:"POST",
      data:fromdtd,
      success:function(response){
        if(response==1){
			alert("Saved");
		}else{
			alert(response);
		}
      },
      error: function(response) {
		  var data = JSON.stringify(response);
		  var data1 = JSON.parse(data);
		  alert(data);
		  
      },
      });
    });
  </script>
  
