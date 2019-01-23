<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
    <div class="navbar nav_title">
        <a class="site_title"><i class="fa fa-user"></i> <span>PLDT-HRIS </span></a>
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile clearfix">
        <div class="profile_pic">
        <!-- <img src="images/img.jpg" alt="..." class="img-circle profile_img"> -->
        </div>
        <div class="profile_info">
        <span>Welcome,</span>
        <h2><?php echo $_SESSION['username'];?></h2>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- /menu profile quick info -->

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
        <h3>Menu</h3>
        <ul class="nav side-menu">
            <li><a><i class="fa fa-edit"></i> Certificate<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="index.php">Requests</a></li>
                <li><a href="index2.php">Finished Requests</a></li>
                <li><a href="index3.php">Certificates</a></li>
            </ul>
            </li>
            <li><a><i class="fa fa-wrench"></i> Maintenance <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="maintenance_purpose.php">Purpose</a></li>
            </ul>
            </li>
        </ul>
        </div>
    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
    <div class="sidebar-footer hidden-small">
        <a data-toggle="tooltip" data-placement="top" title="Logout" href="logout.php">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
        </a>
    </div>
    <!-- /menu footer buttons -->
    </div>
</div>

<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
    <nav>
        <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>
    </nav>
    </div>
</div>
<!-- /top navigation -->