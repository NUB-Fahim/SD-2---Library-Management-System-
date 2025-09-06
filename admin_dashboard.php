<?php
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "nub_library_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'add_book') {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $category = $_POST['category'];
        $book_code = $_POST['book_code'];
        $quantity = $_POST['quantity']; // New: Quantity for the book

        $stmt = $conn->prepare("INSERT INTO books (title, author, category, book_code, quantity) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $title, $author, $category, $book_code, $quantity); // 'i' for integer quantity
        $stmt->execute();
        $stmt->close();

    } elseif ($action === 'edit_book') {
        $book_id = $_POST['book_id'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $category = $_POST['category'];
        $book_code = $_POST['book_code'];
        $status = $_POST['status'];
        $quantity = $_POST['quantity']; // New: Quantity for the book

        $stmt = $conn->prepare("UPDATE books SET title=?, author=?, category=?, book_code=?, status=?, quantity=? WHERE id=?");
        $stmt->bind_param("sssssii", $title, $author, $category, $book_code, $status, $quantity, $book_id); // 'i' for integer quantity
        $stmt->execute();
        $stmt->close();

    } elseif ($action === 'delete_book') {
        $book_id = $_POST['book_id'];

        $stmt = $conn->prepare("DELETE FROM borrowed_books WHERE book_id = ?");
        $stmt->bind_param("i", $book_id);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
        $stmt->bind_param("i", $book_id);
        $stmt->execute();
        $stmt->close();

    } elseif ($action === 'edit_user_role') {
        $user_id = $_POST['user_id'];
        $new_role = $_POST['new_role'];

        $stmt = $conn->prepare("UPDATE users SET role=? WHERE id=?");
        $stmt->bind_param("si", $new_role, $user_id);
        $stmt->execute();
        $stmt->close();

    } elseif ($action === 'delete_user') {
        $user_id = $_POST['user_id'];

        $stmt = $conn->prepare("DELETE FROM borrowed_books WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: admin_dashboard.php");
    exit();
}

// Fetch books
$books = [];
$result = $conn->query("SELECT * FROM books ORDER BY created_at DESC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
    $result->free();
}

// Fetch users
$users = [];
$result = $conn->query("SELECT id, full_name, email, role FROM users ORDER BY created_at DESC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    $result->free();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Admin Dashboard - NUB Library</title>
<style>
  /* Basic styling */
  * { margin:0; padding:0; box-sizing:border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
  body { background:#f5f6fa; color:#2f3640; min-height:100vh; display:flex; flex-direction:column; }
  .header { background:#273c75; padding:15px 20px; color:#fff; }
  .header nav ul { display:flex; list-style:none; gap:20px; }
  .header nav ul li a { color:#fff; text-decoration:none; font-weight:bold; transition:0.3s; }
  .header nav ul li a:hover, .header nav ul li a.active { color:#00a8ff; }
  .dashboard-main { flex:1; padding:30px 20px; }
  h1 { margin-bottom:10px; font-size:2em; }
  p { margin-bottom:20px; color:#718093; }
  section { background:#fff; padding:20px; border-radius:10px; margin-bottom:25px; box-shadow:0 2px 8px rgba(0,0,0,0.1); }
  button { background:#00a8ff; color:#fff; border:none; padding:8px 12px; margin-right:5px; border-radius:6px; cursor:pointer; font-weight:bold; transition:0.3s; }
  button:hover { background:#0097e6; }
  table { width:100%; border-collapse:collapse; margin-top:15px; }
  th, td { border:1px solid #dcdde1; padding:10px; text-align:left; }
  th { background:#f1f2f6; }
  .footer { background:#273c75; color:#fff; text-align:center; padding:15px 0; }
  @media(max-width:768px) {
    .header nav ul { flex-direction:column; gap:10px; }
    button { margin-bottom:10px; width:100%; }
  }
  /* Modal styles */
  .modal {
    display:none; position:fixed; z-index:1; left:0; top:0; width:100%; height:100%; overflow:auto; background:rgba(0,0,0,0.4);
  }
  .modal-content {
    background:#fff; margin:10% auto; padding:20px; border-radius:10px; max-width:500px; position:relative;
    box-shadow:0 4px 8px rgba(0,0,0,0.2);
  }
  .close-button {
    position:absolute; top:10px; right:15px; font-size:28px; font-weight:bold; color:#aaa; cursor:pointer;
  }
  .close-button:hover { color:#000; }
  .modal-content form input, .modal-content form select {
    width:100%; padding:10px; margin-bottom:10px; border:1px solid #ddd; border-radius:5px;
  }
  .modal-content form button {
    width:100%; padding:10px; background:#007bff; color:#fff; border:none; border-radius:5px; cursor:pointer;
  }
  .modal-content form button:hover { background:#0056b3; }
</style>
</head>
<body>

<header class="header">
  <nav>
    <ul>
      <li><a href="admin_dashboard.php" class="active">Dashboard</a></li>
      <li><a href="#" onclick="openModal('addBookModal')">Add Book</a></li>
      <li><a href="#" onclick="alert('View Books is integrated into the dashboard.')">View Books</a></li>
      <li><a href="#" onclick="alert('Manage Users is integrated into the dashboard.')">Manage Users</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </nav>
</header>

<main class="dashboard-main">
  <h1>Welcome, Admin <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h1>
  <p>Manage books and users below.</p>

  <section>
    <h2>Books</h2>
    <table>
      <thead>
        <tr><th>ID</th><th>Title</th><th>Author</th><th>Category</th><th>Code</th><th>Quantity</th><th>Status</th><th>Created At</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php if ($books): foreach ($books as $book): ?>
          <tr>
            <td><?php echo htmlspecialchars($book['id']); ?></td>
            <td><?php echo htmlspecialchars($book['title']); ?></td>
            <td><?php echo htmlspecialchars($book['author']); ?></td>
            <td><?php echo htmlspecialchars($book['category']); ?></td>
            <td><?php echo htmlspecialchars($book['book_code']); ?></td>
            <td><?php echo htmlspecialchars($book['quantity']); ?></td> <!-- Display Quantity -->
            <td><?php echo htmlspecialchars($book['status']); ?></td>
            <td><?php echo htmlspecialchars($book['created_at']); ?></td>
            <td>
              <button onclick='openEditBookModal(<?php echo json_encode($book, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP); ?>)'>Edit</button>
              <button onclick="deleteBook(<?php echo $book['id']; ?>)">Delete</button>
            </td>
          </tr>
        <?php endforeach; else: ?>
          <tr><td colspan="9">No books found.</td></tr> <!-- Updated colspan -->
        <?php endif; ?>
      </tbody>
    </table>
  </section>

  <section>
    <h2>Users</h2>
    <table>
      <thead>
        <tr><th>ID</th><th>Full Name</th><th>Email</th><th>Role</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php if ($users): foreach ($users as $user): ?>
          <tr>
            <td><?php echo htmlspecialchars($user['id']); ?></td>
            <td><?php echo htmlspecialchars($user['full_name']); ?></td>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
            <td><?php echo htmlspecialchars($user['role']); ?></td>
            <td>
              <button onclick='openEditUserModal(<?php echo json_encode($user, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP); ?>)'>Edit Role</button>
              <button onclick="deleteUser(<?php echo $user['id']; ?>)">Delete</button>
            </td>
          </tr>
        <?php endforeach; else: ?>
          <tr><td colspan="5">No users found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </section>
</main>

<footer class="footer">
  <p>&copy; 2025 Northern University Bangladesh</p>
</footer>

<!-- Add Book Modal -->
<div id="addBookModal" class="modal">
  <div class="modal-content">
    <span class="close-button" onclick="closeModal('addBookModal')">&times;</span>
    <h2>Add Book</h2>
    <form method="POST" action="admin_dashboard.php">
      <input type="hidden" name="action" value="add_book" />
      <input type="text" name="title" placeholder="Title" required />
      <input type="text" name="author" placeholder="Author" required />
      <input type="text" name="category" placeholder="Category" />
      <input type="text" name="book_code" placeholder="Book Code" required />
      <input type="number" name="quantity" placeholder="Quantity" required min="1" /> <!-- New: Quantity input -->
      <button type="submit">Add Book</button>
    </form>
  </div>
</div>

<!-- Edit Book Modal -->
<div id="editBookModal" class="modal">
  <div class="modal-content">
    <span class="close-button" onclick="closeModal('editBookModal')">&times;</span>
    <h2>Edit Book</h2>
    <form method="POST" action="admin_dashboard.php">
      <input type="hidden" name="action" value="edit_book" />
      <input type="hidden" name="book_id" id="editBookId" />
      <input type="text" name="title" id="editBookTitle" placeholder="Title" required />
      <input type="text" name="author" id="editBookAuthor" placeholder="Author" required />
      <input type="text" name="category" id="editBookCategory" placeholder="Category" />
      <input type="text" name="book_code" id="editBookCode" placeholder="Book Code" required />
      <input type="number" name="quantity" id="editBookQuantity" placeholder="Quantity" required min="0" /> <!-- New: Quantity input -->
      <select name="status" id="editBookStatus">
        <option value="available">Available</option>
        <option value="borrowed">Borrowed</option>
      </select>
      <button type="submit">Update Book</button>
    </form>
  </div>
</div>

<!-- Edit User Modal -->
<div id="editUserModal" class="modal">
  <div class="modal-content">
    <span class="close-button" onclick="closeModal('editUserModal')">&times;</span>
    <h2>Edit User Role</h2>
    <form method="POST" action="admin_dashboard.php">
      <input type="hidden" name="action" value="edit_user_role" />
      <input type="hidden" name="user_id" id="editUserId" />
      <p>User: <span id="editUserName"></span> (<span id="editUserEmail"></span>)</p>
      <select name="new_role" id="editUserRole">
        <option value="user">User</option>
        <option value="admin">Admin</option>
      </select>
      <button type="submit">Update Role</button>
    </form>
  </div>
</div>

<script>
  function openModal(id) {
    document.getElementById(id).style.display = 'block';
  }
  function closeModal(id) {
    document.getElementById(id).style.display = 'none';
  }

  function openEditBookModal(book) {
    openModal('editBookModal');
    document.getElementById('editBookId').value = book.id;
    document.getElementById('editBookTitle').value = book.title;
    document.getElementById('editBookAuthor').value = book.author;
    document.getElementById('editBookCategory').value = book.category;
    document.getElementById('editBookCode').value = book.book_code;
    document.getElementById('editBookQuantity').value = book.quantity; // Set Quantity
    document.getElementById('editBookStatus').value = book.status;
  }

  function deleteBook(id) {
    if (confirm('Delete this book?')) {
      const formData = new FormData();
      formData.append('action', 'delete_book');
      formData.append('book_id', id);

      fetch('admin_dashboard.php', { method: 'POST', body: formData })
        .then(res => res.text())
        .then(() => location.reload())
        .catch(() => alert('Failed to delete book.'));
    }
  }

  function openEditUserModal(user) {
    openModal('editUserModal');
    document.getElementById('editUserId').value = user.id;
    document.getElementById('editUserName').textContent = user.full_name;
    document.getElementById('editUserEmail').textContent = user.email;
    document.getElementById('editUserRole').value = user.role;
  }

  function deleteUser(id) {
    if (confirm('Delete this user? This will also delete their borrowed book records.')) {
      const formData = new FormData();
      formData.append('action', 'delete_user');
      formData.append('user_id', id);

      fetch('admin_dashboard.php', { method: 'POST', body: formData })
        .then(res => res.text())
        .then(() => location.reload())
        .catch(() => alert('Failed to delete user.'));
    }
  }

  // Close modals on outside click
  window.onclick = function(event) {
    ['addBookModal', 'editBookModal', 'editUserModal'].forEach(id => {
      const modal = document.getElementById(id);
      if (event.target === modal) {
        modal.style.display = 'none';
      }
    });
  }
</script>

</body>
</html>