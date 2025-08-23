<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Dashboard - NUB Library</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <header class="header">
    <nav>
      <ul>
        <li><a href="admin_dashboard.html" class="active">Dashboard</a></li>
        <li><a href="index.html">Logout</a></li>
      </ul>
    </nav>
  </header>

  <main class="dashboard-main">
    <h1>Welcome, Admin!</h1>
    <p>Manage books and users here.</p>

    <section class="manage-books">
      <button onclick="alert('Add book feature coming soon!')">Add Book</button>
      <button onclick="alert('Edit book feature coming soon!')">Edit Book</button>
      <button onclick="alert('Delete book feature coming soon!')">Delete Book</button>
    </section>

    <section class="manage-users">
      <h2>User Management</h2>
      <p>Feature to view and manage users will be added.</p>
    </section>
  </main>

  <footer class="footer">
    <p>&copy; 2025 Northern University Bangladesh</p>
  </footer>
  <script src="script.js"></script>
</body>
</html>
