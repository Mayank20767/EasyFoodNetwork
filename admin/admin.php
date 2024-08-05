<?php
session_start();
ob_start();
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'demo');
if (empty($_SESSION['aemail'])) {
    header("location:signin.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Admin Dashboard Panel</title>
</head>
<body>
    <nav>
        <div class="logo-name">
            <span class="logo_name">Admin</span>
        </div>
        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="admin.php"><i class="uil uil-estate"></i><span class="link-name">Dashboard</span></a></li>
                <li><a href="participant.php"><i class="uil uil-heart"></i><span class="link-name">Participant</span></a></li>
                <li><a href="view_feedback.php"><i class="uil uil-comments"></i><span class="link-name">Feedbacks</span></a></li>
                <li><a href="view_complaince.php"><i class="uil uil-user"></i><span class="link-name">Complaince</span></a></li>
            </ul>
            <ul class="logout-mode">
                <li><a href="../logout2.php"><i class="uil uil-signout"></i><span class="link-name">Logout</span></a></li>
                <li class="mode">
                    <a href="#"><i class="uil uil-moon"></i><span class="link-name">Dark Mode</span></a>
                    <div class="mode-toggle"><span class="switch"></span></div>
                </li>
            </ul>
        </div>
    </nav>
    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <p class="logo">Food <b style="color: #06C167;">Donate</b></p>
        </div>
        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-chart"></i>
                    <span class="text">Analytics</span>
                </div>
                <div class="boxes">
                    <div class="box box1">
                        <i class="uil uil-user"></i>
                        <span class="text">Total users</span>
                        <?php
                        $query = "SELECT count(*) as count FROM login";
                        $result = mysqli_query($connection, $query);
                        $row = mysqli_fetch_assoc($result);
                        echo "<span class=\"number\">" . $row['count'] . "</span>";
                        ?>
                    </div>
                    <div class="box box2">
                        <i class="uil uil-comments"></i>
                        <span class="text">Feedbacks</span>
                        <?php
                        $query = "SELECT count(*) as count FROM feedback";
                        $result = mysqli_query($connection, $query);
                        $row = mysqli_fetch_assoc($result);
                        echo "<span class=\"number\">" . $row['count'] . "</span>";
                        ?>
                    </div>
                    <div class="box box3">
                        <i class="uil uil-heart"></i>
                        <span class="text">Total donates</span>
                        <?php
                        $query = "SELECT count(*) as count FROM food_donations";
                        $result = mysqli_query($connection, $query);
                        $row = mysqli_fetch_assoc($result);
                        echo "<span class=\"number\">" . $row['count'] . "</span>";
                        ?>
                    </div>
                </div>
                <br><br>
                <canvas id="myChart" style="width:100%;max-width:600px;margin:0 auto;margin-bottom:20px;"></canvas>
                <br>
                <script>
                    <?php
                    $query_male = "SELECT count(*) as count FROM login WHERE gender='male'";
                    $query_female = "SELECT count(*) as count FROM login WHERE gender='female'";
                    $result_male = mysqli_query($connection, $query_male);
                    $result_female = mysqli_query($connection, $query_female);
                    $count_male = mysqli_fetch_assoc($result_male)['count'];
                    $count_female = mysqli_fetch_assoc($result_female)['count'];
                    ?>
                    var xValues = ["Male", "Female"];
                    var yValues = [<?php echo $count_male; ?>, <?php echo $count_female; ?>];
                    var barColors = ["#06C167", "blue"];
                    new Chart("myChart", {
                        type: "bar",
                        data: {
                            labels: xValues,
                            datasets: [{
                                backgroundColor: barColors,
                                data: yValues
                            }]
                        },
                        options: {
                            legend: { display: false },
                            title: { display: true, text: "User details" }
                        }
                    });
                </script>
                <canvas id="locationChart" style="width:100%;max-width:300px;margin:0 auto;margin-bottom:20px;"></canvas>
                <script>
                    <?php
                    $location_query = "SELECT location, COUNT(Fid) as count FROM food_donations GROUP BY location";
                    $location_result = mysqli_query($connection, $location_query);
                    $locations = [];
                    $counts = [];
                    while ($row = mysqli_fetch_assoc($location_result)) {
                        $locations[] = $row['location'];
                        $counts[] = $row['count'];
                    }
                    ?>
                    var ctx = document.getElementById('locationChart').getContext('2d');
                    var locationChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: <?php echo json_encode($locations); ?>,
                            datasets: [{
                                label: 'Donations by Location',
                                data: <?php echo json_encode($counts); ?>,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            title: { display: true, text: "Donations by Location" }
                        }
                    });
                </script>
                <canvas id="topUsersChart" style="display:block;width:100%;max-width:600px;margin:0 auto;margin-bottom:20px;"></canvas>
                <script>
                    <?php
                    $top_users_query = "SELECT name, email, COUNT(Fid) as deliveries, GROUP_CONCAT(DISTINCT location SEPARATOR ', ') as locations FROM food_donations GROUP BY name, email ORDER BY deliveries DESC LIMIT 5";
                    $top_users_result = mysqli_query($connection, $top_users_query);
                    $names = [];
                    $deliveries = [];
                    $locations = [];
                    while ($row = mysqli_fetch_assoc($top_users_result)) {
                        $names[] = $row['name'];
                        $deliveries[] = $row['deliveries'];
                        $locations[] = $row['locations'];
                    }
                    ?>
                    var ctx = document.getElementById('topUsersChart').getContext('2d');
                    var topUsersChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: <?php echo json_encode($names); ?>,
                            datasets: [{
                                label: 'Number of Deliveries',
                                data: <?php echo json_encode($deliveries); ?>,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    // var locations = <?php //echo json_encode($locations); ?>;
                    // var userDivs = document.createElement('div');
                    // locations.forEach(function(location, index) {
                    //     var div = document.createElement('div');
                        // div.innerHTML = '<strong>' + <?php //echo json_encode($names); ?>[index] + ':</strong> ' + location;
                    //     userDivs.appendChild(div);
                    // });
                    // document.body.appendChild(userDivs);
                </script>
            </div>
        </div>
    </section>
    <script src="admin.js"></script>
</body>
</html>
