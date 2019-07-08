<html>
 <head>
 <Title>submission 1 imambudi808</Title>

 </head>
 <body>
 <h1>Input data sederhana</h1>
 
 <form method="post" action="index.php" enctype="">      
       <input type="text" name="name" id="nama" placeholder="Nama Barang">
       <input type="text" name="jumlah" id="jumlah" placeholder="Jumlah Barang">
       <input type="submit" name="submit" value="Submit" >
       <input type="submit" name="load_data" value="Load Data" >
 </form>
 <?php
    $host = "imambudi808.database.windows.net";
    $user = "imambudi808";
    $pass = "NomorSatu123";
    $db = "db_test";

    try {
        $conn = new PDO("sqlsrv:server = $host; Database = $db", $user, $pass);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } catch(Exception $e) {
        echo "Failed: " . $e;
    }

    if (isset($_POST['submit'])) {
        try {
            $name = $_POST['name'];
            $jumlah = $_POST['jumlah'];            
            $date = date("Y-m-d");
            // Insert data
            $sql_insert = "INSERT INTO tbl_barang (name, jumlah, date) 
                        VALUES (?,?,?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bindValue(1, $name);
            $stmt->bindValue(2, $jumlah);            
            $stmt->bindValue(3, $date);
            $stmt->execute();
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }

        echo "<h3>Masok Pak Ekoo!</h3>";
    } else if (isset($_POST['load_data'])) {
        try {
            $sql_select = "SELECT * FROM tbl_barang";
            $stmt = $conn->query($sql_select);
            $registrants = $stmt->fetchAll(); 
            if(count($registrants) > 0) {
                echo "<h2>Daftar Barang:</h2>";
                echo "<table>";
                echo "<tr><th>Name</th>";
                echo "<th>jumlah</th>";                
                echo "<th>Date</th></tr>";
                foreach($registrants as $registrant) {
                    echo "<tr><td>".$registrant['name']."</td>";
                    echo "<td>".$registrant['jumlah']."</td>";                    
                    echo "<td>".$registrant['date']."</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<h3>Gk Ada Barang.</h3>";
            }
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }
    }
 ?>
 </body>
 </html>