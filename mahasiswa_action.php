<?php
session_start();
include 'koneksi.php';
include 'csrf.php';

function anti($text){
	return $id = stripslashes(strip_tags(htmlspecialchars($text, ENT_QUOTES)));
}

if (isset($_POST['jenis']) && $_POST['jenis']=="view_data") {
	$data = [];
	$jurusan = '%' . anti($_POST['jurusan']) . '%';
	$keyword = '%' . anti($_POST['keyword']) . '%';

	$query = "SELECT * FROM tbl_mahasiswa_expert WHERE jurusan LIKE ? AND nama_mahasiswa LIKE ? ORDER BY nama_mahasiswa ASC";
	$dewan1 = $db1->prepare($query);
	$dewan1->bind_param('ss', $jurusan, $keyword);
	$dewan1->execute();
	$res1 = $dewan1->get_result();
	while ($row = $res1->fetch_assoc()) {
	    $data[] = $row;
	}
	echo json_encode($data);
}

if (isset($_POST['jenis']) && $_POST['jenis']=="view_data_by_id") {
	$id = anti($_POST['id']);
	$query = "SELECT * FROM tbl_mahasiswa_expert WHERE id=? ORDER BY nama_mahasiswa ASC";
	$dewan1 = $db1->prepare($query);
	$dewan1->bind_param('i', $id);
	$dewan1->execute();
	$res1 = $dewan1->get_result();
	while ($row = $res1->fetch_assoc()) {
	    $h['id'] = $row["id"];
	    $h['nama_mahasiswa'] = $row["nama_mahasiswa"];
	    $h['alamat'] = $row["alamat"];
	    $h['jurusan'] = $row["jurusan"];
	    $h['jenis_kelamin'] = $row["jenis_kelamin"];
	    $h['tgl_masuk'] = $row["tgl_masuk"];
	    $h['biodata'] = $row["biodata"];
	    $h['foto'] = $row["foto"];
	}
	echo json_encode($h);
} 

if (isset($_POST['jenis']) && $_POST['jenis']=="tambah_data") {
	$nama_mahasiswa = anti($_POST['nama_mahasiswa']);
	$jenkel = anti($_POST['jenkel']);
	$alamat = anti($_POST['alamat']);
	$jurusan = anti($_POST['jurusan']);
	$tanggal_masuk = anti($_POST['tanggal_masuk']);
	$biodata = anti($_POST['biodata']);

	$temp = "foto/";
    if (isset($_FILES['foto']['tmp_name'])) {
        $fileupload     = $_FILES['foto']['tmp_name'];
        $ImageName      = $_FILES['foto']['name'];
        $acak           = rand(11111111, 99999999);
        $ImageExt       = substr($ImageName, strrpos($ImageName, '.'));
        $ImageExt       = str_replace('.','',$ImageExt);
        $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
        $NewImageName   = str_replace(' ', '', $acak.'.'.$ImageExt);
        $foto           = $temp . $NewImageName;
        move_uploaded_file($fileupload, $temp.$NewImageName);
    } else {
        $foto = "foto/no-image.png";
    }


	//JIKA INGIN VALIDASI DI BACKEND/PHP 
	if($biodata=="") {
		exit(json_encode(['code' => 400, 'status' => 'error', 'message' => 'Biodata Harus diisi']));
	}

	$query = "INSERT into tbl_mahasiswa_expert (nama_mahasiswa, alamat, jurusan, jenis_kelamin, tgl_masuk, biodata, foto) VALUES (?, ?, ?, ?, ?, ?, ?)";
	$dewan1 = $db1->prepare($query);
	$dewan1->bind_param("sssssss", $nama_mahasiswa, $alamat, $jurusan, $jenkel, $tanggal_masuk, $biodata, $foto);
	$dewan1->execute();

	echo json_encode(['code' => 200, 'status' => 'success', 'message' => 'Data Berhasil Disimpan']);
}

if (isset($_POST['jenis']) && $_POST['jenis']=="edit_data") {
	$id = anti($_POST['id']);
	$nama_mahasiswa = anti($_POST['nama_mahasiswa']);
	$jenkel = anti($_POST['jenkel']);
	$alamat = anti($_POST['alamat']);
	$jurusan = anti($_POST['jurusan']);
	$tanggal_masuk = anti($_POST['tanggal_masuk']);
	$biodata = anti($_POST['biodata']);

	if($id == '1'){
		exit(json_encode(['code' => 400, 'status' => 'error', 'message' => 'Data Master Tidak bisa Diubah']));
	}

	$temp = "foto/";
    if (isset($_FILES['foto']['tmp_name'])) {
        $fileupload     = $_FILES['foto']['tmp_name'];
        $ImageName      = $_FILES['foto']['name'];
        $acak           = rand(11111111, 99999999);
        $ImageExt       = substr($ImageName, strrpos($ImageName, '.'));
        $ImageExt       = str_replace('.','',$ImageExt);
        $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
        $NewImageName   = str_replace(' ', '', $acak.'.'.$ImageExt);
        $foto           = $temp . $NewImageName;
        move_uploaded_file($fileupload, $temp.$NewImageName);

        if (anti($_POST['foto_lama']) != "" && $_POST['foto_lama'] != "foto/no-image.png") {
            unlink($_POST['foto_lama']);
        }
    } else {
        $foto = anti($_POST['foto_lama']);
    }

	$query = "UPDATE tbl_mahasiswa_expert SET nama_mahasiswa=?, alamat=?, jurusan=?, jenis_kelamin=?, tgl_masuk=?, biodata=?, foto=? WHERE id=?";
	$dewan1 = $db1->prepare($query);
	$dewan1->bind_param("sssssssi", $nama_mahasiswa, $alamat, $jurusan, $jenkel, $tanggal_masuk, $biodata, $foto, $id);
	$dewan1->execute();

	echo json_encode(['code' => 200, 'status' => 'success', 'message' => 'Data Berhasil Diubah']);
}

if (isset($_POST['jenis']) && $_POST['jenis']=="delete_data") {
	$id = anti($_POST['id']);

	if($id == '1'){
		exit(json_encode(['code' => 400, 'status' => 'error', 'message' => 'Data Master Tidak bisa Dihapus']));
	}

	$query = "SELECT * FROM tbl_mahasiswa_expert WHERE id=? LIMIT 1";
    $dewan1 = $db1->prepare($query);
    $dewan1->bind_param('i', $id);
    $dewan1->execute();
    $res1 = $dewan1->get_result();
    while ($row = $res1->fetch_assoc()) {
        $foto = $row['foto'];
        if($foto!="foto/no-image.png"){
        	unlink($foto);
        }
    }

	$query = "DELETE FROM tbl_mahasiswa_expert WHERE id=?";
	$dewan1 = $db1->prepare($query);
	$dewan1->bind_param("i", $id);
	$dewan1->execute();

	echo json_encode(['code' => 200, 'status' => 'success', 'message' => 'Data Berhasil Dihapus']);
}

$db1->close();
?>