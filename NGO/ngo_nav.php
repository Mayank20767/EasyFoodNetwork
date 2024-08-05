<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
</head>

<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <!--<img src="images/logo.png" alt="">-->
            </div>
            <span class="logo_name"><?php $_SESSION['ngo_name'] ?></span>
        </div>
        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="ngo.php"><i class="uil uil-estate"></i><span class="link-name">Profile</span></a></li>
                <!-- <li><a href="donate.php"><i class="uil uil-heart"></i><span class="link-name">Donates</span></a></li> -->
                <!-- <li><a href="feedback.php"><i class="uil uil-comments"></i><span class="link-name">Feedbacks</span></a>
                </li> -->
                <li><a href="history.php"><i class="uil uil-user"></i><span class="link-name">History</span></a>
                </li>
                <!-- <li><a href="#"><i class="uil uil-share"></i><span class="link-name">Share</span></a></li> -->
            </ul>
            <ul class="logout-mode">
                <li><a href="../logout2.php"><i class="uil uil-signout"></i><span class="link-name">Logout</span></a>
                </li>
                <li class="mode">
                    <a href="#"><i class="uil uil-moon"></i><span class="link-name">Dark Mode</span></a>
                    <div class="mode-toggle">
                        <span class="switch"></span>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</body>

</html>