<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><?= $menu->name ?></h3>
                </div>
                <div class="card-body">
                    <form id="form-submit" method="post">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter title here">
                            </div>
                            <div class="col-lg-3">
                                <input type="text" id="kategori" name="kategori" class="form-control" placeholder="Enter category here">
                            </div>
                            <div class="col-lg-3">
                                <input type="text" id="description" name="description" class="form-control" placeholder="Enter description here">
                            </div>
                            <div class="col-lg-12">
                                <hr />
                                <textarea name="isi" id="isi" rows="10" cols="80"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <button id="tombol-simpan" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
</section>