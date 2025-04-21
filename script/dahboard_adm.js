// script.js

// Function to toggle submenu visibility
document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('click', event => {
        const submenu = item.querySelector('.submenu');
        if (submenu) {
            submenu.classList.toggle('active'); // toggle visibility
        }
    });
});

// Handle sidebar hover for width adjustment
const sidebar = document.querySelector('.sidebar');

sidebar.addEventListener('mouseover', () => {
    sidebar.style.width = '300px';
    sidebar.querySelector('.right').style.width = '225px';
});

sidebar.addEventListener('mouseout', () => {
    sidebar.style.width = '80px';
    sidebar.querySelector('.right').style.width = 'auto';
});

// Update badge counts (this is just for demonstration; you can fetch these dynamically)
function updateBadgeCounts() {
    const messagesBadge = document.querySelector('.messages-badge');
    const draftsBadge = document.querySelector('.drafts-badge');
    
    messagesBadge.textContent = 12; // Update based on actual data
    draftsBadge.textContent = 10; // Update based on actual data
}

// Call the update function on page load
document.addEventListener('DOMContentLoaded', updateBadgeCounts);