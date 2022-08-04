<?php
//ambil data post
$servermikrotik = $_POST['nama'];
$token = $_POST['token'];
$id_own = $_POST['idtele'];
$filenya = $_POST['namafile'];

if (!empty($servermikrotik) && !empty($token) && !empty($id_own) && !empty($filenya)) {

    //masukkan file .backup ke zip
    $zip = new ZipArchive;

    if ($zip->open($filenya . '.zip', ZipArchive::CREATE) === TRUE) {
        // point 1     
        $zip->addFile($filenya . '.backup');
        $zip->addFile($filenya . '.rsc');

        $zip->close();
    }

    //kirim ke telegram owner
    $domainnya = $_SERVER['HTTP_HOST'];
    $website = "https://api.telegram.org/bot" . $token;
    $params  = [
        'chat_id' => $id_own,
        'document' => 'https://' . $domainnya . '/' . $filenya . '.zip',
        'caption' => 'dibackup pada tanggal ' . date('d-m-Y') . "\nserver " . $servermikrotik,
        'parse_mode' => 'html',
    ];
    $ch = curl_init($website . '/sendDocument');
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);

    //hapus semua file dengan extensi .backup dan .zip
    array_map('unlink', glob("*.backup"));
    array_map('unlink', glob('*.zip'));
    array_map('unlink', glob('*.rsc'));
} else {
    echo "MITHA BACKUP v1.0<br><br>upload file sukses <br><br>";
}
