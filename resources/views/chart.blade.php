<!DOCTYPE html>
<html>
<head>
    <title>student details</title>
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
	    <script src="http://underscorejs.org/underscore-min.js"></script>  
	    <script src="https://www.gstatic.com/charts/loader.js"></script>  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
	
</head>
<body>

<div class="container">
    <div class="card bg-light mt-3">
        <div class="card-header">
            Report &nbsp;&nbsp;&nbsp;<a href="{{url('/')}}"><button class="btn btn-warning" >Back</button></a>
        </div>
        <div class="card-body">


<div id="chart" style="width: 800px; height: 600px;"></div>


<script>
var json = <?php echo json_encode($data); ?>;


// map to jsonData
var header = _.chain(json).pluck("store_name").sort().uniq(true).value();
header.unshift("Stores");

var rows = _.chain(json)
.groupBy(function(item) { return item.Time; })
.map(function(group, key) { 
    var result = [key];
    _.each(group, function(item) { 
        result[_.indexOf(header, item.store_name)] = parseInt(item.count); 
    });
    return result; 
})
.value();

var jsonData = [header].concat(rows);

// draw chart
google.load("visualization", "1", {packages:["corechart"], callback: drawChart});
function drawChart() {
    var data = google.visualization.arrayToDataTable(jsonData);
    var options = { isStacked: true };

    var chart = new google.visualization.ColumnChart(document.getElementById('chart'));
    chart.draw(data, options);
}

</script>



<!-- Styles -->
<style>
#chartdiv {
  width: 100%;
  height: 500px;
}
</style>

</body>
</html>