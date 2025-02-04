

// JavaScript to toggle between the Sign Up and Sign In forms

// Select the sign-in and sign-up buttons
const signInButton = document.getElementById('signInButton');
const signUpButton = document.getElementById('signUpButton');

// Select the form containers
const signInContainer = document.getElementById('signIn');
const signUpContainer = document.getElementById('signup');

// Show the sign-in form and hide the sign-up form by default
signInContainer.style.display = 'block';
signUpContainer.style.display = 'none';

// Add event listener to the "Sign In" button on the sign-up form
signInButton.addEventListener('click', () => {
    signInContainer.style.display = 'block';
    signUpContainer.style.display = 'none';
});

// Add event listener to the "Sign Up" button on the sign-in form
signUpButton.addEventListener('click', () => {
    signInContainer.style.display = 'none';
    signUpContainer.style.display = 'block';
});
