<?php
				
				    header('Access-Control-Allow-Origin: *');
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
					
					
					
					$sql =	"select * from csvfiles;";
				
					$show = mysqli_query($con, $sql);
					$output_array = array();
					if(mysqli_num_rows($show) > 0)
					{
						while($row = mysqli_fetch_assoc($show))
						{
							//echo $row['association_time']."<br/>";
							$temp_array = array(
							"client_username" => $row['client_username'],
							"client_ip_address" => $row['client_ip_address'],
							"client_mac_address" => $row['client_mac_address'],
							"association_time" => $row['association_time'],
							"vendor" => $row['vendor'],
							"ap_name" => $row['ap_name'],
							"device_name" => $row['device_name'],
							"map_location" => $row['map_location'],
							"ssid" => $row['ssid'],
							"profile" => $row['profile'],
							"vlan_id" => $row['vlan_id'],
							"protocol" => $row['protocol'],
							"session_duration" => $row['session_duration'],
							"policy_type" => $row['policy_type'],
							"avg_session_throughput" => $row['avg_session_throughput']);
							$output_array[] = $temp_array;
						}
						
					}
					
					
					echo json_encode($output_array);
							
						
?>

