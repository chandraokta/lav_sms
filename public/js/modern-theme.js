// Modern Theme JavaScript for Lav SMS - Dynamic Effects

document.addEventListener('DOMContentLoaded', function() {
    // Add hover effects to cards
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Add ripple effect to buttons
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Create ripple element
            const ripple = document.createElement('span');
            ripple.classList.add('ripple');
            
            // Add ripple styles
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            
            // Add to button
            this.appendChild(ripple);
            
            // Remove after animation
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
    
    // Enhanced checkbox selection
    const selectAllHeader = document.getElementById('select-all-header');
    const selectAll = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.class-checkbox');
    const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
    
    if (selectAllHeader) {
        selectAllHeader.addEventListener('change', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
                updateCheckboxStyle(checkbox);
            });
            updateBulkDeleteButton();
        });
    }
    
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
                updateCheckboxStyle(checkbox);
            });
            updateBulkDeleteButton();
        });
    }
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateCheckboxStyle(this);
            updateBulkDeleteButton();
        });
    });
    
    // Function to update checkbox style
    function updateCheckboxStyle(checkbox) {
        if (checkbox.checked) {
            checkbox.parentElement.style.backgroundColor = 'rgba(67, 97, 238, 0.1)';
            checkbox.parentElement.style.borderRadius = '8px';
        } else {
            checkbox.parentElement.style.backgroundColor = '';
            checkbox.parentElement.style.borderRadius = '';
        }
    }
    
    // Function to update bulk delete button
    function updateBulkDeleteButton() {
        const checkedCheckboxes = document.querySelectorAll('.class-checkbox:checked');
        if (bulkDeleteBtn) {
            bulkDeleteBtn.disabled = checkedCheckboxes.length === 0;
            
            if (checkedCheckboxes.length > 0) {
                bulkDeleteBtn.style.transform = 'scale(1.05)';
                setTimeout(() => {
                    bulkDeleteBtn.style.transform = '';
                }, 300);
            }
        }
    }
    
    // Add animation to alerts
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach((alert, index) => {
        alert.style.animationDelay = (index * 0.1) + 's';
    });
    
    // Add floating animation to cards
    let lastScrollY = window.scrollY;
    
    window.addEventListener('scroll', function() {
        const scrollY = window.scrollY;
        const diff = scrollY - lastScrollY;
        
        cards.forEach((card, index) => {
            const speed = 0.1 + (index * 0.01);
            const yPos = -(diff * speed);
            card.style.transform = `translateY(${yPos}px)`;
        });
        
        lastScrollY = scrollY;
    });
    
    // Add confetti effect for success messages
    const successAlerts = document.querySelectorAll('.alert-success');
    if (successAlerts.length > 0) {
        createConfetti();
    }
    
    // Initialize DataTables with proper settings
    if (typeof $.fn.DataTable !== 'undefined') {
        $('.datatable-button-html5-columns').each(function() {
            if (!$.fn.dataTable.isDataTable(this)) {
                $(this).DataTable({
                    scrollX: false,
                    autoWidth: false,
                    responsive: true,
                    paging: true,
                    pageLength: 10,
                    lengthChange: true,
                    searching: true,
                    ordering: true,
                    info: true,
                    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                         '<"row"<"col-sm-12"tr>>' +
                         '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Search...",
                        lengthMenu: "Show _MENU_ entries",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        infoEmpty: "Showing 0 to 0 of 0 entries",
                        infoFiltered: "(filtered from _MAX_ total entries)",
                        paginate: {
                            first: "First",
                            last: "Last",
                            next: "Next",
                            previous: "Previous"
                        }
                    }
                });
            }
        });
    }
});

// Function to create confetti effect
function createConfetti() {
    const confettiContainer = document.createElement('div');
    confettiContainer.style.position = 'fixed';
    confettiContainer.style.top = '0';
    confettiContainer.style.left = '0';
    confettiContainer.style.width = '100%';
    confettiContainer.style.height = '100%';
    confettiContainer.style.pointerEvents = 'none';
    confettiContainer.style.zIndex = '9999';
    document.body.appendChild(confettiContainer);
    
    const colors = ['#4361ee', '#4cc9f0', '#f72585', '#4ade80', '#facc15'];
    
    for (let i = 0; i < 150; i++) {
        const confetti = document.createElement('div');
        confetti.style.position = 'absolute';
        confetti.style.width = Math.random() * 10 + 5 + 'px';
        confetti.style.height = Math.random() * 10 + 5 + 'px';
        confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
        confetti.style.borderRadius = Math.random() > 0.5 ? '50%' : '0';
        confetti.style.left = Math.random() * 100 + '%';
        confetti.style.top = '-10px';
        confetti.style.opacity = Math.random() + 0.5;
        confetti.style.transform = 'rotate(' + Math.random() * 360 + 'deg)';
        
        confettiContainer.appendChild(confetti);
        
        // Animate confetti
        const animation = confetti.animate([
            { transform: 'translateY(0) rotate(0deg)', opacity: 1 },
            { transform: `translateY(${window.innerHeight + 20}px) rotate(${Math.random() * 360}deg)`, opacity: 0 }
        ], {
            duration: Math.random() * 3000 + 2000,
            easing: 'cubic-bezier(0.1, 0.8, 0.2, 1)'
        });
        
        animation.onfinish = () => {
            confetti.remove();
        };
    }
    
    // Remove confetti container after animation
    setTimeout(() => {
        confettiContainer.remove();
    }, 5000);
}

// Function to create confetti effect
function createConfetti() {
    const confettiContainer = document.createElement('div');
    confettiContainer.style.position = 'fixed';
    confettiContainer.style.top = '0';
    confettiContainer.style.left = '0';
    confettiContainer.style.width = '100%';
    confettiContainer.style.height = '100%';
    confettiContainer.style.pointerEvents = 'none';
    confettiContainer.style.zIndex = '9999';
    document.body.appendChild(confettiContainer);
    
    const colors = ['#4361ee', '#4cc9f0', '#f72585', '#4ade80', '#facc15'];
    
    for (let i = 0; i < 150; i++) {
        const confetti = document.createElement('div');
        confetti.style.position = 'absolute';
        confetti.style.width = Math.random() * 10 + 5 + 'px';
        confetti.style.height = Math.random() * 10 + 5 + 'px';
        confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
        confetti.style.borderRadius = Math.random() > 0.5 ? '50%' : '0';
        confetti.style.left = Math.random() * 100 + '%';
        confetti.style.top = '-10px';
        confetti.style.opacity = Math.random() + 0.5;
        confetti.style.transform = 'rotate(' + Math.random() * 360 + 'deg)';
        
        confettiContainer.appendChild(confetti);
        
        // Animate confetti
        const animation = confetti.animate([
            { transform: 'translateY(0) rotate(0deg)', opacity: 1 },
            { transform: `translateY(${window.innerHeight + 20}px) rotate(${Math.random() * 360}deg)`, opacity: 0 }
        ], {
            duration: Math.random() * 3000 + 2000,
            easing: 'cubic-bezier(0.1, 0.8, 0.2, 1)'
        });
        
        animation.onfinish = () => {
            confetti.remove();
        };
    }
    
    // Remove confetti container after animation
    setTimeout(() => {
        confettiContainer.remove();
    }, 5000);
}