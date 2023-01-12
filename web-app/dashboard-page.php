<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    
    <title>Dashboard</title>

    <!--morris -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

     <!--data tables-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>

    <!--dashboard page-->
    <link rel="stylesheet" href="dashboard-style.css">
    <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <script>
    $(document).ready( function () {
    $('#medicion').DataTable(
    {
        paging: false,
        scrollY: 300,
        searching:false,
        info:false
    });
    } );

    </script>

</head>
<body>

    <div class="header">
        <a href="home-page.html"> HOME</a>
        
    </div>


    <center>
        <div class="window">
            <div class="box">
                <h1 style="color: rgb(64, 63, 63); font-family: 'Oswald';">Tabla</h1>



                <table style="color: rgb(64, 63, 63); font-family: 'Oswald';"  id = "medicion" class="display">
                <thead>
        <tr>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Temperatura</th>
            <th>Humedad</th>
        </tr>
        </thead>
       

                <?php



    $host = "localhost";                 // host = localhost because database hosted on the same server where PHP files are hosted
    $dbname = "incubit";              // Database name
    $username = "incubit";        // Database username
    $password = "password";	        // Database password


// Establish connection to MySQL database
$conn = new mysqli($host, $username, $password, $dbname);


// Check if connection established successfully
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

else { //echo "Connected to mysql database. <br>"; 
}


// Select values from MySQL database table

$sql = "SELECT ID_medicion, Temperatura, Humedad, Fecha, Hora FROM medicion ORDER BY ID_medicion DESC LIMIT 15";  // Update your tablename here
$sql2 = "SELECT ID_medicion, Temperatura, Humedad, Fecha, Hora FROM (SELECT * FROM medicion ORDER BY ID_medicion DESC LIMIT 15) lastNrows_subquery ORDER BY ID_medicion";  // Update your tablename here

$result = $conn->query($sql);
$result2 = $conn->query($sql2);

echo "<center>";



if ($result->num_rows > 0) {

  $chart_data = "";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        //data para tabla
        echo '<tbody>';
        echo '<tr>';
        echo '<td>'. $row['Fecha'] .'</td>';
        echo '<td>'. $row['Hora'] .'</td>';
        echo '<td>'. $row['Temperatura'] .'</td>';
        echo '<td>'. $row['Humedad'] .'</td>';
        echo '</tr>';
        echo '</tbody';
    }

} else {
    echo "0 results";
}

if ($result2->num_rows > 0) {

    $chart_data = "";
      // output data of each row
      while($row = $result2->fetch_assoc()) {
          //data para grafica
          $chart_data .= "{ temperatura: ".$row["Temperatura"].", humedad: ".$row["Humedad"].", hora: '".$row["Hora"]."' },";
      }
  
  } else {
      echo "0 results";
  }


echo "</center>";

$conn->close();



?>
</table>
            
            </div>
            <div class="box">
                <h1 style="color: rgb(64, 63, 63); font-family: 'Oswald';">Gráfica</h1>
                <div id="chart"></div>
            </div>
        </div>
    </center>
    
    
</body>
</html>

<script>
        Morris.Line({
            element : 'chart',
            data: [<?php echo $chart_data; ?>],
            xkey: 'hora',
            ykeys: ['temperatura', 'humedad'],
            labels: ['Temperatura ºC', 'Humedad %'],
            lineColors: ['#E39774', '#7FB7BE'],
            parseTime: false,
            resize: true
            
        })
</script>