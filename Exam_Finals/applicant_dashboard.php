<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'APPLICANT') {
    header('Location: login.php');
    exit;
}

$jobPosts = fetchJobPosts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboard.css">

    <title>Applicant Dashboard</title>
    
</head>
<body>
    <div class='container'>
        <h1>Job Application System</h1>
        
        <h2>Applicant's Dashboard</h2>
        <a href="applicant_messages.php">Go to Messages</a>
        <table>
            <tr>
                <th>Job Title</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($jobPosts as $job): ?>
                <tr>
                    <td><?= htmlspecialchars($job['title']) ?></td>
                    <td><?= htmlspecialchars($job['description']) ?></td>
                    <td>
                        <form action="core/handleforms.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="job_post_id" value="<?= $job['id'] ?>">
                            <label for="resume">Upload your CV here:</label>
                            <input type="file" name="resume" id="resume" required>
                            <br>
                            <textarea name="message" placeholder="Why should we hire for this position?" required></textarea>
                            <br>
                            <button type="submit" name="apply_to_job">Apply</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <p> </p>
        <form action="core/handleforms.php" method="POST">
            <button type="submit" name="logout">Logout</button>
        </form>
    </div>
</body>
</html>