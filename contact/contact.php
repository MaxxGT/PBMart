<?php
// Author: VOONG TZE HOWE
// Date Writen: 10-10-2014
// Description : contact php
// Last Modification: 11-10-2014

include('../header/header.php');
if(isset($_GET['status']) && $_GET['status']=='1')
{
	$message = "Thanks for your feedback! We value every piece of feedback we receive. We cannot respond individually to every one, but we will use your comments as we strive to improve your shopping experience.";
	echo "<script type='text/javascript'>alert('$message');</script>";
}
?>
  <table border='0' width='100%'>
	<tr>
		<td valign='top' width='200px'>
			<?php include('../sidebar/sidebar.php'); ?>
		</td>
		
		<td>
			<BR/>
			<h1> Contact Us </h1> <br /> <br />
			<?php include('../page_navigate.php'); ?>
			
			<!--Banner Start -->
				<?php include('contact_banner.php'); ?>
			<!-- Banner End -->
			
			<!--Contact Info Start -->
				<?php include('contact_info.php'); ?>
			<!--Contact Info End -->
			
			<!-- Feedback Form Start-->
				<?php include('contact_feedback.php'); ?>
			<!-- Feedback Form End-->    
		</td>
		
	</tr>
	<tr>
		<td colspan='2'>
				<?php include('../footer/sidefull.php'); ?>
		</td>
	</tr>
  </table>
  <?php include('../footer/footer.php'); ?>
</body>
</html>
