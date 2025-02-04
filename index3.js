// Handle file upload
document.getElementById('uploadBtn').addEventListener('click', function() {
    const fileInput = document.getElementById('fileInput');
    const uploadStatus = document.getElementById('uploadStatus');
    const convertPrompt = document.getElementById('convertPrompt');
    const fileList = document.getElementById('fileList');

    // Clear previous messages
    uploadStatus.textContent = '';
    convertPrompt.style.display = 'none';

    const file = fileInput.files[0];

    if (!file) {
        uploadStatus.textContent = 'Please choose a file to upload.';
        uploadStatus.style.display = 'block';
        return;
    }

    // Check if the uploaded file is machine-readable
    if (file.type === 'text/plain') { // Assuming .txt is machine-readable
        uploadStatus.textContent = 'File uploaded successfully.';
        uploadStatus.style.display = 'block';

        // Create a list item for the uploaded file
        const listItem = document.createElement('li');
        listItem.classList.add('list-group-item');
        listItem.innerHTML = `${file.name} <span class="text-success">&#10003;</span>`; // Green tick mark

        // Check if there's an initial message saying "No files chosen yet."
        const noFilesMessage = document.querySelector('#fileList .list-group-item');
        if (noFilesMessage && noFilesMessage.textContent === 'No files chosen yet.') {
            noFilesMessage.remove(); // Remove the "No files chosen yet." item
        }

        // Append the list item to the file list
        fileList.appendChild(listItem);
    } else {
        uploadStatus.textContent = 'The uploaded file is not machine-readable.';
        uploadStatus.style.display = 'block';
        convertPrompt.style.display = 'block'; // Show conversion prompt
    }

    // Clear the file input
    fileInput.value = '';
});

// Convert button functionality (dummy functionality)
document.getElementById('convertBtn').addEventListener('click', function() {
    const uploadStatus = document.getElementById('uploadStatus');
    uploadStatus.textContent = 'Converting to machine-readable format...'; // Simulate conversion
    uploadStatus.style.display = 'block';

    // Hide conversion prompt after conversion (simulate)
    const convertPrompt = document.getElementById('convertPrompt');
    convertPrompt.style.display = 'none';
});

// Cancel button functionality for the conversion prompt
document.getElementById('cancelConvertBtn').addEventListener('click', function() {
    const convertPrompt = document.getElementById('convertPrompt');
    convertPrompt.style.display = 'none'; // Hide conversion prompt

    // Clear the upload status if needed
    const uploadStatus = document.getElementById('uploadStatus');
    uploadStatus.textContent = ''; // Clear the upload status message
    uploadStatus.style.display = 'none'; // Hide the status message
});
