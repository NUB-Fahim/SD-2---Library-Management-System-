<?php
// Static array of books (No database connection)
$books = [
    ['id' => 1, 'title' => 'The Great Gatsby', 'author' => 'F. Scott Fitzgerald', 'genre' => 'Fiction', 'year' => 1925],
    ['id' => 2, 'title' => '1984', 'author' => 'George Orwell', 'genre' => 'Dystopian', 'year' => 1949],
    ['id' => 3, 'title' => 'To Kill a Mockingbird', 'author' => 'Harper Lee', 'genre' => 'Fiction', 'year' => 1960],
    ['id' => 4, 'title' => 'Moby-Dick', 'author' => 'Herman Melville', 'genre' => 'Adventure', 'year' => 1851],
    ['id' => 5, 'title' => 'Pride and Prejudice', 'author' => 'Jane Austen', 'genre' => 'Romance', 'year' => 1813],
];

// Search functionality
$search_query = '';
if (isset($_POST['search'])) {
    $search_query = $_POST['search'];
    $books = array_filter($books, function($book) use ($search_query) {
        return stripos($book['title'], $search_query) !== false || stripos($book['author'], $search_query) !== false;
    });
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Linking External CSS for Styling -->
    <link rel="stylesheet" href="admin.css">
    <script src="admin.js" defer></script>
</head>
<body>
    <div class="container">
        <h1>Library Management Admin Dashboard</h1>

        <!-- Dashboard Stats -->
        <section class="dashboard-stats">
            <div class="stat">
                <h3>Total Books</h3>
                <p><?php echo count($books); ?></p>
            </div>
            <div class="stat">
                <h3>Total Users</h3>
                <p>15</p> <!-- Static value for now -->
            </div>
        </section>

        <!-- Search Books -->
        <section class="search-section">
            <h2>Search Books</h2>
            <form method="POST">
                <input type="text" name="search" value="<?php echo htmlspecialchars($search_query); ?>" placeholder="Search by Title or Author">
                <button type="submit">Search</button>
            </form>
        </section>

        <!-- Book List -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Genre</th>
                    <th>Year</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td><?php echo $book['id']; ?></td>
                        <td><?php echo htmlspecialchars($book['title']); ?></td>
                        <td><?php echo htmlspecialchars($book['author']); ?></td>
                        <td><?php echo htmlspecialchars($book['genre']); ?></td>
                        <td><?php echo $book['year']; ?></td>
                        <td>
                            <!-- Edit button -->
                            <button class="edit-btn" 
                                    data-book-id="<?php echo $book['id']; ?>"
                                    data-title="<?php echo htmlspecialchars($book['title']); ?>"
                                    data-author="<?php echo htmlspecialchars($book['author']); ?>"
                                    data-genre="<?php echo htmlspecialchars($book['genre']); ?>"
                                    data-year="<?php echo $book['year']; ?>">
                                Edit
                            </button>
                            <!-- Delete button -->
                            <button class="delete-btn" data-book-id="<?php echo $book['id']; ?>">Delete</button>
                            
                            <!-- Hidden form for deleting a book -->
                            <form method="POST" id="delete-form-<?php echo $book['id']; ?>" style="display:none;">
                                <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                                <button type="submit" name="delete_book" style="display:none;">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Edit Modal -->
    <div id="edit-modal" class="modal">
        <div class="modal-content">
            <span id="close-modal" class="close">&times;</span>
            <h2>Edit Book</h2>
            <form method="POST" action="admin.php">
                <input type="hidden" name="book_id" id="edit-book-id">
                <input type="text" name="title" id="edit-title" required>
                <input type="text" name="author" id="edit-author" required>
                <input type="text" name="genre" id="edit-genre">
                <input type="number" name="year" id="edit-year">
                <button type="submit" name="update_book">Update Book</button>
            </form>
        </div>
    </div>
</body>
</html>
