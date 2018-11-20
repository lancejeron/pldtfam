<?php
    $servername = 'localhost';
    $username = 'root';
    $password = '@root';
    $dbname = 'dbpldt';

    $conn = mysqli_connect($servername, $username, $password, $dbname);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>COE Request</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel ="stylesheet" href = "https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap.min.css"/>
    <script src='https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js'></script>
    <script src='https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap.min.js'></script>
    <!-- css -->
    <!-- <link rel = "stylesheet" href = "assets/datatables/style_for_index.css"> -->
    <!-- <link rel = "stylesheet" href = "assets/datatables/jquery.dataTables.css"> -->
</head>
<body>
    <!-- connections -->
        <h1> COE Request </h1>

        <?php
            $servername = 'localhost';
            $username = 'root';
            $password = '@root';
            $dbname = 'dbpldt';
            
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            
                    $sql = 'SELECT * FROM dbo.prepared_certificates';
                    $result = $conn->query($sql);
                    
                    echo " 
                    <div class='table-responsive'>
                    <table class='table table-striped table-bordered' id='datatable'>
                    <thead>
                    <tr>
                    <th>Reference No.</th>
                    <th>Employee ID </th>
                    <th>Date Prepared</th>
                    <th>Name</th>
                    <th>Purpose</th>
                    <th>Accomp Code</th>
                    <th>CBO Type</th>
                    <th>Control ID</th>
                    <th>Personal</th>
                    <th>Processed</th>
                    <th>Claim</th>
                    <th>Out for Mailing</th>
                    <th>Claimers Name</th>
                    <th>Claim Date</th>
                    </tr>";

                    if ($result->num_rows > 0){
                        while ($row = $result->fetch_assoc()){
                            echo "<tr>";
                            echo "<td>" . $row['ref_no'] . "</td>";
                            echo "<td>" . $row['emp_id'] . "</td>";
                            echo "<td>" . $row['date_prepared'] . "</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['purpose'] . "</td>";
                            echo "<td>" . $row['accomp_code'] . "</td>";
                            echo "<td>" . $row['cbotype'] . "</td>";
                            echo "<td>" . $row['control_id'] . "</td>";
                            echo "<td>" . $row['personal'] . "</td>";
                            echo "</tr>";
                            echo "</div>";
                        }
                    }
                    else {
                        echo "0 results";
                    }
                    
                    $conn->close();
                    
                ?>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
            });
        </script>
</body>

</html>