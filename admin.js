document.addEventListener("DOMContentLoaded", function() {
    // Add event listener for delete buttons
    const deleteButtons = document.querySelectorAll('.delete-btn');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const bookId = this.getAttribute('data-book-id');
            
            // Show confirmation dialog
            const confirmation = confirm("Are you sure you want to delete this book?");
            
            if (confirmation) {
                // If confirmed, submit the form to delete the book
                const form = document.querySelector(`#delete-form-${bookId}`);
                form.submit();  // Submit the delete form
            }
        });
    });

    // Show Edit Modal
    const editButtons = document.querySelectorAll('.edit-btn');
    
    editButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const bookId = this.getAttribute('data-book-id');
            
            // Fetch book details from the button attributes
            const bookTitle = this.getAttribute('data-title');
            const bookAuthor = this.getAttribute('data-author');
            const bookGenre = this.getAttribute('data-genre');
            const bookYear = this.getAttribute('data-year');
            
            // Show the modal and fill the form with current book data
            document.getElementById('edit-book-id').value = bookId;
            document.getElementById('edit-title').value = bookTitle;
            document.getElementById('edit-author').value = bookAuthor;
            document.getElementById('edit-genre').value = bookGenre;
            document.getElementById('edit-year').value = bookYear;
            
            // Show the modal
            document.getElementById('edit-modal').style.display = 'block';
        });
    });

    // Close Modal
    const closeModalButton = document.getElementById('close-modal');
    closeModalButton.addEventListener('click', function() {
        document.getElementById('edit-modal').style.display = 'none';
    });
});
