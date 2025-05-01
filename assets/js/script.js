// Toggle sidebar on mobile
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('show');
}

// Close sidebar when clicking outside
document.addEventListener('click', function(e) {
    const sidebar = document.getElementById('sidebar');
    const toggle = document.querySelector('.mobile-nav-toggle');
    if (!sidebar.contains(e.target) && !toggle.contains(e.target) && sidebar.classList.contains('show')) {
        sidebar.classList.remove('show');
    }
});

// Initialize DataTables with responsive feature
function initDataTable(tableId) {
    $(tableId).DataTable({
        responsive: true,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            infoFiltered: "(disaring dari _MAX_ total data)",
            zeroRecords: "Tidak ada data yang cocok",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            }
        }
    });
}

// Format currency
function formatRupiah(angka) {
    var number_string = angka.toString().replace(/[^,\d]/g, ''),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return 'Rp ' + rupiah;
}

// Auto format currency input
function initCurrencyInput(input) {
    input.addEventListener('keyup', function(e) {
        let value = this.value.replace(/[^0-9]/g, '');
        this.value = formatRupiah(value);
    });
}

// Print function
function printContent(elementId) {
    const content = document.getElementById(elementId);
    const originalContents = document.body.innerHTML;
    
    document.body.innerHTML = content.innerHTML;
    window.print();
    document.body.innerHTML = originalContents;
    
    // Reinitialize scripts after printing
    location.reload();
} 