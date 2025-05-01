<?php
session_start();
if($_SESSION['status'] != "administrator_logedin"){
    header("location:../index.php?alert=belum_login");
}
include '../koneksi.php';

require_once('../library/dompdf/autoload.inc.php');
use Dompdf\Dompdf;

// Export ke PDF
if(isset($_GET['pdf'])){
    $where = "";
    if(isset($_GET['tanggal_mulai']) && isset($_GET['tanggal_akhir'])){
        $tanggal_mulai = $_GET['tanggal_mulai'];
        $tanggal_akhir = $_GET['tanggal_akhir'];
        $where .= " AND t.tanggal BETWEEN '$tanggal_mulai' AND '$tanggal_akhir'";
    }
    if(isset($_GET['jenis']) && $_GET['jenis'] != ""){
        $jenis = $_GET['jenis'];
        $where .= " AND t.jenis = '$jenis'";
    }
    $query = mysqli_query($koneksi, "SELECT t.*, k.nama as kategori_nama, r.nama as rekening_nama FROM transaksi t LEFT JOIN kategori k ON t.kategori_id = k.id LEFT JOIN rekening r ON t.rekening_id = r.id WHERE 1=1 $where ORDER BY t.tanggal DESC");
    $html = '<html><head><title>Laporan Keuangan</title><style>body { font-family: Arial; } table { border-collapse: collapse; width: 100%; } th, td { border: 1px solid #000; padding: 5px; } th { background-color: #f0f0f0; }</style></head><body><h2>Laporan Keuangan</h2><table><thead><tr><th>No</th><th>Tanggal</th><th>Kategori</th><th>Rekening</th><th>Jumlah</th><th>Keterangan</th><th>Jenis</th></tr></thead><tbody>';
    $no = 1;
    while($data = mysqli_fetch_assoc($query)){
        $html .= '<tr><td>'.$no++.'</td><td>'.date('d/m/Y', strtotime($data['tanggal'])).'</td><td>'.$data['kategori_nama'].'</td><td>'.$data['rekening_nama'].'</td><td>Rp '.number_format($data['jumlah']).'</td><td>'.$data['keterangan'].'</td><td>'.ucfirst($data['jenis']).'</td></tr>';
    }
    $html .= '</tbody></table></body></html>';
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream('Laporan_Keuangan.pdf', array("Attachment" => false));
}
// Export ke Excel
else if(isset($_GET['export'])){
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Laporan_Keuangan.xls");
    
    $where = "";
    if(isset($_GET['tanggal_mulai']) && isset($_GET['tanggal_akhir'])){
        $tanggal_mulai = $_GET['tanggal_mulai'];
        $tanggal_akhir = $_GET['tanggal_akhir'];
        $where .= " AND t.tanggal BETWEEN '$tanggal_mulai' AND '$tanggal_akhir'";
    }
    if(isset($_GET['jenis']) && $_GET['jenis'] != ""){
        $jenis = $_GET['jenis'];
        $where .= " AND t.jenis = '$jenis'";
    }
    
    $query = mysqli_query($koneksi, "SELECT t.*, k.nama as kategori_nama, r.nama as rekening_nama 
                                    FROM transaksi t 
                                    LEFT JOIN kategori k ON t.kategori_id = k.id 
                                    LEFT JOIN rekening r ON t.rekening_id = r.id 
                                    WHERE 1=1 $where 
                                    ORDER BY t.tanggal DESC");
    ?>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Rekening</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
                <th>Jenis</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while($data = mysqli_fetch_assoc($query)){
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo date('d/m/Y', strtotime($data['tanggal'])); ?></td>
                <td><?php echo $data['kategori_nama']; ?></td>
                <td><?php echo $data['rekening_nama']; ?></td>
                <td>Rp <?php echo number_format($data['jumlah']); ?></td>
                <td><?php echo $data['keterangan']; ?></td>
                <td><?php echo ucfirst($data['jenis']); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php
}
?> 