<?php
include('connection.php');
include('header.php'); // Include the header

// Function to fetch GFG user data
function fetch_gfg_user_data($gfg_username) {
    try {
        $url = "https://www.geeksforgeeks.org/user/$gfg_username";
        $html = @file_get_contents($url);

        if (!$html) {
            return null;
        }

        // Extract JSON data
        preg_match('/<script id="__NEXT_DATA__" type="application\/json">(.+)<\/script>/s', $html, $matches);
        if (!isset($matches[1])) {
            return null;
        }

        $jsonData = json_decode($matches[1], true);
        $userInfo = $jsonData['props']['pageProps']['userInfo'] ?? null;

        // Extract problem categories from DOM
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($html);
        libxml_clear_errors();

        $xpath = new DOMXPath($doc);
        $nodes = $xpath->query('//div[@class="problemNavbar_head_nav--text__UaGCx"]');
        $problemCategories = [];

        foreach ($nodes as $node) {
            preg_match('/([A-Za-z]+)\s*\((\d+)\)/', trim($node->textContent), $categoryMatches);
            if (isset($categoryMatches[1], $categoryMatches[2])) {
                $problemCategories[$categoryMatches[1]] = $categoryMatches[2];
            }
        }

        return [
            'name' => $userInfo['name'] ?? 'N/A',
            'score' => $userInfo['score'] ?? 0,
            'totalProblemsSolved' => $userInfo['total_problems_solved'] ?? 0,
            'problemCategories' => $problemCategories
        ];
    } catch (Exception $e) {
        return null;
    }
}

// Function to get previous day's stats
function get_previous_day_stats($connection, $geeks_name, $previous_date) {
    $query = "SELECT * FROM daily_problem_stats WHERE geeks_name = ? AND date = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ss", $geeks_name, $previous_date);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows > 0 ? $result->fetch_assoc() : null;
}

// Function to update daily stats (no cumulative calculation)
function update_daily_stats($connection, $geeks_name, $date, $data) {
    $todayTotalProblems = $data['totalProblemsSolved'];
    $score = $data['score'];
    $school = $data['problemCategories']['SCHOOL'] ?? 0;
    $basic = $data['problemCategories']['BASIC'] ?? 0;
    $easy = $data['problemCategories']['EASY'] ?? 0;
    $medium = $data['problemCategories']['MEDIUM'] ?? 0;
    $hard = $data['problemCategories']['HARD'] ?? 0;

    // Check if today's record exists
    $query = "SELECT id FROM daily_problem_stats WHERE geeks_name = ? AND date = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ss", $geeks_name, $date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update existing record (no cumulative calculation needed)
        $query = "UPDATE daily_problem_stats SET 
                  problems_solved = ?, score = ?, school = ?, basic = ?, easy = ?, medium = ?, hard = ? 
                  WHERE geeks_name = ? AND date = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("iiiiiiiss", $todayTotalProblems, $score, $school, $basic, $easy, $medium, $hard, $geeks_name, $date);
        $stmt->execute();
    } else {
        // Insert new record (no cumulative calculation needed)
        $query = "INSERT INTO daily_problem_stats 
                  (geeks_name, date, problems_solved, score, school, basic, easy, medium, hard) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("ssiiiiiii", $geeks_name, $date, $todayTotalProblems, $score, $school, $basic, $easy, $medium, $hard);
        $stmt->execute();
    }
}

// Main script to process data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $batch = isset($_GET['batch']) ? (int)$_GET['batch'] : 0;

    if ($batch > 0) {
        try {
            $query = "SELECT * FROM interns WHERE batch_no = ?";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("i", $batch);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $sno = 1;
                $output = '';
                $date = date('Y-m-d'); // Current date
                $previous_date = date('Y-m-d', strtotime('-1 day')); // Previous date

                while ($row = $result->fetch_assoc()) {
                    $gfgData = fetch_gfg_user_data($row['geeks_name']);

                    if ($gfgData) {
                        // Update or insert new record for today
                        update_daily_stats($connection, $row['geeks_name'], $date, $gfgData);

                        // Get previous day's data
                        $previousData = get_previous_day_stats($connection, $row['geeks_name'], $previous_date);

                        // Display the data
                      
                        $sno++;
                    }
                }
                
              $query = "SELECT DISTINCT date FROM daily_problem_stats";
                $date_result = mysqli_query($connection, $query);
                
                // Display batch stats
                echo "<div class='container mt-5'>
                        <h2 class='text-center'>Batch {$batch} Stats</h2>
                        <table class='table table-bordered'>
                            <thead>
                                <tr>
                                    <th>S No</th>
                                    <th>Date</th>
                                    <th>Batch</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>";

                // Loop through and display the dates
                while ($date_row = mysqli_fetch_assoc($date_result)) {
                    $output .= "<tr>
                                    <td>{$sno}</td>
                                    <td>" . htmlspecialchars($date_row['date']) . "</td>
                                    <td>" . htmlspecialchars($batch) . "</td>
                                    <td><a href='load2.php?date=" .$date_row['date'] . "&batch={$batch}' class='btn btn-info'>View</a></td>
                                </tr>";
                    $sno++;
                }

                echo $output;
                echo "</tbody></table></div>";
            } else {
                echo "<div class='container mt-5'>
                        <p class='text-center'>No data found for Batch {$batch}.</p>
                      </div>";
            }
        } catch (Exception $e) {
            echo "<div class='container mt-5'>
                    <p class='text-center'>Error fetching data: " . $e->getMessage() . "</p>
                  </div>";
        }
    } else {
        echo "<div class='container mt-5'>
                <p class='text-center'>Invalid batch number.</p>
              </div>";
    }
} else {
    echo "<div class='container mt-5'>
            <p class='text-center'>Invalid request method.</p>
          </div>";
}

include('footer.php'); // Include the footer
?>
