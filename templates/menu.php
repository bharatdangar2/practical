<body>
    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo BASE_URL; ?>">Practical</a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
            </ul>
        </nav>
        <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <li>
                        <a href="<?php echo BASE_URL; ?>"
                            <?php if(isset($page_slug)){ if($page_slug == 'dashboard') { echo "class='active-menu'";} } ?> >
                            <i class="fa fa-dashboard"></i> Dashboard
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo BASE_URL.'inventory_list.php'; ?>"
                            <?php if(isset($page_slug)){ if($page_slug == 'inventory_list') { echo "class='active-menu'";} } ?> >
                            <i class="fa fa-table"></i> Products
                        </a>
                    </li>

                </ul>

            </div>

        </nav>
        <!-- /. NAV SIDE  -->