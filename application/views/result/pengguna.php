<div class="col-12 col-lg-3 col-md-3">
    <div class="card card-default shadow-lg">
        <div class="card-header">
            <h3 class="card-title">
                <b>
                    <?= $player; ?>
                </b>
            </h3>
            <div class="card-tools">
                <a class="btn btn-tool" href="#">
                    <i class="fas fa-download">
                    </i>
                </a>
                <button class="btn btn-tool" data-card-widget="maximize" type="button">
                    <i class="fas fa-expand">
                    </i>
                </button>
            </div>
        </div>
        <div class="card-body" style="height: 350px; overflow-y: scroll; overflow-x: hidden;">
            <label>
                Pesan
            </label>
            <div class="contentsend" style="white-space: normal;word-wrap: break-word;">
                <p>
                    <?= $master->name ?>
                </p>
            </div>
            <label>
                Hasil
            </label>
            <br />
            <div style="white-space: normal;">
                <?= $angka ?>
                <?= $hformat ?>
            </div>
        </div>
        <div class="card-footer clearfix">
            <div class='d-flex justify-content-end'>
                <a class="badge bg-light p-2 w-100" style="white-space: normal;"><?= $count ?></a>
                <a class="badge bg-dark" style="white-space: normal;"><?= $totalprice; ?></a>
            </div>
        </div>
        <div class="input-group">
            <input class="form-control" name="message" placeholder="Ketik pesan ..." type="text">
            <span class="input-group-append">
                <button class="btn btn-default" type="submit">
                    Kirim
                </button>
            </span>
            </input>
        </div>
    </div>
</div>