<?php
include('connection.php');

// Function to fetch GFG user data
function fetch_gfg_user_data($gfg_username) {
    try {
        $url = "https://www.geeksforgeeks.org/user/$gfg_username";
        $html = @file_get_contents($url); // Use @ to suppress warnings if the user profile doesn't exist

        if (!$html) {
            return null; // If the page is not accessible
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $batch = isset($_POST['batch']) ? (int)$_POST['batch'] : 0;

    if ($batch > 0) {
        try {
            $query = "SELECT * FROM interns WHERE batch_no = ?";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("i", $batch);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $output = '';
                $sno = 1;

                while ($row = $result->fetch_assoc()) {
                    $gfgData = fetch_gfg_user_data($row['geeks_name']);
                    $categories = $gfgData['problemCategories'] ?? [];

                    $output .= "<tr>
                                    <td>{$sno}</td>
                                    <td>" . htmlspecialchars($row['name']) . "</td>
                                    <td>" . htmlspecialchars($row['batch_no']) . "</td>
                                    <td>" . htmlspecialchars($row['geeks_name']) . "</td>
                                    <td>" . htmlspecialchars($gfgData['score'] ?? 'N/A') . "</td>
                                    <td>" . htmlspecialchars($gfgData['totalProblemsSolved'] ?? '0') . "</td>
                                    <td>" . htmlspecialchars($categories['SCHOOL'] ?? '0') . "</td>
                                    <td>" . htmlspecialchars($categories['BASIC'] ?? '0') . "</td>
                                    <td>" . htmlspecialchars($categories['EASY'] ?? '0') . "</td>
                                    <td>" . htmlspecialchars($categories['MEDIUM'] ?? '0') . "</td>
                                    <td>" . htmlspecialchars($categories['HARD'] ?? '0') . "</td>
                                </tr>";
                    $sno++;
                }

                echo $output;
            } else {
                echo "<tr><td colspan='11' class='text-center'>No data found for Batch {$batch}.</td></tr>";
            }
        } catch (Exception $e) {
            echo "<tr><td colspan='11' class='text-center'>Error fetching data: " . $e->getMessage() . "</td></tr>";
        }
    } else {
        echo "<tr><td colspan='11' class='text-center'>Invalid batch number.</td></tr>";
    }
} else {
    echo "<tr><td colspan='11' class='text-center'>Invalid request method.</td></tr>";
}
?>
