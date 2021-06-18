<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-1">
                <div class="input-group">
                    <button type="button" class="btn btn-info form-control rounded-0" id="2d" name="2d">2D</button>
                </div>
                <div class="input-group">
                    <input id="2dvalue" name="2dvalue" type="text" class="form-control rounded-0" placeholder="0" style="text-align: center;">
                </div>
            </div>
            <div class="col-1">
                <div class="input-group">
                    <button type="button" class="btn btn-info form-control rounded-0" id="3d" name="3d">3D</button>
                </div>
                <div class="input-group">
                    <input id="3dvalue" name="3dvalue" type="text" class="form-control rounded-0" placeholder="0" style="text-align: center;">
                </div>
            </div>
            <div class="col-1">
                <div class="input-group">
                    <button type="button" class="btn btn-info form-control rounded-0" id="4d" name="4d">4D</button>
                </div>
                <div class="input-group">
                    <input id="4dvalue" name="4dvalue" type="text" class="form-control rounded-0" placeholder="0" style="text-align: center;">
                </div>
            </div>
            <div class="col-1">
                <div class="input-group">
                    <button type="button" class="btn btn-info form-control rounded-0" id="online" name="online">Online</button>
                </div>
                <div class="input-group">
                    <button type="button" class="btn btn-info form-control rounded-0" id="colok" name="colok">Colok</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="card-body">
                    <table class="table table-striped table-secondary table-borderless table-hover myTable" style="width:100%">
                        <?= $headTable2d ?>
                        <?= $bodyTable2d ?>
                    </table>
                </div>
            </div>
            <div class="col-4">
                <div class="card-body">
                    <table class="table table-striped table-secondary table-borderless table-hover myTable" style="width:100%">
                        <?= $headTable3d ?>
                        <?= $bodyTable3d ?>
                    </table>
                </div>
            </div>
            <div class="col-4">
                <div class="card-body">
                    <table class="table table-striped table-secondary table-borderless table-hover myTable" style="width:100%">
                        <?= $headTable4d ?>
                        <?= $bodyTable4d ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>