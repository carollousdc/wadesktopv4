<section class="content">
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Data Pesan Terkirim
                    </h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: auto;">
                            <input class="form-control float-right" id="searchbox" name="searchbox" placeholder="Search" type="text">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12" style="height: 365px;">
                            <form action="<?=base_url($menu->link);?>" id="filter-index" method="post">
                                <?=$optionKontakFilter?>
                            </form>
                            <label>
                            </label>
                            <table class="table table-bordered table-hover" id="tbl_data">
                                <?=$tableHeader?>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="d-flex flex-row justify-content-end">
                        <span class="float-right">
                            <button class="btn btn-success form-control" id="tombol-reset" type="button">
                                Reset
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
            <form id="form-send" method="post">
                <div class="card-header">
                    <h3 class="card-title">
                        <?=($menu->name) . " Pesan";?>
                    </h3>
                </div>
                <div class="card-body">
                        <div class="row margin">
                            <div class="col-6">
                                <?=$optionKontak?>
                            </div>
                            <div class="col-lg-12">
                                <label>
                                </label>
                                <textarea class="form-control" id="name" name="name" placeholder="Masukkan keterangan pesan" required="" rows="12"></textarea>
                            </div>
                        </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="d-flex flex-row justify-content-end">
                        <span class="float-right">
                            <button class="btn btn-success" id="tombol-simpan" type="submit">Kirim</button>
                        </span>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</section>