        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTables
            $('.datatable').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
                }
            });

            // Sidebar toggle functionality
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarToggle = document.getElementById('sidebarToggle');
            let isSidebarCollapsed = false;

            // Check screen size and set initial state
            function checkScreenSize() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('collapsed');
                    mainContent.classList.remove('expanded');
                    sidebar.classList.remove('active');
                    mainContent.classList.remove('active');
                    sidebarToggle.classList.remove('active');
                }
            }

            // Initial check
            checkScreenSize();

            // Toggle sidebar
            sidebarToggle.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    // Mobile view: toggle full sidebar
                    sidebar.classList.toggle('active');
                    mainContent.classList.toggle('active');
                    sidebarToggle.classList.toggle('active');
                } else {
                    // Desktop view: toggle collapsed state
                    isSidebarCollapsed = !isSidebarCollapsed;
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('expanded');
                    sidebarToggle.classList.toggle('active');
                }
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                checkScreenSize();
            });

            // Confirm delete
            $('.delete-confirm').click(function(e) {
                if(!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html> 