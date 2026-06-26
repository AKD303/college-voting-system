// Login Form Handler
document.getElementById('loginForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const username = document.getElementById('login_username').value;
    const password = document.getElementById('login_password').value;
    const messageDiv = document.getElementById('loginMessage');

    try {
        const formData = new FormData();
        formData.append('username', username);
        formData.append('password', password);

        const response = await fetch('../backend/php/login.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();
        
        messageDiv.style.display = 'block';
        if (data.status === 'success') {
            messageDiv.className = 'alert alert-success';
            messageDiv.textContent = data.message;
            // Store user info
            localStorage.setItem('user_id', data.user_id);
            localStorage.setItem('username', data.username);
            localStorage.setItem('role', data.role);
            setTimeout(() => {
                if (data.role === 'admin') {
                    window.location.href = 'admin-dashboard.html';
                } else {
                    window.location.href = 'student-dashboard.html';
                }
            }, 1500);
        } else {
            messageDiv.className = 'alert alert-danger';
            messageDiv.textContent = data.message;
        }
    } catch (error) {
        messageDiv.style.display = 'block';
        messageDiv.className = 'alert alert-danger';
        messageDiv.textContent = 'Error: ' + error.message;
    }
});

// Register Form Handler
document.getElementById('registerForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const messageDiv = document.getElementById('registerMessage');

    try {
        const response = await fetch('../backend/php/register.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();
        
        messageDiv.style.display = 'block';
        if (data.status === 'success') {
            messageDiv.className = 'alert alert-success';
            messageDiv.textContent = data.message;
            document.getElementById('registerForm').reset();
            setTimeout(() => {
                document.getElementById('login-tab').click();
            }, 2000);
        } else {
            messageDiv.className = 'alert alert-danger';
            messageDiv.textContent = data.message;
        }
    } catch (error) {
        messageDiv.style.display = 'block';
        messageDiv.className = 'alert alert-danger';
        messageDiv.textContent = 'Error: ' + error.message;
    }
});

// Logout
function logout() {
    if (confirm('Are you sure you want to logout?')) {
        localStorage.removeItem('user_id');
        localStorage.removeItem('username');
        localStorage.removeItem('role');
        fetch('../backend/php/logout.php')
            .then(() => {
                window.location.href = 'index.html';
            });
    }
}

// Check Session
function checkSession() {
    const userId = localStorage.getItem('user_id');
    if (!userId) {
        window.location.href = 'index.html';
    }
}
