<!-- Footer -->
  <div id="footer">
    <p class="left"> <a href="index.php">Home</a> <span>|</span> 
					 <a href="promotions_index.php?hyperlink=promotion">Promotion</a> <span>|</span>
					 <a href="products.php?hyperlink=product">Products</a> <span>|</span>
					 <a href="tupperwares.php?hyperlink=tupperware">Tupperware</a> <span>|</span>
					 <a href="redemption.php?hyperlink=redemption">Redeem</a> <span>|</span> 
					 
					 <?php
					if(isset($_SESSION['usr_name']))
					{ ?>
						<a href="myaccount.php?hyperlink=myaccount">My Account</a> <span>|</span>
			  <?php }else
					{ ?>
						<a href="account.php?hyperlink=account">Account</a> <span>|</span> 
			  <?php } ?>

					 <a href="help.php?hyperlink=help">Help</a> <span>|</span>
					 <a href="careers.php?hyperlink=careers">Careers</a> <span>|</span>					 
					 <a href="contact.php?hyperlink=contact">Contact Us</a>
					 </p>
    <p class="right"> &copy; 2014 PBMART. Design by XSoft Solutions </a> </p>
  </div>
<!-- End Footer -->		