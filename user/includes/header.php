<!-- Top Bar Start -->
                <div class="topbar">

                    <nav class="navbar-custom">

                        <ul class="list-unstyled topbar-right-menu float-right mb-0">

                            


                            

                            <?php
$uid=$_SESSION["id_customer"];
$ret=mysqli_query($con,"select FullName from tbluser where ID='$uid'");
$row=mysqli_fetch_array($ret);
$name=$row['FullName'];

?>

                            <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle nav-user" data-toggle="dropdown" href="#" role="button"
                                   aria-haspopup="false" aria-expanded="false">
                                    <img src="assets/images/user.png" alt="user" class="rounded-circle"> <span class="ml-1"><?php echo $name; ?> <i class="mdi mdi-chevron-down"></i> </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
                                    <!-- item-->
                                    <div class="dropdown-item noti-title">
                                        <h6 class="text-overflow m-0">Welcome !</h6>
                                    </div>

                                    <!-- item-->
                                    <a href="user-profile.php" class="dropdown-item notify-item">
                                        <i class="fi-head"></i> <span>My Profile</span>
                                    </a>

                                    <!-- item-->
                                    <a href="changepassword.php" class="dropdown-item notify-item">
                                        <i class="fi-cog"></i> <span>Change Password</span>
                                    </a>

                                    
                                    <a href="logout.php" class="dropdown-item notify-item">
                                        <i class="fi-power"></i> <span>Logout</span>
                                    </a>

                                </div>
                            </li>

                        </ul>

                        

                    </nav>

                </div>
                <!-- Top Bar End -->

