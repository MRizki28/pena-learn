<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Modal Demo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
</head>

<body>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#MahasiswaModal">
        Launch demo modal
    </button>
    <!-- Modal -->
    <div class="modal fade" id="MahasiswaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formTambah" method="POST">
                        <input type="hidden" name="id">
                        <input type="text" name="nama" class="form-control">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div>
            <table class="table" id="tabelbody">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tabelData">

                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            function getDataMahasiswa() {
                $.ajax({
                    url: "{{ url('mahasiswa') }}",
                    method: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        var tableBody = "";
                        $.each(response.data, function(index, item) {
                            tableBody += "<tr>";
                            tableBody += "<td>" + item.nama + "</td>";
                            tableBody += "<td>" +
                                "<button type='button' class='btn btn-primary edit-modal' data-bs-toggle='modal' data-bs-target='#MahasiswaModal' " +
                                "data-id='" + item.id + "'>Edit</button>" +
                                "</td>";

                            tableBody += "</tr>";
                        });

                        $("#tabelData").empty();
                        $("#tabelData").append(tableBody);
                    },
                    error: function() {
                        console.log("Failed to get data from server");
                    }
                });
            }
            getDataMahasiswa();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '#submitBtn', function() {
                var form = $('#formTambah')[0];
                var formData = new FormData(form);
                var id = form.id.value;

                if (id) {
                    $.ajax({
                        url: "{{ url('mahasiswa/update') }}/" + id,
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function(response) {
                            console.log(response);
                            alert("Data berhasil diperbarui");
                            $('#MahasiswaModal').modal('hide');
                            form.reset();
                            getDataMahasiswa();
                        },
                        error: function() {
                            console.log("Failed to update data");
                            alert("Gagal memperbarui data");
                        }
                    });
                } else {
                    $.ajax({
                        url: "{{ url('mahasiswa/create') }}",
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function(response) {
                            console.log(response);
                            alert("Data berhasil ditambahkan");
                            $('#MahasiswaModal').modal('hide');
                            form.reset();
                            getDataMahasiswa();
                        },
                        error: function() {
                            console.log("Failed to add data");
                            alert("Gagal menambahkan data");
                        }
                    });
                }
            });

            $('#formTambah').on('keydown', function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault(); 
                }
            });

            $(document).on('click', '.edit-modal', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ url('mahasiswa/get') }}/" + id,
                    method: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        var form = $('#formTambah')[0];
                        form.reset();
                        form.id.value = response.data.id;
                        form.nama.value = response.data.nama;
                        $('#submitBtn').text('Update');
                        $('#MahasiswaModal').modal('show');
                    },
                    error: function() {
                        console.log("Failed to get data for edit");
                        alert("Gagal mendapatkan data untuk edit");
                    }
                });
            });
            $('#MahasiswaModal').on('hidden.bs.modal', function() {
                var form = $('#formTambah')[0];
                form.reset();
                $('#submitBtn').text('Submit');
            });
        });
    </script>
</body>

</html>
