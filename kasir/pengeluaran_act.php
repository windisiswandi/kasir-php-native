<?php
    include "../koneksi.php";

    function getPengeluaranAll() {
        global $koneksi;
        $kasir_id = $_SESSION['id'];
        $data = mysqli_query($koneksi, "SELECT * from pengeluaran_kasir where kasir_id = $kasir_id");
        $rows = [];
        while ($row = mysqli_fetch_assoc($data)) {
            $rows[] = $row;
        }

        return $rows;
    }

    function getPengeluaranByItemID($id_pengeluaran)
    {
        global $koneksi;
        $kasir_id = $_SESSION['id'];
        $data = mysqli_query($koneksi, "SELECT * from pengeluaran_kasir where kasir_id = $kasir_id and id_pengeluaran=$id_pengeluaran");
        return mysqli_fetch_assoc($data);
    }

    function tambahPengeluaran($data)
    {
        global $koneksi;
        $kasir_id = $data['data']['kasir_id'];
        $tanggal = $data['data']['tgl_pengeluaran'];
        $pengeluaran = $data['data']['pengeluaran'];
        $nominal = $data['data']['nominal'];
        $nominal = str_replace(",00", "", $nominal);
        $nominal = intval(preg_replace("/[^0-9]/", "", $nominal));
        $foto = '';
        $file = $data['file'];
        
        if (!($file["error"] == 4)) {
            $allow = ['jpg', 'png', 'jpeg', 'gif'];
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);

            if (in_array($ext, $allow)) {
                $foto = rand()."_".$file['name'];
                move_uploaded_file($file['tmp_name'], "../gambar/pengeluaran/".$foto);
            }else {
                return -1;
            }
        }

        mysqli_query($koneksi, "INSERT INTO pengeluaran_kasir VALUES('', '$kasir_id', '$tanggal', '$pengeluaran', '$nominal', '$foto')");
        return mysqli_affected_rows($koneksi);
    }

    function editPengeluaran($data)
    {
        global $koneksi;
        $id_pengeluaran = $data['data']['id_pengeluaran'];
        $tanggal = $data['data']['tgl_pengeluaran'];
        $pengeluaran = $data['data']['pengeluaran'];
        $nominal = $data['data']['nominal'];
        $nominal = str_replace(",00", "", $nominal);
        $nominal = intval(preg_replace("/[^0-9]/", "", $nominal));
        $foto = $data['data']['foto'];
        $file = $data['file'];
        
        if (!($file["error"] == 4)) {
            $allow = ['jpg', 'png', 'jpeg', 'gif'];
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);

            if (in_array($ext, $allow)) {
                if ($foto) {
                    unlink("../gambar/pengeluaran/$foto");
                }

                $foto = rand()."_".$file['name'];
                move_uploaded_file($file['tmp_name'], "../gambar/pengeluaran/".$foto);
            }else {
                return -1;
            }
        }

        mysqli_query($koneksi, "UPDATE pengeluaran_kasir set tanggal='$tanggal', pengeluaran='$pengeluaran', nominal='$nominal', foto='$foto' where id_pengeluaran='$id_pengeluaran'");
        return mysqli_affected_rows($koneksi);
    }

    function delPengeluaran($id_pengeluaran)
    {
        global $koneksi;
        $data = mysqli_query($koneksi, "SELECT foto FROM pengeluaran_kasir where id_pengeluaran=$id_pengeluaran");
        $file_foto = mysqli_fetch_assoc($data)['foto'];
        unlink("../gambar/pengeluaran/$file_foto");

        mysqli_query($koneksi, "DELETE FROM pengeluaran_kasir where id_pengeluaran=$id_pengeluaran");
        return mysqli_affected_rows($koneksi);
    }
?>