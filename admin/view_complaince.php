<?php
session_start();
ob_start();
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'demo');
if (empty($_SESSION['aemail'])) {
    header("location:signin.php");
}

// if (isset($_POST['resolved'])) {
    
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>View_Complaince</title>
    <style>
        .activity {
            padding: 20px;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        .table-wrapper {
            margin: 0 auto;
            max-width: 1000px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
            word-wrap: break-word;
            overflow-wrap: break-word;/
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .table td form {
            display: inline;
        }

        .table td form button {
            background-color: #d9534f;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
        }

        .table td form button:hover {
            background-color: #c9302c;
        }

        .table td form button:nth-child(2) {
            background-color: #5bc0de;
            margin-left: 5px;
        }

        .table td form button:nth-child(2):hover {
            background-color: #31b0d5;
        }

        .table td form button:nth-child(3) {
            background-color: #f0ad4e;
            margin-left: 5px;
        }

        .table td form button:nth-child(3):hover {
            background-color: #ec971f;
        }

        /* Responsive styling */
        @media screen and (max-width: 768px) {
            .table thead {
                display: none;
            }

            .table,
            .table tbody,
            .table tr,
            .table td {
                display: block;
                width: 100%;
            }

            .table tr {
                margin-bottom: 15px;
            }

            .table td {
                text-align: right;
                padding-left: 50%;
                position: relative;
            }

            .table td:before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                width: calc(50% - 30px);
                padding-right: 10px;
                white-space: nowrap;
                text-align: left;
                font-weight: bold;
            }
        }
    </style>
</head>

<body>
    <nav>
        <div class="logo-name">
            <span class="logo_name">ADMIN</span>
        </div>
        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="admin.php"><i class="uil uil-estate"></i><span class="link-name">Dashboard</span></a></li>
                <li><a href="participant.php"><i class="uil uil-heart"></i><span
                            class="link-name">Participant</span></a></li>
                <li><a href="view_feedback.php"><i class="uil uil-comments"></i><span
                            class="link-name">Feedbacks</span></a></li>
                <li><a href="view_complaince.php"><i class="uil uil-user"></i><span
                            class="link-name">Complaince</span></a></li>
            </ul>
            <ul class="logout-mode">
                <li><a href="../logout2.php"><i class="uil uil-signout"></i><span class="link-name">Logout</span></a>
                </li>
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
            <p class="logo"><b style="color: #06C167;">Complains</b></p>
        </div>
        <br><br><br>
        <div class="activity">
            <div class="table-container">
                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Complain_ID</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Complain</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM complaince";
                            $result = mysqli_query($connection, $query);
                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>
                                            <td data-label='Complain_ID'>{$row['complain_id']}</td>
                                            <td data-label='Catedgory'>{$row['category']}</td>
                                            <td data-label='Name'>{$row['name']}</td>
                                            <td data-label='Email'>{$row['email']}</td>
                                            <td data-label='Message'>{$row['message']}</td>
                                            <td>
                                            <form method='POST' action=''>
                                                <button type='submit' name='resolved'>Resolve</button>
                                            </form>
                                           </td>
                                          </tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <script src="admin.js"></script>
</body>

</html>