<div class="col-12 col-lg-3 col-md-3">
    <div class="card card-default shadow-lg">
        <div class="card-header card-block">
            <a class="username" href="#" style="font-weight:600;">
                <?= $player; ?>
                <span class="badge badge-info" data-toggle="tooltip" title="3 New Messages">
                    <?= $count ?>
                    x Kirim
                </span>
            </a>
            <div class="card-tools">
                <button class="btn btn-tool" href="#">
                    <i class="fas fa-download">
                    </i>
                </button>
                <button class="btn btn-tool" data-card-widget="maximize" type="button">
                    <i class="fas fa-expand">
                    </i>
                </button>
            </div>
        </div>
        <div class="card-body" style="height: 350px; overflow-y: scroll; overflow-x: hidden;">
            <div style="white-space: normal;">
                <div class="d-flex justify-content-end">
                    <a class="badge bg-info" style="white-space: normal;">
                        <?= $totalomset; ?>
                    </a>
                    <a class="badge bg-light p-2 w-100" style="white-space: normal;">
                        <?= $angka_result; ?>
                    </a>
                </div>
            </div>
            <br />
            <span class="mailbox-read-time float-right">
                <?= date("Y-m-d h:i A", strtotime($time)); ?>
            </span>
            <br />
            <?= empty($list) ? "" : '<label>4 Angka</label>'; ?>
            <div class="clearfix" style="white-space: normal;">
                <div class="d-flex justify-content-end float-left">
                    <span class="mr-2">
                        <?= $list; ?>
                    </span>
                </div>
            </div>
            <br />
            <?= empty($listf) ? "" : '<label>Colok</label>'; ?>
            <div class="clearfix" style="white-space: normal;">
                <div class="d-flex justify-content-end float-left">
                    <span class="mr-2">
                        <?= $listf; ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="card-footer clearfix bg-light">
            <div class="d-flex justify-content-start">
                <a class="mailbox-attachment-name p-2 w-100 downloadomset" type="file">
                    <i class="fas fa-paperclip">
                    </i>
                    <?= date("Y-m-d", strtotime($time)); ?>.txt
                </a>
                <a class="btn btn-xs btn-default" type="submit">
                    <i class="fas fa-print">
                    </i>
                    Kirim
                </a>
            </div>
        </div>
    </div>
</div>