<?php
include('connection.php');


// Get intern ID safely
$intern_id = mysqli_real_escape_string($connection, $_POST['intern_id']);

// Fetch intern details
$intern_query = "SELECT * FROM interns WHERE dss_id = ?";
$intern_stmt = $connection->prepare($intern_query);
$intern_stmt->bind_param("s", $intern_id);
$intern_stmt->execute();
$intern_result = $intern_stmt->get_result();

if ($intern_result->num_rows > 0) {
    $intern = $intern_result->fetch_assoc();
    $name = $intern['name'];
    $id = $intern['dss_id'];
    $idd = $intern['id'];
    $batch_no = $intern['batch_no'];
    $gfg = $intern['geeks_name'];
} else {
    echo "<script>
            alert('Wrong intern ID');
            window.location.href='index.php';
          </script>";
    exit();
}

try {
    // Validate GFG username
    if (empty($gfg)) {
        throw new Exception("GFG username is empty.");
    }

    // URL of the webpage to fetch GFG user data
    $url = "https://www.geeksforgeeks.org/user/" . urlencode($gfg);

    // Fetch the HTML from the URL
    $html = @file_get_contents($url);
    if (!$html) {
        throw new Exception("Failed to fetch GFG profile.");
    }

    // Extract JSON data inside the <script id="__NEXT_DATA__"> tag
    preg_match('/<script id="__NEXT_DATA__" type="application\/json">(.+)<\/script>/s', $html, $matches);

    if (!isset($matches[1])) {
        throw new Exception("GFG user data not found.");
    }

    // Decode JSON data
    $jsonData = json_decode($matches[1], true);
    if (!$jsonData) {
        throw new Exception("Invalid JSON format.");
    }

    // Extract user information
    $userInfo = $jsonData['props']['pageProps']['userInfo'] ?? null;

    $userName = $userInfo['name'] ?? 'N/A';
    $score = $userInfo['score'] ?? 0;
    $totalProblemsSolved = $userInfo['total_problems_solved'] ?? 0;

    // Extract problem categories from HTML
    libxml_use_internal_errors(true); // Prevent HTML parsing errors
    $doc = new DOMDocument();
    $doc->loadHTML($html);
    libxml_clear_errors();

    $xpath = new DOMXPath($doc);
    $nodes = $xpath->query('//div[@class="problemNavbar_head_nav--text__UaGCx"]');

    $problemCategories = [];
    foreach ($nodes as $node) {
        preg_match('/([A-Za-z]+)\s*\((\d+)\)/', trim($node->textContent), $match);
        if (isset($match[1]) && isset($match[2])) {
            $problemCategories[$match[1]] = $match[2];
        }
    }
} catch (Exception $e) {
    $userName = 'N/A';
    $score = 0;
    $totalProblemsSolved = 0;
    $problemCategories = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intern Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('header.php'); ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Your Details</h2>

        <!-- Intern Details -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Intern Details</h5>
                <p><strong>ID:</strong> <?php echo htmlspecialchars($id); ?></p>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
                <p><strong>Batch:</strong> <?php echo htmlspecialchars($batch_no); ?></p>
            </div>
        </div>

        <!-- Update GFG Name -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Update GFG Name</h5>
                <form action="update_gfg.php" method="POST">
                    <div class="mb-3">
                        <label for="gfg_name" class="form-label">Enter GFG Name</label>
                        <input type="text" class="form-control" id="gfg_name" name="gfg_name" value="<?php echo htmlspecialchars($gfg); ?>" required>
                    </div>
                    <input type="hidden" name="intern_id" value="<?php echo htmlspecialchars($idd); ?>">
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>

        <!-- GFG User Information -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">GFG User Information</h5>
                <table class="table table-bordered">
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Total Score</th>
                        <th>Total Problems Solved</th>
                        <th>School</th>
                        <th>Basic</th>
                        <th>Easy</th>
                        <th>Medium</th>
                        <th>Hard</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td><?php echo htmlspecialchars($userName); ?></td>
                        <td><?php echo htmlspecialchars($score); ?></td>
                        <td><?php echo htmlspecialchars($totalProblemsSolved); ?></td>
                        <td><?php echo htmlspecialchars($problemCategories['SCHOOL'] ?? '0'); ?></td>
                        <td><?php echo htmlspecialchars($problemCategories['BASIC'] ?? '0'); ?></td>
                        <td><?php echo htmlspecialchars($problemCategories['EASY'] ?? '0'); ?></td>
                        <td><?php echo htmlspecialchars($problemCategories['MEDIUM'] ?? '0'); ?></td>
                        <td><?php echo htmlspecialchars($problemCategories['HARD'] ?? '0'); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
