<?php
$user = $_SESSION['user'];
$base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/ims';
?>

<div class="dashboard_slidebar" id="dashboard_slidebar">
    <h3 class="dashboard_logo" id="dashboard_logo">IMS</h3>
    <div class="dashboard_slidebar_user">
        <img src="<?= $base_url; ?>/images/user.jpg" alt="user image." id="userimage" />
        <span><?= $user['first_name'] . ' ' . $user['last_name'] ?></span>
    </div>
    <div class="dashboard_slidebar_menus">
        <ul class="dashboard_menu_lists">
            <!-- class="menuActive"     -->
            <li class="liMainMenu">
                <a href="<?php echo ($user['role'] == 1 ? 'dashboard.php' : ($user['role'] == 2 ? 'dashboard2.php' : 'dashboard3.php')); ?>">
                    <i class="fa fa-dashboard"></i><span class="menuText">Dashboard</span>
                </a>

            </li>
            <li class="liMainMenu">
                <a href="report.php"><i class="fa fa-file"></i><span class="menuText">Reports</span></a>
            </li>

            <?php if ($user['role'] == 1 || $user['role'] == 2 || $user['role'] == 3) { ?>
                <li class="liMainMenu ">
                    <a href="javascript:void(0);" class="showHideSubMenu">
                        <i class="fa fa-file showHideSubMenu"></i>
                        <span class="menuText showHideSubMenu">INVOICE </span>
                        <i class="fa fa-angle-left mainMenuIconArrow showHideSubMenu"></i>
                    </a>
                    <ul class="subMenus">
                        <li><a href="./invoice_list.php" class="subMenuLink"><i class="fa fa-circle-o"></i>Invoice List</a></li>
                        <li><a href="./create_invoice.php" class="subMenuLink"><i class="fa fa-circle-o"></i>Create Invoice</a></li>
                    </ul>
                </li>
            <?php } ?>

            <?php if ($user['role'] == 1 || $user['role'] == 2 || $user['role'] == 3) { ?>
                <li class="liMainMenu ">
                    <a href="javascript:void(0);" class="showHideSubMenu">
                        <i class="fa fa-tag showHideSubMenu"></i>
                        <span class="menuText showHideSubMenu">PRODUCT </span>
                        <i class="fa fa-angle-left mainMenuIconArrow showHideSubMenu"></i>
                    </a>
                    <ul class="subMenus">
                        <li><a href="./product-view.php" class="subMenuLink"><i class="fa fa-circle-o"></i>View Product</a></li>
                        <li><a href="./product-add.php" class="subMenuLink"><i class="fa fa-circle-o"></i>Add Product</a></li>
                    </ul>
                </li>
            <?php } ?>

            <?php if ($user['role'] == 1 || $user['role'] == 3) { ?>
                <li class="liMainMenu ">
                    <a href="javascript:void(0);" class="showHideSubMenu">
                        <i class="fa fa-truck showHideSubMenu"></i>
                        <span class="menuText showHideSubMenu">SUPPLIER </span>
                        <i class="fa fa-angle-left mainMenuIconArrow showHideSubMenu"></i>
                    </a>
                    <ul class="subMenus">
                        <li><a href="./supplier-view.php" class="subMenuLink"><i class="fa fa-circle-o"></i>View Supplier</a></li>
                        <li><a href="./supplier-add.php" class="subMenuLink"><i class="fa fa-circle-o"></i>Add Supplier</a></li>
                    </ul>
                </li>
            <?php } ?>
            <?php if ($user['role'] == 1 || $user['role'] == 3) { ?>
                <li class="liMainMenu ">
                    <a href="javascript:void(0);" class="showHideSubMenu">
                        <i class="fa fa-truck showHideSubMenu"></i>
                        <span class="menuText showHideSubMenu">BUYERS </span>
                        <i class="fa fa-angle-left mainMenuIconArrow showHideSubMenu"></i>
                    </a>
                    <ul class="subMenus">
                        <li><a href="./buyer-view.php" class="subMenuLink"><i class="fa fa-circle-o"></i>View Buyers</a></li>
                        <li><a href="./buyer-add.php" class="subMenuLink"><i class="fa fa-circle-o"></i>Add Buyers</a></li>
                    </ul>
                </li>
            <?php } ?>
            <li class="liMainMenu ">
                <a href="javascript:void(0);" class="showHideSubMenu">
                    <i class="fa fa-shopping-cart showHideSubMenu"></i>
                    <span class="menuText showHideSubMenu">PURCHASE ORDER </span>
                    <i class="fa fa-angle-left mainMenuIconArrow showHideSubMenu"></i>
                </a>

                <ul class="subMenus">
                    <li><a href="./product-order.php" class="subMenuLink"><i class="fa fa-circle-o"></i>Create Order</a></li>
                    <li><a href="./view-order.php" class="subMenuLink"><i class="fa fa-circle-o"></i>View Orders</a></li>

                </ul>
            </li>

            <?php if ($user['role'] == 1) { ?>
                <li class="liMainMenu showHideSubMenu">
                    <a href="javascript:void(0);" class="showHideSubMenu">
                        <i class="fa fa-user-plus showHideSubMenu"></i>
                        <span class="menuText showHideSubMenu">USER </span>
                        <i class="fa fa-angle-left mainMenuIconArrow showHideSubMenu"></i>
                    </a>
                    <ul class="subMenus">
                        <li><a href="./user-view.php" class="subMenuLink"><i class="fa fa-circle-o"></i>View Users</a></li>
                        <li><a href="./user-add.php" class="subMenuLink"><i class="fa fa-circle-o"></i>Add User</a></li>
                    </ul>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>