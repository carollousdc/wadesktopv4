<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Data
                        <?= $menu->name ?>
                    </h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: auto;">
                            <input class="form-control float-right" id="searchbox" name="searchbox" placeholder="Search..." type="text">
                            </input>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="tbl_data">
                        <?= $tableHeader ?>
                    </table>
                    <input id="time-delay" type="hidden">
                    </input>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editModal" role="dialog">
            <form id="form-edit" method="post">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title-edit">
                                Edit Data
                            </h4>
                            <button class="close" data-dismiss="modal" type="button">
                                ×
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-3">
                                    <div id="count-chat">
                                    </div>
                                    <div id="history-chat" style="height: 410px; overflow-y: scroll; overflow-x: hidden;">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <?= $edit_form ?>
                                    <?= $optionStatus ?>
                                </div>
                                <div class="col-3">
                                    <div id="preview-chat">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success" id="btn_update_data" type="button">
                                Kirim
                            </button>
                            <button class="btn btn-default" data-dismiss="modal" type="button">
                                Keluar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal fade bd-example-modal-xl" id="addkontakModal" role="dialog">
            <form id="form-add-kontak" method="post">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                Tambah Kontak
                            </h4>
                            <button class="close" data-dismiss="modal" type="button">
                                ×
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-12">
                                            <label>
                                                Nama
                                            </label>
                                            <input class="form-control" id="name" name="name" type="text">
                                            </input>
                                        </div>
                                        <div class="col-2">
                                            <label>
                                                P2A
                                            </label>
                                            <input class="form-control" id="persen2a" name="persen2a" type="text">
                                            </input>
                                        </div>
                                        <div class="col-2">
                                            <label>
                                                HD2A
                                            </label>
                                            <input class="form-control" id="hd2a" name="hd2a" type="text">
                                            </input>
                                        </div>
                                        <div class="col-2">
                                            <label>
                                                P3A
                                            </label>
                                            <input class="form-control" id="persen3a" name="persen3a" type="text">
                                            </input>
                                        </div>
                                        <div class="col-2">
                                            <label>
                                                HD3A
                                            </label>
                                            <input class="form-control" id="hd3a" name="hd3a" type="text">
                                            </input>
                                        </div>
                                        <div class="col-2">
                                            <label>
                                                P4A
                                            </label>
                                            <input class="form-control" id="persen4a" name="persen4a" type="text">
                                            </input>
                                        </div>
                                        <div class="col-2">
                                            <label>
                                                HD4A
                                            </label>
                                            <input class="form-control" id="hd4a" name="hd4a" type="text">
                                            </input>
                                        </div>
                                        <div class="col-6">
                                            <label>
                                                PCP
                                            </label>
                                            <input class="form-control" id="persencp" name="persencp" type="text">
                                            </input>
                                        </div>
                                        <div class="col-2">
                                            <label>
                                                HDCP1
                                            </label>
                                            <input class="form-control" id="hdcp1" name="hdcp1" type="text">
                                            </input>
                                        </div>
                                        <div class="col-2">
                                            <label>
                                                HDCP2
                                            </label>
                                            <input class="form-control" id="hdcp2" name="hdcp2" type="text">
                                            </input>
                                        </div>
                                        <div class="col-2">
                                            <label>
                                                HDCP3
                                            </label>
                                            <input class="form-control" id="hdcp3" name="hdcp3" type="text">
                                            </input>
                                        </div>
                                        <div class="col-6">
                                            <label>
                                                PCK
                                            </label>
                                            <input class="form-control" id="persenck" name="persenck" type="text">
                                            </input>
                                        </div>
                                        <div class="col-6">
                                            <label>
                                                HDCK
                                            </label>
                                            <input class="form-control" id="hdck" name="hdck" type="text">
                                            </input>
                                        </div>
                                        <div class="col-6">
                                            <label>
                                                PSH
                                            </label>
                                            <input class="form-control" id="persensh" name="persensh" type="text">
                                            </input>
                                        </div>
                                        <div class="col-6">
                                            <label>
                                                HDSH
                                            </label>
                                            <input class="form-control" id="hdsh" name="hdsh" type="text">
                                            </input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-12">
                                            <label>
                                                Telepon
                                            </label>
                                            <input class="form-control" id="phone" name="phone" type="text">
                                            </input>
                                        </div>
                                        <div class="col-4">
                                            <label>
                                                PCB
                                            </label>
                                            <input class="form-control" id="persencb" name="persencb" type="text">
                                            </input>
                                        </div>
                                        <div class="col-2">
                                            <label>
                                                HDCB1
                                            </label>
                                            <input class="form-control" id="hdcb1" name="hdcb1" type="text">
                                            </input>
                                        </div>
                                        <div class="col-2">
                                            <label>
                                                HDCB2
                                            </label>
                                            <input class="form-control" id="hdcb2" name="hdcb2" type="text">
                                            </input>
                                        </div>
                                        <div class="col-2">
                                            <label>
                                                HDCB3
                                            </label>
                                            <input class="form-control" id="hdcb3" name="hdcb3" type="text">
                                            </input>
                                        </div>
                                        <div class="col-2">
                                            <label>
                                                HDCB4
                                            </label>
                                            <input class="form-control" id="hdcb4" name="hdcb4" type="text">
                                            </input>
                                        </div>
                                        <div class="col-6">
                                            <label>
                                                PCN
                                            </label>
                                            <input class="form-control" id="persencn" name="persencn" type="text">
                                            </input>
                                        </div>
                                        <div class="col-3">
                                            <label>
                                                HDCN1
                                            </label>
                                            <input class="form-control" id="hdcn1" name="hdcn1" type="text">
                                            </input>
                                        </div>
                                        <div class="col-3">
                                            <label>
                                                HDCN2
                                            </label>
                                            <input class="form-control" id="hdcn2" name="hdcn2" type="text">
                                            </input>
                                        </div>
                                        <div class="col-6">
                                            <label>
                                                PCE
                                            </label>
                                            <input class="form-control" id="persence" name="persence" type="text">
                                            </input>
                                        </div>
                                        <div class="col-6">
                                            <label>
                                                HDCE
                                            </label>
                                            <input class="form-control" id="hdce" name="hdce" type="text">
                                            </input>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success btn_kontak" type="button">
                                Tambah
                            </button>
                            <button class="btn btn-default" data-dismiss="modal" type="button">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="viewimage" id="imgMessageModal">
            <span class="closes">
                ×
            </span>
            <img class="viewcontent" id="img01">
            <div id="caption">
            </div>
            </img>
        </div>
    </div>
</section>