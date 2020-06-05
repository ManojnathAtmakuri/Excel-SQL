
<!DOCTYPE html>
<html lang="en">
 
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
</head>
 
<body>
    <div id="wrap">
        <div class="container">
            <div class="row">
 
                <form class="form-horizontal" action="" method="post" name="upload
				"enctype="multipart/form-data">
                    
 
                        <!-- Form Name -->
                        <legend> <h1 align ="center">Library Stats Upload </h1></legend>
 
                        <!-- File Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="filebutton">SELECT FILES</label>
                            <div class="col-md-4">
                                <input type="file" name="file[]" class="input-large" multiple>
                            </div>
                        </div>
 
                        <!-- Button -->
					
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="singlebutton">IMPORT DATA</label>
                            <div class="col-md-4">
                                <button type="submit" id="submit1" name="Import" class="btn btn-primary" theme="simple">Import</button>
                            </div>
                        </div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="singlebutton">DISPLAY DATA</label>
                            <div class="col-md-4">
                                <button type="submit" id="submit2" name="Display" class="btn btn-primary" theme="simple">Display</button>
                            </div>
                        </div>
				
			
						
 
                    
                </form>
 
            </div>
           
        </div>
    </div>
			<?php
			
				if(isset($_POST['Display']))
					{
					$servername = "localhost";
					$username = "root";
					$password = "";
					$db = "wifistat";
 
					try {
   
						$con = mysqli_connect($servername, $username, $password, $db);
						//echo "Connected successfully"."<br>"; 
						}
					catch(exception $e)
						{
						echo "Connection failed: " . $e->getMessage();
						}
		
					$sql1="select * from csvfiles";
					$show = mysqli_query($con, $sql1);
					if(mysqli_num_rows($show) > 0)
					{
						
						echo  "<div class='table-responsive fixed-table-body'> <table width='100%' class='table table-striped'>
								<thead> <tr>
								<th> client_username </th> <th> client_ip_address </th> <th> client_mac_address </th>
								<th> association_time </th> <th> vendor </th> <th> ap_name </th>
								<th> device_name </th> <th> map_location </th> <th> ssid </th>
								<th> profile </th> <th> vlan_id </th> <th> protocol </th>
								<th> session_duration </th> <th> policy_type </th> <th> avg_session_throughput </th>
								</tr> </thead> <tbody> 
								";
						while($row = mysqli_fetch_assoc($show))
						{
							echo" <tr> 		  <td> ".$row['client_username']."</td> <td> ".$row['client_ip_address']."</td> 
											  <td> ".$row['client_mac_address']."</td> <td> ".$row['association_time']."</td>
											  <td> ".$row['vendor']."</td> <td> ".$row['ap_name']."</td>
											  <td> ".$row['device_name']."</td> <td> ".$row['map_location']."</td>
											  <td> ".$row['ssid']."</td> <td> ".$row['profile']."</td>
											  <td> ".$row['vlan_id']."</td> <td> ".$row['protocol']."</td>
											  <td> ".$row['session_duration']."</td> <td> ".$row['policy_type']."</td>
											  <td> ".$row['avg_session_throughput']."</td> </tr>";
						}
						echo "</tbody> </table> </div>";
					}
					else
					{
						echo "<h3> You have no records </h3>";
					} 
	         
			
	         	
				}
			
			
			
				if(isset($_POST["Import"]))
				{
					$servername = "localhost";
					$username = "root";
					$password = "";
					$db = "wifistat";
 
					try {
   
						$con = mysqli_connect($servername, $username, $password, $db);
						//echo "Connected successfully"."<br>"; 
						}
					catch(exception $e)
						{
						echo "Connection failed: " . $e->getMessage();
						}
		
					$total = count($_FILES['file']['name']);

					// Loop through each file
					for($i=0; $i<$total; $i++)
					{
					// Get the temp file path
					$tmpFilePath = $_FILES['file']['tmp_name'][$i];
					if($tmpFilePath != '')
					{
						$newFilePath = $_FILES['file']['name'][$i];
						if(move_uploaded_file($tmpFilePath,$newFilePath))
						{
							$filename = $_FILES['file']['name'][$i];
							$file = fopen($filename, "r");
							$counter=0;
							while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
							{
								$counter++;
								if($counter<9)
								{
									continue;
								}
								else
								{
									//echo"".$getData[14];
									$sql = "INSERT into csvfiles(client_username,client_ip_address,client_mac_address,association_time,vendor,ap_name,
									device_name,map_location,ssid,profile,vlan_id,protocol,session_duration,policy_type,avg_session_throughput) 
									values ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."',
									'".$getData[6]."','".$getData[7]."','".$getData[8]."','".$getData[9]."','".$getData[10]."','".$getData[11]."',
									'".$getData[12]."','".$getData[13]."','".$getData[14]."')";
									
									$result = mysqli_query($con, $sql);
								
								}
								
							}
							
							fclose($file);
						}
					}
					
					}
					if(isset($result))
						echo "<h3 align='center'>Data Inserted Successfully </h3>";
					else
						echo "<h3 align='center'> Please Upload csv files</h3>";
				}
					
					
									
			?>
			
	</body>
	</html>
