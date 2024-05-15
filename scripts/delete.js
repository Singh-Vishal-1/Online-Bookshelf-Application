function confirmDelete() {
    // Show confirmation dialog
    const confirmDel = confirm('Are you sure you want to delete the book?');

    // If user chooses to delete, perform delete operation
    if (confirmDel == true) {
        // Perform delete book operation
        deleteBook();
    }
    else {
        event.preventDefault();
    }
};

// Function to perform delete book operation
function deleteBook() {
    // Code to delete the book
    console.log('Book deleted.');
}

