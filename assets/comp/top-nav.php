<nav class="navbar navbar-default navbar-fixed-top">
		<!-- Logo -->
		<div class="logo">
			<a href="dashboard"> <img src="//<?php echo $domain_path;?>/assets/img/aplogo2.png">
			</a>
		</div>
		<!-- End Logo -->
		<div id="navbar">
			<ul class="nav navbar-nav">
				<li class="active menu-toggle">
					<a href="#menu-toggle" id="menu-toggle">
						<i class="fa fa-menu"></i>
					</a>
				</li>
				
			</ul>
			
			<!-- Start Notifications -->
			<ul class="nav navbar-nav navbar-right notifications">
				<li class="dropdown balance">
					<div class="control-group">
					  <div class="controls">
							<span style="color:#333;">Balance:</span> <?php balance($owner);?>
					  </div>
					</div>
				</li>
				<li class="dropdown language">
					<div class="control-group">
					  <div class="controls">
						  <form method="post" action="lang/change-lang.php">
								<div class="lang-select">
							  <select onchange="this.form.submit()" name="selected_lang" class="input-large">
								  <option value="en" <?php if($language=='en'){echo 'selected="selected"';}?>>English</option>
								  <option value="fr" <?php if($language=='fr'){echo 'selected="selected"';}?>>French</option>
								  <option value="de" <?php if($language=='de'){echo 'selected="selected"';}?>>German</option>
								  <option value="es" <?php if($language=='es'){echo 'selected="selected"';}?>>Spanish</option>
								</select>
								</div>
						  </form>
							
					  </div>
					</div>
				</li>
				<li class="dropdown language">
					<div class="control-group">
					  <div class="controls">
						  <form method="post" action="lang/change-currency.php" style="margin-left:5px;">
								<div class="lang-select">
								<input type="hidden" name="redirect" value="<?php echo pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);?>">
							  <select onchange="this.form.submit()" name="selected_currency" class="input-large">
								  <option value="en-US" <?php if($_SESSION['locale']=='en-US'){echo 'selected="selected"';}?>>USD</option>
									<option value="en-GB" <?php if($_SESSION['locale']=='en-GB'){echo 'selected="selected"';}?>>GBP</option>
								  <option value="en-IN" <?php if($_SESSION['locale']=='en-IN'){echo 'selected="selected"';}?>>INR</option>
								  <option value="de-DE" <?php if($_SESSION['locale']=='de-DE'){echo 'selected="selected"';}?>>EUR</option>
								  <option value="ja_JP" <?php if($_SESSION['locale']=='ja_JP'){echo 'selected="selected"';}?>>JPY</option>
									<option value="ru_RU" <?php if($_SESSION['locale']=='ru_RU'){echo 'selected="selected"';}?>>RUR</option>
								</select>
								</div>
						  </form>
					  </div>
					</div>
				</li>
				
				<!-- Start My Account Dropdown -->
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<?php avatar($userid);?>
						<span class="navbar-user"><span><?php echo ucwords($fullname);?></span></span>
						<b class="caret"></b>
					</a>
					<ul class="nav-account dropdown-menu">
						<li>
							<a href="profile"><i class="icon-primary fa fa-fw fa-smile"></i> <?php echo $lang['ACCOUNT_PROFILE'];?></a>
						</li>
						
						<?php 
						$lang_u = $lang['USER_MANAGEMENT'];
						$lang_a = $lang['ADMIN_SETTINGS'];
						admin_control($admin_user, $lang_u, $lang_a);
						?>
						
						<li>
							<a href="//<?php echo $domain_path;?>/access/logout"><i class="icon-danger fa fa-fw fa-circle-notch"></i> <?php echo $lang['LOGOFF'];?></a>
						</li>
					</ul>
				</li>
				<!-- End My Account Dropdown -->
			</ul><!-- End Notfications --> 
        </div>
   </nav><!-- End Top Navigation --> 