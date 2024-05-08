<?php
$rootPath = $_SERVER['DOCUMENT_ROOT'];
include $rootPath . "/sistem-persuratan-puskod/config/connection-with-auth.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buat Surat</title>

    <?php
    include $rootPath . "/sistem-persuratan-puskod/components/style.html";
    ?>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php
        include $rootPath . "/sistem-persuratan-puskod/components/navbar.php";
        include $rootPath . "/sistem-persuratan-puskod/components/sidebar.php";
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Buat Surat</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/sistem-persuratan-puskod/tata-usaha/homepage.php">Home</a></li>
                                <li class="breadcrumb-item active">Buat Surat</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Buat Surat Baru</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Kepada:">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Nomor Surat:">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Subjek:">
                                    </div>
                                    <div class="form-group">
    <textarea id="isiSurat" class="form-control" style="height: 300px">
        <p><h1><u>Heading Of Message</u></h1>
        <h4>Subheading</h4>
        <p>But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain
        was born and I will give you a complete account of the system, and expound the actual teachings
        of the great explorer of the truth, the master-builder of human happiness. No one rejects,
        dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know
        how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again
        is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain,
        but because occasionally circumstances occur in which toil and pain can procure him some great
        pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise,
        except to obtain some advantage from it? But who has any right to find fault with a man who
        chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that
        produces no resultant pleasure? On the other hand, we denounce with righteous indignation and
        dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so
        blinded by desire, that they cannot foresee</p>
        <ul>
            <li>List item one</li>
            <li>List item two</li>
            <li>List item three</li>
            <li>List item four</li>
        </ul>
        <p>Thank you,</p>
        <p>John Doe</p>
    </textarea>
</div>

                                    <div class="form-group">
                                        <div class="btn btn-default btn-file">
                                            <i class="fas fa-paperclip"></i> Attachment
                                            <input type="file" name="attachment">
                                        </div>
                                        <p class="help-block">Max. 32MB</p>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <div class="float-right">
                                        <button type="button" class="btn btn-default"><i class="fas fa-pencil-alt"></i> Draft</button>
                                        <button type="submit" class="btn btn-primary"><i class="far fa-envelope"></i> Send</button>
                                    </div>
                                    <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Discard</button>
                                </div>
                                <!-- /.card-footer -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php
        include $rootPath . "/sistem-persuratan-puskod/components/footer.html";
        ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php
    include $rootPath . "/sistem-persuratan-puskod/components/script.html";
    ?>
    <!-- Page specific script -->
    <script>
        $(function() {
            //Add text editor
            $('#isiSurat').summernote()
        })
    </script>
</body>

</html>