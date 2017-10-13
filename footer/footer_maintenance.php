<!-- Footer -->
  <div id="footer">
    <p class="left"> <a href="">Home</a> <span>|</span> 
					 <a href="">Products</a> <span>|</span>
					 <a href="">Redeem Product</a> <span>|</span> 
					 
					 <?php
					if(isset($_SESSION['usr_name']))
					{ ?>
						<a href="">My Account</a> <span>|</span> 
						
			  <?php }else
					{ ?>
						<a href="">Account</a> <span>|</span> 
			  <?php } ?>

					 <a href="#">Help</a> <span>|</span> 
					 <a href="">Contact</a> <span>|</span>
					 <a href="">My Shopping Cart</a> </p>
    <p class="right"> &copy; 2014 PBMART. Design by XSoft Solutions </a> </p>
  </div>
<!-- End Footer -->		