<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row margin">
                            <div class="col-md-3">
                                <div class="card card-outline">
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            <img class="profile-user-img img-fluid img-circle" src="
                                                <?= $showImage ?>" alt="User profile picture" />
                                            <h3 class="profile-username text-center"><?= $linkImage->firstname . " " . $linkImage->lastname ?></h3>
                                            <p class="text-muted text-center">
                                                <?= $roleprofile ?>
                                            </p>
                                            <form action="profile/aksi" method="post" enctype="multipart/form-data">
                                                <input type="file" name="file" class="form-control" />
                                                <br />
                                                <input class="btn btn-block btn-danger form-control rounded pre-register upload-btn" type="submit" name="upload" value="Upload" />
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="background-form">
                                    <form id="form-edit" method="post">
                                        <input type="hidden" id="id" name="id" value="BB1" />
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label>Site Title</label>
                                                <input type="text" class="single-input-primary" id="name" name="name" placeholder="Ex: My Site Title" value="<?= $engine->name; ?>" />
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label>Short Title</label>
                                                <input type="text" class="single-input-primary" id="short_name" name="short_name" placeholder="Ex: Short Title" value="<?= $engine->short_name; ?>" />
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label>Email</label>
                                                <input type="email" class="single-input-primary" id="email" name="email" placeholder="Ex: mywebsite@email.com" value="<?= $engine->email; ?>" />
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label>Whatsapp Number</label>
                                                <input type="text" class="single-input-primary" id="whatsapp" name="whatsapp" placeholder="Ex: 082112345678" value="<?= $engine->whatsapp; ?>" />
                                            </div>
                                            <div class="col-12">
                                                <label>My Location:</label>
                                                <textarea class="single-input-primary" id="location" name="location" placeholder="Ex: Jl. Bima No. 1 Kec. Cicendo Kel. Arjuna, Kota Bandung, 40173"><?= $engine->location; ?></textarea>
                                            </div>
                                            <div class="col-12">
                                                <hr />
                                                <h1>Social Media</h1>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <label>Instagram</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fab fa-instagram-square"></i></span>
                                                    </div>
                                                    <input type="text" id="instagram" name="instagram" class="form-control" placeholder="Instagram" value="<?= $engine->instagram; ?>" />
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <label>Facebook</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                                                    </div>
                                                    <input type="text" id="facebook" name="facebook" class="form-control" placeholder="Facebook" value="<?= $engine->facebook; ?>" />
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <label>Youtube</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fab fa-youtube"></i></span>
                                                    </div>
                                                    <input type="text" id="youtube" name="youtube" class="form-control" placeholder="Youtube" value="<?= $engine->youtube; ?>" />
                                                </div>
                                            </div>
                                            <div class="space-margin-short"></div>
                                            <div class="col-12">
                                                <button type="button" class="pre-register" id="btn_update_data">Update</button>
                                            </div>
                                            <div class="space-margin-long"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>