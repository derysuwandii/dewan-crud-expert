<?php
//Menggabungkan dengan file koneksi yang telah kita buat
include 'koneksi.php';
include 'auth.php';
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="icon" href="dk.png">
	<title>Expert CRUD</title>
	<!-- Csrf Token -->
	<meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
	<!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap-4.3.1.min.css">

    <!-- SweetAlert -->
    <link rel="stylesheet" type="text/css" href="css/sweetalert2.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">

    <!-- Datatable -->
    <link rel="stylesheet" type="text/css" href="css/datatables/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.bootstrap4.min.css">
    <!-- Animasi -->
    <link rel="stylesheet" href="css/animate-3.5.2.min.css">
    <style type="text/css">
    	.preloader-single{
			background: #fff;
		    width: 100%;
		    height: 350px;
		    padding: 20px;
		}
		.preloader {
		    position: fixed;
		    width: 100%;
		    height: 100%;
		    z-index: 9999;
		    background-color: #fff;
		}
		.preloader .loading {
		    position: absolute;
		    left: 50%;
		    top: 50%;
		    transform: translate(-50%,-50%);
		    font: 14px arial;
		}
		.preloader .loading p {
		    font-size: 16px;
		    font-weight: bold;
		}
    </style>
</head>
<body>
	<div class="preloader" id="preloader">
        <div class="loading">
            <img src="loading.gif" width="80">
            <p>Processing...</p>
        </div>
    </div>

	<nav class="navbar navbar-dark bg-primary">
	  <a class="navbar-brand text-white" href="index.php">
	    Dewan Komputer
	  </a>
	</nav>

	<div class="container-fluid">
		<!-- MODAL TAMBAH & EDIT -->
        <div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" width="100%">
            <div class="modal-dialog modal-xl rotateInDownLeft animated">
                <div class="modal-content">
                    <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <form method="post" class="form-data" id="form-data">
                    	<div class="row">
                    		<div class="col-sm-6">
                    			<div class="form-group">
									<label>Foto</label><br>
									<small class="text-danger">Untuk menghemat storage, gambar dinonaktifkan dan akan otomatis default</small>
									<input type="hidden" name="foto_lama" id="foto_lama">
									<input type="file" name="foto" id="foto" class="form-control">
								</div>
                    			<div class="form-group">
									<label>Nama Mahasiswa</label>
									<input type="text" name="nama_mahasiswa" id="nama_mahasiswa" class="form-control wajib" required="true">
									<p class="text-danger" id="err_nama_mahasiswa"></p>
								</div>
								<div class="form-group">
									<label>Jenis Kelamin</label><br>
									<input type="radio" name="jenkel" id="jenkel1" value="Laki-laki" class="wajib"> Laki-laki
									<input type="radio" name="jenkel" id="jenkel2" value="Perempuan" class="wajib"> Perempuan
									<p class="text-danger" id="err_jenkel"></p>
								</div>
								<div class="form-group">
									<label>Alamat</label>
									<textarea name="alamat" id="alamat" class="form-control wajib" required="true"></textarea>
									<p class="text-danger" id="err_alamat"></p>
								</div>
								<div class="form-group">
									<label>Jurusan</label>
									<select name="jurusan" id="jurusan" class="form-control wajib" required="true">
										<option value=""></option>
										<option value="Sistem Informasi">Sistem Informasi</option>
										<option value="Teknik Informatika">Teknik Informatika</option>
									</select>
									<p class="text-danger" id="err_jurusan"></p>
								</div>
								<div class="form-group">
									<label>Tanggal Masuk</label>
									<input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control wajib" required="true">
									<p class="text-danger" id="err_tanggal_masuk"></p>
								</div>
                    		</div>
                    		<div class="col-sm-6">
                    			<div class="form-group">
									<label>Biodata</label>
									<textarea name="biodata" id="biodata" class="form-control" required="true"></textarea>
								</div>
                    		</div>
                    	</div>
                        
						<div class="form-group">
							<button type="button" name="simpan" id="btnSimpan" class="btn btn-primary">
								<i class="fa fa-save"></i> Simpan
							</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">
								<i class="fa fa-times"></i> Close
							</button>
						</div>

                        <div class="box-footer"></div>
                    </form>
               </div>
                </div>
            </div>
        </div>
        <!-- END MODAL TAMBAH & EDIT -->

        <!-- MODAL VIEW -->
        <div id="viewModal" class="modal fade mr-tp-100" role="dialog">
		    <div class="modal-dialog modal-lg rollIn animated">
		        <div class="modal-content">
		            <div class="modal-body">
		            	<button type="button" class="close" data-dismiss="modal" >
		                    <span aria-hidden="true">&times;</span>
		                    <span class="sr-only">Close</span>
		                </button>

		            	<div class="container row">
							<div class="col-sm-6">
								<div class="form-group">
									<img src="" id="pFoto" height="100px">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label><strong>Nama Mahasiswa</strong></label>
									<p id="pNamaMahasiswa"></p>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label><strong>Jenis Kelamin</strong></label>
									<p id="pJenisKelamin"></p>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label><strong>Alamat</strong></label>
									<p id="pAlamat"></p>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label><strong>Jurusan</strong></label>
									<p id="pJurusan"></p>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label><strong>Tanggal Masuk</strong></label>
									<p id="pTglMasuk"></p>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label><strong>Biodata</strong></label>
									<p id="pBiodata"></p>
								</div>
							</div>
						</div>
		            </div>
		        </div>
		    </div>
		</div>
        <!-- END MODAL VIEW -->

        <marquee><h2>CRUD Expert & Pencarian dengan Ajax, Bootstrap Modal, SweetAlert dan WYSIHTML5 pada PHP TANPA LOADING</h2></marquee>

        <div class="mb-3">
		 	<fieldset class="border p-2">
			    <legend class="w-auto f"><h6>Pencarian</h6></legend>

		        <div class="row">
				    <div class="col-sm-3">
				        <div class="form-group form-inline">
				            <label class="mr-3">Jurusan</label>
				            <select name="s_jurusan" id="s_jurusan" class="form-control">
				                <option value=""></option>
				                <option value="Sistem Informasi">Sistem Informasi</option>
				                <option value="Teknik Informatika">Teknik Informatika</option>
				            </select>
				        </div>
				    </div>
				    <div class="col-sm-4">
				        <div class="form-group form-inline">
				            <label class="mr-3">Keyword</label>
				            <input type="text" name="s_keyword" id="s_keyword" class="form-control">
				        </div>
				    </div>
				    <div class="col-sm-4">
				        <button id="btnCari" class="btn btn-warning"><i class="fa fa-search"></i> Cari</button>
				    </div>
				</div>
			</fieldset>
		</div>

		<button style="margin-bottom: 20px;" id="btnTambah" class="btn btn-primary"> 
			<i class="fa fa-plus"></i> Tambah Data 
		</button>

		<div>
		 	<fieldset class="border p-3">
			    <legend class="w-auto f"><h6>Data Mahasiswa</h6></legend>
		    	<table id="dataTable" class="table table-striped table-bordered" width="100%"></table>
			</fieldset>
		</div>
		
    </div>

    <div class="text-center mt-5">© <?php echo date('Y'); ?> Copyright:
	    <a href="https://dewankomputer.com/"> Dewan Komputer</a>
	</div>


    <!-- JQuery -->
   	<script src="js/jquery-3.3.1.min.js"></script>

   	<!-- Bootstrap -->
   	<script src="js/bootstrap-4.3.1.min.js"></script>
   	<script src="js/popper.min.js"></script>

    <!-- DataTable -->
    <script src="js/datatables/jquery.dataTables.min.js"></script>
    <script src="js/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="js/datatables/dataTables.buttons.min.js"></script>
    <script src="js/datatables/buttons.bootstrap4.min.js"></script>
   	<script src="js/datatables/buttons.html5.min.js"></script>
   	<script src="js/datatables/buttons.print.min.js"></script>
   	<script src="js/datatables/buttons.colVis.min.js"></script>
   	<script src="js/jszip.min.js"></script>
   	<script src="js/pdfmake.min.js"></script>
   	<script src="js/vfs_fonts.js"></script>

    <!-- CKEditor -->
    <script src="ckeditor/ckeditor.js"></script>

    <!-- Sweet Alert -->
    <script src="js/sweetalert2.min.js"></script>
  	
  	<script type="text/javascript">
  		$(document).ready(function(){
  			$(".preloader").fadeOut();
			//Mengirimkan Token Keamanan
			$.ajaxSetup({
			    headers : {
			        'Csrf-Token': $('meta[name="csrf-token"]').attr('content')
			    }
			});

			CKEDITOR.replace('biodata', {
				language: 'en', // id, es, en, dll
				width: '100%',
				height: 230,
				toolbar: [
					{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
					{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
					'/',
					{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
					{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
					{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
					{ name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
					'/',
					{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
					{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
					{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
					{ name: 'others', items: [ '-' ] },
					{ name: 'about', items: [ 'About' ] }, 
				]
		    });

  			let s_Id = "";
  			let table = "";
  			setDatatable();
  			function setDatatable(){
  				let jenis = "view_data";
  				let jurusan = $('#s_jurusan').val();
  				let keyword = $('#s_keyword').val();

  				table = $('#dataTable').DataTable({
			        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		            "destroy": true,
		            "paging": true,
		            "sorting": true,
		            "responsive": true,
			        "ajax": {
			            "type": "POST",
			            "url": "mahasiswa_action.php",
			            "data": {jenis:jenis, jurusan:jurusan, keyword:keyword},
			            "timeout": 120000,
			            "dataSrc": function (json) {
			                if(json != null){
			                    return json
			                } else {
			                    return "";
			                }
			            }
			        },
			        "sAjaxDataProp": "",
			        "width": "100%",
			        "order": [[ 0, "asc" ]],
			        "dom": "Bfrtip",
			        "buttons": [
			            'copyHtml5',
			            {
		                    extend: 'excelHtml5',
		                    filename: 'Data Mahasiswa',
		                    title: 'Rekap Data Mahasiswa',
		                    footer: true,
		                    exportOptions: {
		                        columns: [0, 1, 2, 3, 4, 5, 6, 7],
		                        orthogonal: 'export'
		                    },
		                },
			            'csvHtml5',
			            {
		                    extend: 'pdfHtml5',
		                    filename: 'Data Mahasiswa',
		                    title: 'Rekap Data Mahasiswa',
		                    footer: true,
		                    exportOptions: {
		                        columns: [0, 1, 2, 3, 4, 5, 6, 7],
		                        orthogonal: 'export',
		                        modifier: {
				                    orientation:'landscape'
				                }
		                    },
		                },
			            'colvis'
			        ],
			        "aoColumns": [
			            {
		                    "name": "No", "title": "No",
		                    "data": null,
		                    render: function (data, type, row, meta) {
		                        //return meta.row + meta.settings._iDisplayStart + 1;
								return meta.row + 1;
		                    }
		                },
		                {
		                    "data": null,
		                    "name": "Foto",
		                    "title": "Foto",
		                    "render": function (data, row, type, meta) {
		                        var al = "";
		                        if(row === "export"){
		                            al += data.foto;
		                        } else {
		                        	al += `<img class="mr-1" src="`+data.foto+`" height="30px" />`;
		                        }
		                        return al;
		                    }
		                },
		                {
		                    "data": null,
		                    "name": "Nama Mahasiswa",
		                    "title": "Nama Mahasiswa",
		                    "render": function (data, row, type, meta) {
		                        var al = "";
		                        if(row === "export"){
		                            al += data.nama_mahasiswa;
		                        } else {
		                            al += potongDeskripsi(data.nama_mahasiswa);
		                        }
		                        return al;
		                    }
		                },
		               	{"data": "alamat", "name": "Alamat", "title": "Alamat"},
		               	{"data": "jurusan", "name": "Jurusan", "title": "Jurusan"},
		               	{"data": "jenis_kelamin", "name": "Jenis Kelamin", "title": "Jenis Kelamin"},
		                {
		                    "data": null,
		                    "name": "Tgl Masuk",
		                    "title": "Tgl Masuk",
		                    "render": function (data, row, type, meta) {
		                        var al = "";
		                        if(row === "export"){
		                            al += data.tgl_masuk;
		                        } else {
		                            al += convertDateFromDB(data.tgl_masuk);
		                        }
		                        return al;
		                    }
		                },
		                {
		                    "data": null,
		                    "name": "Biodata",
		                    "title": "Biodata",
		                    "render": function (data, row, type, meta) {
		                        var al = "";
		                        if(row === "export"){
		                            al += data.biodata;
		                        } else {
		                            al += potongDeskripsi(jQuery(decodeHTMLEntities(data.biodata)).text());
		                        }
		                        return al;
		                    }
		                },
			            {
		                    "data": null,
		                    "name": "Aksi",
		                    "title": "Aksi",
		                    "width": "90px",
		                    "render": function (data, row, type, meta) {
			                    return `<button id="`+data.id+`" class="btn btn-primary btn-sm view_data" title="Lihat Data"> <i class="fa fa-search"></i></button>
			                    <button id="`+data.id+`" class="btn btn-success btn-sm edit_data" title="Edit Data"> <i class="fa fa-edit"></i></button>
			                    <button id="`+data.id+`" class="btn btn-danger btn-sm hapus_data" title="Hapus Data"> <i class="fa fa-trash"></i></button>
			                    `;
			                }
			            }
			        ]
			    });
				
  				table.buttons().container().appendTo( '#dataTable_wrapper .col-md-6:eq(0)' );

				$('#dataTable tbody').on( 'click', '.view_data', function () {
				    let id = $(this).attr('id');
				    let jenis = "view_data_by_id";

				    $.ajax({
				        type: 'POST',
				        url: "mahasiswa_action.php",
				        data: {id:id, jenis:jenis},
				        dataType:'json',
				        success: function(response) {
				            $("#pNamaMahasiswa").html(response.nama_mahasiswa);
				            $("#pAlamat").html(response.alamat);
				            $("#pJurusan").html(response.jurusan);
				            $("#pJenisKelamin").html(response.jenis_kelamin);
				            $("#pTglMasuk").html(convertDateFromDB(response.tgl_masuk));
				            $("#pBiodata").html(decodeHTMLEntities(response.biodata));
				            $("#pFoto").attr("src", response.foto);

				            $("#viewModal").modal("show");
				        }
				    });
				});

			    $('#dataTable tbody').on( 'click', '.edit_data', function () {
			    	resetWajib();
			        let id = $(this).attr('id');
			        s_Id = id;

			        let data = table.row( $(this).parents('tr') ).data();
			        $("#foto_lama").val(data["foto"]);
			        $("#nama_mahasiswa").val(data["nama_mahasiswa"]);
			        $("#alamat").val(data["alamat"]);
			        $("#jurusan").val(data["jurusan"]);
			        $("#tanggal_masuk").val(data["tgl_masuk"]);
			        CKEDITOR.instances['biodata'].setData(decodeHTMLEntities(data["biodata"]));

			        if(data["jenis_kelamin"] == "Laki-laki"){
			        	$('#jenkel1').prop('checked', true);
			        } else {
			        	$('#jenkel2').prop('checked', true);
			        }
			        
			        $('#modaltambah').modal({
					    focus: false
					});
			    });

			    $('#dataTable tbody').on( 'click', '.hapus_data', function () {
			        Swal.fire({
					  title: 'Are you sure?',
					  text: "You won't be able to revert this!",
					  type: 'warning',
					  animation: false,
					  customClass: 'animated tada',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  confirmButtonText: 'Yes, delete it!'
					}).then((result) => {
					  if (result.value) {
					    let id = $(this).attr('id');
					    let jenis = "delete_data";

					    $.ajax({
					        type: 'POST',
					        url: "mahasiswa_action.php",
					        data: {id:id, jenis:jenis},
					        success: function(response) {
					        	if(response.code == 200){
									Swal.fire({
						              type: response.status,
						              title: 'Sukses',
						              text: response.message,
						              animation: false,
						              customClass: 'animated bounce'
						            }).then((result) => {
										$('#dataTable').DataTable().ajax.reload(null, false);
									});
								} else {
									Swal.fire({
									  type: response.status,
									  title: response.message,
									  text: '',
									})
								}
					        },error: function(response) {
				            	console.log(response.responseText);
				            }
					    });
					  }
					})
			    });
  			}

			function decodeHTMLEntities(text) {
			  return $("<textarea/>")
			    .html(text)
			    .text();
			}

			function convertDateFromDB(x){
				let al = "";
				let bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

				let tgl = x.split("-")[2];
				let bln = bulan[Math.abs(x.split("-")[1])-1];
				let thn = x.split("-")[0];

				if (x=="" || x==null) {
					al = "";
				} else {
					al = tgl + " " + bln + " " + thn;
				}

				return al;
			}

			function potongDeskripsi(string){
				let hasil = "";

				if (string=="" || string==null) {
					hasil = "";
				} else if(string.length > 15){
					hasil = string.substr(0, 15) + "...";
				} else {
					hasil = string;
				}
				return hasil;
			}

			$("#btnCari").click(function(){
				setDatatable();
			});

			$("#s_jurusan").change(function(){
				setDatatable();
			});

			$("#s_keyword").keyup(function(){
				setDatatable();
			});


			$("#btnTambah").click(function(){
				$('#modaltambah').modal({
				    focus: false
				});
				$('#form-data')[0].reset();

				CKEDITOR.instances['biodata'].setData("");
				s_Id = "";

				resetWajib();
			});

			$(".wajib").change(function(){
			    let name = $(this).attr('name');
			    $('#err_'+name).html("");
			});

			let _validFileExtensions = [".jpg", ".jpeg", ".png", ".gif"];
			function validate(file) {
			    var min = 1024*30; // MINIMAL 30kb
			    var maks = 1024*1024*2; // MAKSIMAL 2MB
			    if (file.type == "file") {
			        var sFileName = file.value;
			        if (sFileName.length > 0) {
			            var blnValid = false;
			            for (var j = 0; j < _validFileExtensions.length; j++) {
			                var sCurExtension = _validFileExtensions[j];
			                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {

			                    blnValid = true;
			                    break;
			                }
			            }

			            if (!blnValid) {
			                Swal.fire({
			                    type: "warning",
			                    title: "Warning!",
			                    text: "Maaf Hanya Boleh File yang Berextensi : " + _validFileExtensions.join(", ")
			                })

			                file.value = "";
			                return false;
			            }

			            if (file.files[0].size < min) {
			                Swal.fire({
			                    type: "warning",
			                    title: "Warning!",
			                    text: "File / Attachment terlalu kecil.\nMinimal besar file adalah 30kb."
			                })

			                file.value = "";
			                return false;
			            }

			            if (file.files[0].size > maks) {
			                Swal.fire({
			                    type: "warning",
			                    title: "Warning!",
			                    text: "File / Attachment terlalu besar.\nMaksimal besar file adalah 2MB."
			                })

			                file.value = "";
			                return false;
			            }
			        }
			    }
			    return true;
			}

			$("#foto").change(function(){
			    validate(this);
			});

			$("#btnSimpan").click(function(){
			    simpanData();
			});

			$('#form-data').keypress(function (e) {
			    if (e.which == 13) {
			        simpanData();
			    }
			});

function simpanData(){
	const foto = $('#foto').prop('files')[0];
	let foto_lama = $('#foto_lama').val();
	let biodata= CKEDITOR.instances['biodata'].getData();
	let jenkel = $('input[name=jenkel]:checked').val();
	let nama_mahasiswa = $('#nama_mahasiswa').val();
	let tanggal_masuk = $('#tanggal_masuk').val();
	let alamat = $('#alamat').val();
	let jurusan = $('#jurusan').val();
	let jenis = "";
	if(s_Id==""){
		jenis = "tambah_data";
	} else {
		jenis = "edit_data";
	}

	if (jenkel==undefined) {
    	$("#err_jenkel").html("Jenis Kelamin Harus Dipilih");
    } else {
    	$("#err_jenkel").html("");
    }
    if (nama_mahasiswa=="") {
    	$("#err_nama_mahasiswa").html("Nama Mahasiswa Harus Diisi");
    } else {
    	$("#err_nama_mahasiswa").html("");
    }
    if (alamat=="") {
    	$("#err_alamat").html("Alamat Mahasiswa Harus Diisi");
    } else {
    	$("#err_alamat").html("");
    }
    if (jurusan=="") {
    	$("#err_jurusan").html("Jurusan Mahasiswa Harus Diisi");
    } else {
    	$("#err_jurusan").html("");
    }
    if (tanggal_masuk=="") {
    	$("#err_tanggal_masuk").html("Tanggal Masuk Mahasiswa Harus Diisi");
    } else {
    	$("#err_tanggal_masuk").html("");
    }

    if (nama_mahasiswa!="" && tanggal_masuk!=""  && alamat!=""  && jurusan!="" && jenkel!=undefined) {
    	let formData = new FormData();
        formData.append('id',s_Id);
        formData.append('nama_mahasiswa', nama_mahasiswa);
        formData.append('jenkel', jenkel);
        formData.append('alamat', alamat);
        formData.append('jurusan', jurusan);
        formData.append('tanggal_masuk', tanggal_masuk);
        formData.append('biodata', biodata);
        formData.append('jenis', jenis);
        formData.append('foto', foto);
		formData.append('foto_lama', foto_lama);

        $.ajax({
            type: 'POST',
            url: "mahasiswa_action.php",
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
			beforeSend: () => {
				Swal.fire({
				html: 'Proses',
				onBeforeOpen: () => {
				    Swal.showLoading()
				},
					allowOutsideClick: () => !Swal.isLoading()
				});
			},
            success: function(response) {
            	if(response.code == 200){
					Swal.fire({
					  type: 'success',
					  title: 'Sukses',
					  text: 'Data Berhasil Disimpan',
					  animation: false,
						  customClass: 'animated fadeInDown'
					}).then((result) => {
						$('#dataTable').DataTable().ajax.reload(null, false);
	                	$('#modaltambah').modal('hide');
	                	$('#form-data')[0].reset();
					});
				} else {
					Swal.fire({
					  type: response.status,
					  title: response.message,
					  text: '',
					})
				}
            },error: function(response) {
            	Swal.close();
            	console.log(response.responseText);
            }
        });
    }
}

		    function resetWajib(){
			    let x = document.getElementsByClassName("wajib");
			    let i;
			    for (i = 0; i < x.length; i++) {
			        let name = x[i].name;
			        $('#err_'+name).html("");
			    } 
			}
		});

	</script>
</body>
</html>