// Check session on page load
window.addEventListener('load', () => {
    checkSession();
    document.getElementById('userName').textContent = localStorage.getItem('username') || 'Admin';
    loadDashboardStats();
});

// Show/Hide sections
function showSection(sectionId) {
    // Hide all sections
    document.querySelectorAll('.content-section').forEach(section => {
        section.classList.remove('active');
    });
    
    // Remove active from all sidebar links
    document.querySelectorAll('.sidebar-link').forEach(link => {
        link.classList.remove('active');
    });
    
    // Show selected section
    document.getElementById(sectionId).classList.add('active');
    
    // Add active to clicked link
    event.target.classList.add('active');
}

// Load Dashboard Statistics
function loadDashboardStats() {
    // Placeholder data for 50% completion
    document.getElementById('totalUsers').textContent = '45';
    document.getElementById('totalCandidates').textContent = '12';
    document.getElementById('totalVotes').textContent = '150';
    document.getElementById('votingStatus').textContent = 'Active';
}

// Add sidebar click handlers
document.addEventListener('DOMContentLoaded', () => {
    const links = document.querySelectorAll('.sidebar-link');
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href.startsWith('#')) {
                e.preventDefault();
                const sectionId = href.substring(1);
                showSection(sectionId);
                
                // Update active link
                links.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            }
        });
    });
});
