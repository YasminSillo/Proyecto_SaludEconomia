// ===== FUNCIONALIDAD ADMIN =====

document.addEventListener('DOMContentLoaded', function() {
    
    // ===== SIDEBAR TOGGLE =====
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        });
        
        // Restaurar estado del sidebar
        const sidebarCollapsed = localStorage.getItem('sidebarCollapsed');
        if (sidebarCollapsed === 'true') {
            sidebar.classList.add('collapsed');
        }
        
        // Responsive sidebar
        function handleResize() {
            if (window.innerWidth <= 1024) {
                sidebar.classList.remove('collapsed');
                sidebar.classList.remove('open');
            }
        }
        
        window.addEventListener('resize', handleResize);
        handleResize();
        
        // Toggle en móvil
        if (window.innerWidth <= 1024) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('open');
            });
            
            // Cerrar sidebar al hacer click fuera
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 1024 && 
                    !sidebar.contains(e.target) && 
                    !sidebarToggle.contains(e.target)) {
                    sidebar.classList.remove('open');
                }
            });
        }
    }
    
    // ===== ALERTS AUTO CLOSE =====
    const alertCloses = document.querySelectorAll('.alert-close');
    alertCloses.forEach(function(closeBtn) {
        closeBtn.addEventListener('click', function() {
            const alert = this.closest('.alert');
            if (alert) {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.remove(), 300);
            }
        });
    });
    
    // Auto close alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(() => {
            if (alert.parentNode) {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.remove(), 300);
            }
        }, 5000);
    });
    
    // ===== TABLA SEARCH =====
    const searchInput = document.getElementById('searchInput');
    const table = document.querySelector('.crud-table tbody');
    
    if (searchInput && table) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = table.querySelectorAll('tr');
            
            rows.forEach(function(row) {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    // ===== TABLA SORT =====
    const sortableHeaders = document.querySelectorAll('.sortable');
    let sortDirection = {};
    
    sortableHeaders.forEach(function(header) {
        const column = header.dataset.column;
        sortDirection[column] = 'asc';
        
        header.addEventListener('click', function() {
            const column = this.dataset.column;
            const tbody = document.querySelector('.crud-table tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            
            // Remove sort classes from all headers
            sortableHeaders.forEach(h => {
                h.classList.remove('sorted-asc', 'sorted-desc');
            });
            
            // Sort rows
            rows.sort(function(a, b) {
                const aValue = a.children[getColumnIndex(column)].textContent.trim();
                const bValue = b.children[getColumnIndex(column)].textContent.trim();
                
                if (sortDirection[column] === 'asc') {
                    return aValue.localeCompare(bValue, 'es', {numeric: true});
                } else {
                    return bValue.localeCompare(aValue, 'es', {numeric: true});
                }
            });
            
            // Add sort class and toggle direction
            this.classList.add(sortDirection[column] === 'asc' ? 'sorted-asc' : 'sorted-desc');
            sortDirection[column] = sortDirection[column] === 'asc' ? 'desc' : 'asc';
            
            // Reorder table
            rows.forEach(row => tbody.appendChild(row));
        });
    });
    
    function getColumnIndex(column) {
        const headers = document.querySelectorAll('.crud-table th');
        for (let i = 0; i < headers.length; i++) {
            if (headers[i].dataset.column === column) {
                return i;
            }
        }
        return 0;
    }
    
    // ===== FILTROS =====
    const filters = document.querySelectorAll('.filter-select');
    filters.forEach(function(filter) {
        filter.addEventListener('change', function() {
            const filterValue = this.value.toLowerCase();
            const filterColumn = this.id.replace('Filter', '');
            const rows = document.querySelectorAll('.crud-table tbody tr');
            
            rows.forEach(function(row) {
                if (!filterValue) {
                    row.style.display = '';
                    return;
                }
                
                let shouldShow = false;
                const cells = row.querySelectorAll('td');
                
                cells.forEach(function(cell) {
                    if (cell.textContent.toLowerCase().includes(filterValue)) {
                        shouldShow = true;
                    }
                });
                
                row.style.display = shouldShow ? '' : 'none';
            });
        });
    });
    
    // ===== MODALES =====
    const modalTriggers = document.querySelectorAll('[data-modal]');
    const modalOverlays = document.querySelectorAll('.modal-overlay');
    const modalCloses = document.querySelectorAll('.modal-close');
    
    modalTriggers.forEach(function(trigger) {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            const modalId = this.dataset.modal;
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        });
    });
    
    modalCloses.forEach(function(closeBtn) {
        closeBtn.addEventListener('click', function() {
            const modal = this.closest('.modal-overlay');
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });
    
    modalOverlays.forEach(function(overlay) {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });
    
    // Cerrar modal con ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const activeModal = document.querySelector('.modal-overlay.active');
            if (activeModal) {
                activeModal.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
    });
    
    // ===== FORM VALIDATION =====
    const forms = document.querySelectorAll('.crud-form');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let hasErrors = false;
            
            requiredFields.forEach(function(field) {
                const value = field.value.trim();
                if (!value) {
                    field.classList.add('error');
                    hasErrors = true;
                } else {
                    field.classList.remove('error');
                }
            });
            
            if (hasErrors) {
                e.preventDefault();
                showAlert('Por favor complete todos los campos requeridos', 'error');
            }
        });
        
        // Remove error class on input
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(function(input) {
            input.addEventListener('input', function() {
                this.classList.remove('error');
            });
        });
    });
    
    // ===== HELPER FUNCTIONS =====
    function showAlert(message, type = 'info') {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} alert-dismissible`;
        alert.innerHTML = `
            ${message}
            <button class="alert-close">&times;</button>
        `;
        
        const mainContent = document.querySelector('.main-content');
        if (mainContent) {
            mainContent.insertBefore(alert, mainContent.firstChild);
            
            // Auto close
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => alert.remove(), 300);
                }
            }, 5000);
            
            // Manual close
            const closeBtn = alert.querySelector('.alert-close');
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => alert.remove(), 300);
                });
            }
        }
    }
    
    // ===== CONFIRM DIALOGS =====
    window.confirmDelete = function(message = '¿Está seguro de eliminar este elemento?') {
        return confirm(message);
    };
    
    // ===== LOADING STATES =====
    const submitButtons = document.querySelectorAll('button[type="submit"]');
    submitButtons.forEach(function(button) {
        const form = button.closest('form');
        if (form) {
            form.addEventListener('submit', function() {
                button.disabled = true;
                const originalText = button.textContent;
                button.innerHTML = '<span class="spinner"></span> Procesando...';
                
                setTimeout(() => {
                    button.disabled = false;
                    button.textContent = originalText;
                }, 3000);
            });
        }
    });
    
    // ===== LOGOUT CONFIRMATION =====
    const logoutLinks = document.querySelectorAll('a[href="logout.php"], a[href*="logout"]');
    logoutLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('¿Está seguro de que desea cerrar sesión?')) {
                window.location.href = this.href;
            }
        });
    });
    
    // ===== SESSION TIMEOUT WARNING =====
    let sessionTimeoutWarning;
    let sessionTimeout;
    
    function resetSessionTimer() {
        clearTimeout(sessionTimeoutWarning);
        clearTimeout(sessionTimeout);
        
        // Advertencia 5 minutos antes del timeout (1h 55min)
        sessionTimeoutWarning = setTimeout(() => {
            if (confirm('Su sesión expirará en 5 minutos. ¿Desea mantenerla activa?')) {
                // Hacer una petición AJAX para mantener la sesión
                fetch('auth_check.php', {
                    method: 'POST',
                    headers: {'X-Requested-With': 'XMLHttpRequest'}
                });
                resetSessionTimer();
            }
        }, 115 * 60 * 1000); // 1h 55min
        
        // Logout automático (2h)
        sessionTimeout = setTimeout(() => {
            alert('Su sesión ha expirado. Será redirigido a la página de login.');
            window.location.href = 'logout.php';
        }, 120 * 60 * 1000); // 2h
    }
    
    // Inicializar timer de sesión
    resetSessionTimer();
    
    // Resetear timer en cualquier actividad del usuario
    ['click', 'keypress', 'scroll', 'mousemove'].forEach(event => {
        document.addEventListener(event, resetSessionTimer);
    });
});