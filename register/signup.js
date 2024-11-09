document.getElementById('signupForm').addEventListener('submit', function (event) {  
    const namePattern = /^[a-zA-Z]+$/;  
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;  // Basic email format  
    const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/; // At least 8 characters, one letter, one number  
    const bioPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/; // Change this if you also want a specific pattern for bio.  

    const name = document.getElementById('name').value;  
    const email = document.getElementById('email').value;  
    const password = document.getElementById('password').value;  
    const bio = document.getElementById('bio').value;  
    const confirmPassword = document.getElementById('confirm-password').value;  

    // Validate username  
    if (!namePattern.test(name)) {  
        alert('Name contain only letters');  
        event.preventDefault();  
    }  

    // Validate email  
    if (!emailPattern.test(email)) {  
        alert('Please enter a valid email address.');  
        event.preventDefault();  
    }  
    
    // Validate password  
    if (!passwordPattern.test(password)) {  
        alert('Password must be at least 8 characters long, with at least one letter and one number.');  
        event.preventDefault();  
    }  
    
    // Validate password match  
    if (password !== confirmPassword) {  
        alert('Passwords do not match.');  
        event.preventDefault();  
    }  
});