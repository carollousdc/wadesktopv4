<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-12">
            <form id="form-submit" method="post">
                <div class="card card-primary collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            Tambah
                            <?=($menu->
                            name)?>
                        </h3>
                        <button class="btn btn-tool float-right" data-card-widget="collapse" type="button">
                            <i class="fas fa-plus">
                            </i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row margin">
                            <?=($input_form)?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-success" id="tombol-simpan" type="submit">
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Data
                        <?=($menu->
                        name)?>
                    </h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 350px;">
                            <input class="form-control float-right" id="searchbox" name="searchbox" placeholder="Search" type="text">
                                <div class="input-group-append">
                                    <button class="btn btn-default" type="submit">
                                        <i class="fas fa-search">
                                        </i>
                                    </button>
                                </div>
                            </input>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="tbl_data">
                        <?=$tableHeader?>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Edit Data
                        </h4>
                        <button class="close" data-dismiss="modal" type="button">
                            ×
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form-edit" method="post">
                            <?=$edit_form?>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" id="btn_update_data" type="button">
                            Update
                        </button>
                        <button class="btn btn-default" data-dismiss="modal" type="button">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>