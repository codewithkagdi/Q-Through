<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Q Through – Queue Wait Time Estimator</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #fff;
            padding: 40px;
            margin: 0;
            position: relative;
            min-height: 100vh;
            overflow-x: hidden;
            background: #000;
        }
        /* Background Video */
        .video-background {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            z-index: -1;
            object-fit: cover;
            filter: brightness(50%);
        }
        .container {
            background: rgba(255, 255, 255, 0.15);
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.4);
            animation: fadeIn 1s ease-in-out;
            backdrop-filter: blur(8px);
        }
        h2 {
            text-align: center;
            color: #fff;
            text-shadow: 0 1px 4px rgba(0,0,0,0.6);
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
            margin-bottom: 30px;
        }
        form label {
            flex-basis: 100%;
            font-weight: bold;
            color: #fff;
            text-shadow: 0 1px 3px rgba(0,0,0,0.6);
        }
        form input[type="number"],
        form input[type="text"],
        form select {
            padding: 10px;
            border: 1px solid rgba(255,255,255,0.5);
            border-radius: 6px;
            width: 100%;
            background: rgba(255,255,255,0.2); /* transparent background */
            color: #fff; /* typed text color */
            caret-color: #fff; /* cursor color */
        }
        form input::placeholder,
        form select::placeholder {
            color: rgba(255,255,255,0.7); /* placeholder text */
        }
        /* Custom dropdown arrow for select */
        form select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background: rgba(255,255,255,0.2) url('data:image/svg+xml;utf8,<svg fill="white" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>') no-repeat right 10px center;
            background-size: 1em;
            padding-right: 35px;
        }
        form input[type="submit"] {
            background-color: rgba(85, 99, 222, 0.8);
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
            margin-top: 10px;
        }
        form input[type="submit"]:hover {
            background-color: rgba(68, 82, 184, 0.8);
            transform: scale(1.05);
        }
        .section {
            margin-bottom: 25px;
            color: #fff;
            text-shadow: 0 1px 3px rgba(0,0,0,0.6);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            text-align: center;
            color: #fff;
        }
        table th, table td {
            border: 1px solid rgba(255,255,255,0.5);
            padding: 10px;
        }
        table th {
            background: rgba(0,0,0,0.3);
            color: #fff;
        }
        .highlight {
            font-weight: bold;
            color: #ffd700;
            text-shadow: 0 1px 2px rgba(0,0,0,0.6);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<!-- Background video -->
<video autoplay muted loop class="video-background">
    <source src="full_vid.mp4" type="video/mp4">
</video>

<div class="container">
    <h2>Q Through – Queue Wait Time Estimator</h2>

    <?php
    $availableCounters = ["Billing", "Customer Support", "Repairs", "Returns"];
    ?>

    <form method="post">
        <label for="queueLength">Queue Length:</label>
        <input type="number" name="queueLength" id="queueLength" min="0" placeholder="Enter queue length" required>

        <label for="serviceTime">Average Service Time (minutes):</label>
        <input type="text" name="serviceTime" id="serviceTime" placeholder="Enter service time per person" required>

        <label for="counterName">Counter Name:</label>
        <select name="counterName" id="counterName" required>
            <option value="">-- Select Counter --</option>
            <?php
            foreach ($availableCounters as $counter) {
                echo "<option value=\"$counter\">$counter</option>";
            }
            ?>
        </select>

        <input type="submit" value="Estimate">
    </form>

<?php
$queueLength = isset($_POST['queueLength']) ? (int)$_POST['queueLength'] : 12;
$serviceTime = isset($_POST['serviceTime']) ? (float)$_POST['serviceTime'] : 4.5;
$counterName = isset($_POST['counterName']) && $_POST['counterName'] !== "" ? htmlspecialchars($_POST['counterName']) : "Billing";

echo "<div class='section'><h3>Variables & Data Types</h3>";
echo "Queue Length: <span class='highlight'>$queueLength</span> (" . gettype($queueLength) . ")<br>";
echo "Service Time: <span class='highlight'>$serviceTime</span> (" . gettype($serviceTime) . ")<br>";
echo "Counter Name: <span class='highlight'>$counterName</span> (" . gettype($counterName) . ")<br>";
$queueLengthFloat = (float)$queueLength;
echo "Queue Length after conversion: <span class='highlight'>$queueLengthFloat</span> (" . gettype($queueLengthFloat) . ")</div>";

$estimatedWait = $queueLength * $serviceTime;
$reducedWait = ($queueLength / 2) * $serviceTime;

echo "<div class='section'><h3>Operators</h3>";
echo "Estimated Wait Time: <span class='highlight'>$estimatedWait</span> minutes<br>";
echo "Reduced Wait Time (if extra counter opens): <span class='highlight'>$reducedWait</span> minutes<br>";
echo ($estimatedWait > 30) ? "Wait time is greater than 30 minutes.<br>" : "Wait time is within 30 minutes.<br>";
echo ($estimatedWait > 30 && $serviceTime > 5) ? "⚠️ High wait time and high service time per person.<br>" : "✅ Wait time or service time is acceptable.<br>";
echo "</div>";

echo "<div class='section'><h3>Conditional Statements</h3>";
echo ($estimatedWait > 30) ? "Wait Status: <span class='highlight'>Long Wait</span><br>" : "Wait Status: <span class='highlight'>Short Wait</span><br>";
$recommendation = ($estimatedWait > 45) ? "Extra Counter Recommended" : "Current Counters Sufficient";
echo "Recommendation: <span class='highlight'>$recommendation</span></div>";

$services = $availableCounters;
$queueCounter1 = ["Billing"=>10,"Customer Support"=>8,"Repairs"=>5,"Returns"=>3];
$queueCounter2 = ["Billing"=>6,"Customer Support"=>4,"Repairs"=>7,"Returns"=>2];

echo "<div class='section'><h3>Arrays</h3>";
echo "Available Services:<br>";
foreach ($services as $service) {
    echo "– $service <br>";
}
echo "</div>";

echo "<div class='section'><h3>Total Queue per Service</h3>";
echo "<table>";
echo "<tr><th>Service</th><th>Counter 1</th><th>Counter 2</th><th>Total Queue</th></tr>";
for ($i = 0; $i < count($services); $i++) {
    $s = $services[$i];
    $c1 = $queueCounter1[$s];
    $c2 = $queueCounter2[$s];
    $total = $c1 + $c2;
    echo "<tr><td>$s</td><td>$c1</td><td>$c2</td><td>$total</td></tr>";
}
echo "</table></div>";
?>
</div>
</body>
</html>
