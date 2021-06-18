<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <img src="asset/img/logo/<?= $engine->logo; ?>" class="logo-dashboard" style="height: 215px; weight: auto;" />
                <div class="padding-custom">
                    <form action="dashboard/aksi" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="exampleInputFile">File input</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <!-- <input type="file" name="file" class="custom-file-input" id="exampleInputFile" /> -->
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <input class="btn btn-block btn-info form-control" type="submit" name="upload" value="Upload" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <div class="background-form">
                    <form id="form-edit" method="post">
                        <input type="hidden" id="id" name="id" value="BB1" />
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label>API KEY</label>
                                <input type="text" class="single-input-primary" id="apikey" name="apikey" placeholder="Input API Number" value="<?= $engine->apikey; ?>" />
                            </div>
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
                                <input type="text" class="single-input-primary" id="whatsapp" name="whatsapp" placeholder="Ex: +628130000111" value="<?= $engine->whatsapp; ?>" />
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
</section>