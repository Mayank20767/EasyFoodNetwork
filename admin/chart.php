<?php
$conn=new mysqli('localhost','root','','demo');

// Fetch the top 5 users who delivered the most with their locations
$top_users_query = "SELECT name, email, COUNT(Fid) as deliveries, GROUP_CONCAT(DISTINCT location SEPARATOR ', ') as locations FROM food_donations GROUP BY name, email ORDER BY deliveries DESC LIMIT 5;";
$top_users_result = $conn->query($top_users_query);

$names = [];
$deliveries = [];
$locations = [];

while ($row = $top_users_result->fetch_assoc()) {
    $names[] = $row['name'];
    $deliveries[] = $row['deliveries'];
    $locations[] = $row['locations'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Top Users Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 20px;
}

h1 {
    text-align: center;
    margin-bottom: 20px;
}

canvas {
    display: block;
    margin: 0 auto;
    max-width: 600px;
    margin-bottom: 20px;
}

.user-locations {
    margin-top: 20px;
}

.user-location {
    margin-bottom: 10px;
}

.user-location strong {
    font-weight: bold;
    margin-right: 5px;
}

.user-location span {
    font-style: italic;
}

    </style>
</head>
<body>
    <h1>Top Users Chart</h1>
    <canvas id="topUsersChart"></canvas>
    <script>
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

        var locations = <?php echo json_encode($locations); ?>;
        var userDivs = document.createElement('div');
        locations.forEach(function(location, index) {
            var div = document.createElement('div');
            div.innerHTML = '<strong>' + <?php echo json_encode($names); ?>[index] + ':</strong> ' + location;
            userDivs.appendChild(div);
        });
        document.body.appendChild(userDivs);
    </script>
</body>
</html>
