<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Pasien</title>
    <link rel="stylesheet" href="<?php echo base_url(''); ?>assets/css/bootstrap.css">
</head>
<body>
    <div class="container" style="margin-top: 10px;">

        <div class="col-md-12">
            <!-- Button trigger modal -->
            <button type="button" id="form-add" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modelId">
              Add Record
            </button>
            <hr>
            <!-- Modal -->
            <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo base_url('index.php/pasien/create'); ?>" id="formque">
                                <div class="form-group">
                                    <label>No. RM</label>
                                    <input name="id" id="id" type="hidden" class="form-control">
                                    <input name="no_rm" id="no_rm" type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Nama Pasien</label>
                                    <input name="nama_pasien" id="nama_pasien" type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input name="alamat" id="alamat_pasien" type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Tempat Lahir</label>
                                    <input name="tempat_lahir" id="tempat_lahir_pasien" type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input name="tanggal_lahir" id="tanggal_lahir_pasien" type="date" class="form-control">
                                </div>
                            </form>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" id="save-data" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-sm table-striped table-hover">
                <thead>
                    <tr class="bg-primary text-white">
                        <td>No</td>
                        <td>Nama Pasien</td>
                        <td>Alamat</td>
                        <td>Tempat Lahir</td>
                        <td>Tanggal Lahir</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody id="show-data">
                
                </tbody>
            </table>
        </div>
    </div>
</body>
<script src="<?php echo base_url(); ?>assets/jquery-3.4.1.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
<script>
    $(document).ready(function(){
        Show_max_id();
        function Show_max_id(){
            $.ajax({
                url : '<?php echo base_url('index.php/pasien/get_max_id'); ?>',
                type : 'GET',
                dataType: 'JSON',
                success:function(data){
                    $('#no_rm').val(data)
                    console.log(data);
                }
            });
        }

        Show();
        function Show(){
            var url = '<?php echo base_url('index.php/pasien/show'); ?>';
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                success:function(data){
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<tr>' +
                                    '<td>' + data[i].no_rm + '</td>' +
                                    '<td>' + data[i].nama_pasien + '</td>' +
                                    '<td>' + data[i].alamat + '</td>' +
                                    '<td>' + data[i].tempat_lahir_pasien + '</td>' +
                                    '<td>' + data[i].tanggal_lahir_pasien + '</td>' +
                                    '<td class="text-center">' +
                                        '<a href="javascript:;" data="'+data[i].pasien_id+'" class="btn btn-success btn-sm show-single-record" style="margin-right: 10px;">' + '<i class="glyphicon glyphicon-home"></i>' + 'Edit' +'</a>' +
                                        '<a href="javascript:;" data="'+data[i].pasien_id+'" class="btn btn-danger btn-sm delete-single-record">' + 'Hapus' +'</a>' +
                                    '</td>' +
                                '</tr>'
                    }
                    $('#show-data').html(html);
                }
            })
        }

        $('#form-add').on('click', function(){
            $('.modal-title').text("Tambah Data Pasien");
        });

        $('#save-data').on('click', function(){
            var form = $('#formque');
            var id = $('#id_pasien');
            if(id==null){
                $.ajax({
                    url : form.attr('action'),
                    type : 'POST',
                    dataType: 'JSON',
                    data : form.serialize(),
                    success:function(data){
                        $('#modelId').modal('hide');
                        Show();
                        Show_max_id();
                        console.log('record added', 200);
                    }
                });
            }else{
                $.ajax({
                    url : '<?php echo base_url('index.php/pasien/update/'); ?>',
                    type : 'POST',
                    dataType : 'JSON',
                    data : form.serialize(),
                    success:function(data){
                        $('#modelId').modal('hide');
                        Show();
                        Show_max_id();
                        console.log('record updated', 200);
                    }
                });
            }
            
        });

        $('#show-data').on('click','.show-single-record', function(){
            $('.modal-title').text("Perbaharui Data Pasien");
            var id_data = $(this).attr('data');
            $.ajax({
                url : '<?php echo base_url('index.php/pasien/edit/'); ?>' + id_data,
                type : 'GET',
                dataType : 'JSON',
                success:function(data){
                    $('#modelId').modal('show');
                    for(var i=0; i<data.length; i++){
                        $('#id').val(data[i].pasien_id);
                        $('#no_rm').val(data[i].no_rm);
                        $('#nama_pasien').val(data[i].nama_pasien);
                        $('#alamat_pasien').val(data[i].alamat);
                        $('#tempat_lahir_pasien').val(data[i].tempat_lahir_pasien);
                        $('#tanggal_lahir_pasien').val(data[i].tanggal_lahir_pasien);
                    }
                }
            });
        });

        $('#show-data').on('click','.delete-single-record', function(){
            var id_data = $(this).attr('data');
            $.ajax({
                url : '<?php echo base_url('index.php/pasien/destroy/'); ?>' + id_data,
                type : 'GET',
                dataType : 'JSON',
                success:function(data){
                    console.log('success delete single record data');
                    Show();
                }
            });
        });
    });
</script>
</html>