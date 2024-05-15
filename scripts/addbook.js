"use strict";
window.addEventListener("DOMContentLoaded", () => {

  /* Checking and Displayng the Characters */

  var descriptionInput = document.querySelector('#desc');
  var charCounter = document.querySelector('#char-counter');

  // Set the maximum length of the description input
  const maxLength = 2500;
  descriptionInput.maxLength = maxLength;

  // Update the character counter on input
  descriptionInput.addEventListener('input', () => {
    let length = maxLength - descriptionInput.value.length;
    charCounter.textContent = `${length}/${maxLength}`;
  });






  // Getting the form elements, buttons and Error Messages
  const form = document.getElementById('add_book');

  const cover = document.getElementById('cover');
  const url = document.getElementById('cover-image-url');
  const title = document.getElementById('title');
  const author = document.getElementById('author');
  const rating = document.getElementById('rating');
  const description = document.getElementById('desc');
  const date = document.getElementById('date');
  const isbn = document.getElementById('isbn');


  const submitBtn = document.getElementById('submit');
  const resetBtn = document.getElementById('reset');


  const errorMessages = document.getElementsByClassName('error');

  // function to show the error message for a specific input element
  function showError(element) {
    element.parentNode.querySelector('.error').style.display = 'block';
  }
  // Reset all error messages to their initial value
  function resetErrors() {
    for (let i = 0; i < errorMessages.length; i++) {
      errorMessages[i].style.display = 'none';
    }
  }



  // Listen for the form submit event
  form.addEventListener('submit', function (e) {
    
    let hasError = false;
    resetErrors();

    
    // Validating the title and author

    if (title.value.trim() === '' || !/^[a-zA-Z\s]+$/.test(title.value.trim())) {
      showError(title);
      hasError = true;
    }
    if (author.value.trim() === '' || !/^[a-zA-Z\s]+$/.test(author.value.trim())) {
      showError(author);
      hasError = true;
    }
    if (url.value.trim() === '' || !/^(ftp|http|https):\/\/[^ "]+$/.test(url.value.trim())) {
      showError(url);
      hasError = true;
  }
  if (date.value.trim() === '' || !/^\d{4}[./-]\d{2}[./-]\d{2}$/.test(date.value.trim())) {
    showError(date);
    hasError = true;
  }
  if (isbn.value.trim() === '' || !/^[\d*\-]{10}|[\d*\-]{13}$/.test(isbn.value.trim())) {
    showError(isbn);
    hasError = true;
}
   

 

    // If any errors occurred, prevent the form from submitting
    if (hasError) {
      e.preventDefault();
    }
  });

  // Listen for the reset button click event
  resetBtn.addEventListener('click', function () {
    resetErrors();
  });

});

