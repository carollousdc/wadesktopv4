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
        <div class="card-body" style="height: 340px; overflow-y: scroll; overflow-x: hidden;">
            <div class="form-group">
                <label>HASIL</label>
                <?=!empty($angka[4]) ? "<br />" . $angka[4] : ""?>
                <?=!empty($angka[3]) ? "<br />" . $angka[3] : ""?>
                <?=!empty($angka[2]) ? "<br />" . $angka[2] : ""?>
                <?=!empty($hformat) ? $hformat : ""?>
            </div>
        </div>
        <div class="card-footer clearfix">
            <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <a id="label4d" class="mr-2 badge bg-light" style="white-space: normal;"></a>
                  </span>
                  <span id="sum_price" class="badge bg-dark float-right"><?=$sum_price?></span>
                </div>
        </div>
    </div>
</div>