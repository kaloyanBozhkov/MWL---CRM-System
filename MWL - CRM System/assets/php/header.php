  <div class="wrapper">
        <div class="sidebar" data-color="purple" data-image="assets/img/sidebar-1.jpg">
            <div class="logo">
                <a href="index.php" class="simple-text">
                   MWL - CRM System
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li <?php echo($extra1); ?>>
                        <a href="dashboard.php">
                            <span class="glyphicon glyphicon-book inline-block"></span>
                            <p class="inline-block">Dashboard</p>
                        </a>
                    </li>
                    <li <?php echo($extra2); ?> >
                        <a href="companies.php">
                            <span class="glyphicon glyphicon-list-alt inline-block"></span>
                            <p class="inline-block">Companies</p> 
                        </a>
                    </li>
					<li <?php echo($extra3); ?> >
                        <a href="branches.php">
                             <span class="glyphicon glyphicon-folder-close inline-block"></span>
                            <p class="inline-block">Branches</p>
                        </a>
                    </li>
					 <li <?php echo($extra4); ?> >
                        <a href="contacts.php">	
                            <span class="glyphicon glyphicon-user inline-block"></span>
                            <p class="inline-block">Contacts</p>
                        </a>
                    </li>
                    <li <?php echo($extra5); ?> >
                        <a href="emails.php">	
                            <span class="glyphicon glyphicon glyphicon-envelope	inline-block"></span>
                            <p class="inline-block">Email Addresses</p>
                        </a>
                    </li>
                    <li <?php echo($extra6); ?> >
                        <a href="phones.php">	
                            <span class="glyphicon glyphicon glyphicon-earphone	inline-block"></span>
                            <p class="inline-block">Phone Numbers</p>
                        </a>
                    </li>
					<li id='btnLogout'>
                        <a href="#">	
                            <span class="glyphicon glyphicon-log-out inline-block"></span>
                            <p class="inline-block">Logout</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"> <?php $listings = " Listings"; if($what == "dashboard"){$listings="";}; echo(ucwords($what.$listings));?>  </a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <form class="navbar-form navbar-right" role="search">
                            <div class="form-group  is-empty">
                                <input id="searchBox" type="text" class="form-control" placeholder="Search">
                                <span class="material-input"></span>								
                            </div>
                            <button id="searchBoxBtn" type="submit" class="btn btn-white btn-round btn-just-icon zoomed-out-tiny transition-0-5">
                                <span class="glyphicon glyphicon-search"></span>
                                <div class="ripple-container"></div>
                            </button>
							<span id="<?php $a = "d"; if($what == "company"){$a = "c";}elseif($what == "branch"){$a = "b";}elseif($what == "contact"){$a = "e";}elseif($what == "email address"){$a = "ea";}if($what == "phone number"){$a = "ph";} echo($a); ?>" class="hidden"></span>
                        </form>
                    </div>
                </div>
            </nav>