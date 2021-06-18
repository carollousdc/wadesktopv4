<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-4">
            <div id="preview-chat" style="height: 57vh;">
                <div class="col-12">
                    <div class="card card-default shadow-lg">
                        <div class="card-header">
                            <h3 class="card-title">
                                <b>
                                    PERIKSA FORMAT
                                </b>
                            </h3>
                            <div class="card-tools">
                                <button class="btn btn-tool" data-card-widget="maximize" type="button">
                                    <i class="fas fa-expand">
                                    </i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" style="height: 57vh; overflow-y: scroll; overflow-x: hidden;">
                            <div class="form-group">
                            </div>
                        </div>
                        <div class="card-footer clearfix">
                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <a class="mr-2 badge bg-light" id="label4d" style="white-space: normal;">
                                    </a>
                                </span>
                                <span class="badge bg-dark float-right" id="sum_price">
                                    0
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <form id="form-send">
                    <div class="card-header">
                        <h3 class="card-title">
                            <b>
                                INPUT PESAN
                            </b>
                        </h3>
                        <div class="card-tools">
                            <button class="btn btn-tool" data-card-widget="maximize" type="button">
                                <i class="fas fa-expand">
                                </i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control" id="name" name="name" placeholder="Masukkan keterangan pesan..." required="" rows="15"></textarea>
                    </div>
                    <div class="card-footer clearfix bg-light">
                        <div class="d-flex">
                            <?= $optionKontak; ?>&nbsp;<button class="btn btn-success" id="tombol-simpan" type="submit">Kirim</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>