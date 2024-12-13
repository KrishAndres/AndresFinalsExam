<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'HR') {
    header('Location: login.php');
    exit;
}

$jobPosts = fetchJobPosts();
$applications = fetchApplications();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboard.css">
    <title>HR Dashboard</title>
</head>
<body>
  <div class='container'>
    <h1>Job Application System</h1>
    <h2>HR Dashboard</h2>
    <h3>Create Job Post</h3>
    <form action="core/handleforms.php" method="POST">
    <p><label for="title">Job Title:</label>
        <input type="text" name="title" id="title" required></p>

    <p><label for="description">Job Description:</label>
        <textarea name="description" id="description" required></textarea></p>

        <p><button type="submit" name="add_job_post">Post Job</button></p>
    </form>
    
    <h2>Job Applications</h2>
    <a href="hr_messages.php">Go to Messages</a>
    
    <table border="1">
    <tr>
        <th>Job Title</th>
        <th>Applicant</th>
        <th>Message</th>
        <th>Resume</th>
        <th>Status</th>
        <th>Actions</th>
        <th> </th>
    <?php foreach ($applications as $application): ?>
        <tr>
            <td><?= htmlspecialchars($application['job_title']) ?></td>
            <td><?= htmlspecialchars($application['applicant_name']) ?></td>
            <td><?= htmlspecialchars($application['message']) ?></td>
            <td><a href="resumes/<?= htmlspecialchars($application['resume_path']) ?>">Download</a></td>
            <td><?= htmlspecialchars($application['status']) ?></td>
            <td>
                <form action="core/handleforms.php" method="POST">
                    <input type="hidden" name="application_id" value="<?= $application['id'] ?>">
                    <select name="status">
                        <option value="ACCEPTED">Accept</option>
                        <option value="REJECTED">Reject</option>
                    </select>
                    <td><button type="submit" name="update_application_status">Update</button></td>
                </form>
            </td>
            
            </td>
        </tr>
    <?php endforeach; ?>
    </table>

    <h2>Job Posts</h2>
    <table>
    <tr>
        <th>Job Title</th>
        <th>Description</th>
        <th>Date Posted</th>
    <?php foreach ($jobPosts as $job): ?>
        <tr>
            <td><?= htmlspecialchars($job['title']) ?></td>
            <td><?= htmlspecialchars($job['description']) ?></td>
            <td><?= htmlspecialchars($job['created_at']) ?></td>
        </tr>
    <?php endforeach; ?>
    </table>
    <p> </p>
    <form action="core/handleforms.php" method="POST">
        <button type="submit" name="logout">Logout</button>
    </form>
    <div>
</body>
</html>