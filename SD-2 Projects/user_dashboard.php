<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>User Dashboard - NUB Library</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <header class="header">
    <nav>
      <ul>
        <li><a href="user_dashboard.html" class="active">Dashboard</a></li>
        <li><a href="index.html">Logout</a></li>
      </ul>
    </nav>
  </header>

  <main class="dashboard-main">
    <h1>Welcome, User!</h1>
    <p>Here you can search and borrow books.</p>
    
    <section class="search-section">
      <input type="text" placeholder="Search books..." id="bookSearch" />
      <button onclick="alert('Search functionality coming soon!')">Search</button>
    </section>

    <section class="borrowed-books">
      <h2>Your Borrowed Books</h2>
      <ul>
        <li>No books borrowed yet.</li>
      </ul>
    </section>
  </main>

  <footer class="footer">
    <p>&copy; 2025 Northern University Bangladesh</p>
  </footer>
  <script src="script.js"></script>
</body>
</html>
