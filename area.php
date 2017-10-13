<link rel="stylesheet" href="css/input_search.css">

<?php
include("connection/pbmartconnection.php");
$q = $_GET['q'];
$sql="SELECT * FROM pbmart_service_area WHERE pbmart_service_area LIKE '%".$q."%'";
$result = @mysql_query($sql);
while($row = @mysql_fetch_array($result)) {
    //echo "<li><a href='#'".$row['pbmart_service_area']."'>'".$row['pbmart_service_postcode']."'<br><span>'".$row['pbmart_service_area']."'</span></a></li>";
	?>
		<li><a href="?ky=<?php echo $row['pbmart_service_area']; ?>#<?php echo $row['pbmart_service_area']; ?>"><?php echo $row['pbmart_service_postcode']; ?><br><span><?php echo $row['pbmart_service_area']; ?></span></a></li>
<?php } ?>
</ul>