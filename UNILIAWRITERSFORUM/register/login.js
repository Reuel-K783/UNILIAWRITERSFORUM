document.getElementById('loginForm').addEventListener('submit', function (event) {  
 
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;  // Basic email format  
    const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/; // A 


    const email = document.getElementById('email').value;  
    const password = document.getElementById('password').value;  
     


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
    if (password !== confirmPassword) {  
        alert('Passwords do not match.');  
        event.preventDefault();  
    }  
});