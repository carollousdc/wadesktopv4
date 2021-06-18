<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta name="viewport" content="initial-scale=1">
    <link href="/bootstrap.css" rel="stylesheet">
    <script type='text/javascript' src='jquery-1.11.1.min.js'></script>

</head>
<style>
    .container {
        max-width: 500px;
    }

    .container {
        background: #e4e4e4 none repeat scroll 0 0;
    }

    textarea#atas {
        background: none repeat scroll 0 0 #fcfcf4;
        color: #217b9f;
        font-family: tahoma;
        font-size: 12px;
        height: 100px;
        width: 100%;
    }

    textarea#result {
        background: none repeat scroll 0 0 #fcfcf4;
        color: #217b9f;
        font-family: tahoma;
        font-size: 12px;
        height: 100px;
        width: 100%;
    }

    .col-lg-1,
    .col-lg-10,
    .col-lg-11,
    .col-lg-12,
    .col-lg-2,
    .col-lg-3,
    .col-lg-4,
    .col-lg-5,
    .col-lg-6,
    .col-lg-7,
    .col-lg-8,
    .col-lg-9,
    .col-md-1,
    .col-md-10,
    .col-md-11,
    .col-md-12,
    .col-md-2,
    .col-md-3,
    .col-md-4,
    .col-md-5,
    .col-md-6,
    .col-md-7,
    .col-md-8,
    .col-md-9,
    .col-sm-1,
    .col-sm-10,
    .col-sm-11,
    .col-sm-12,
    .col-sm-2,
    .col-sm-3,
    .col-sm-4,
    .col-sm-5,
    .col-sm-6,
    .col-sm-7,
    .col-sm-8,
    .col-sm-9,
    .col-xs-1,
    .col-xs-10,
    .col-xs-11,
    .col-xs-12,
    .col-xs-2,
    .col-xs-3,
    .col-xs-4,
    .col-xs-5,
    .col-xs-6,
    .col-xs-7,
    .col-xs-8,
    .col-xs-9 {
        min-height: 1px;
        padding: 2px;
    }

    a {
        text-decoration: none
    }
</style>
<script type="text/javascript">
    function pilih() {
        if ($('#sel2').val() == 1)
            gen2();
        else if ($('#sel2').val() == 2)
            gen();
        else if ($('#sel2').val() == 3)
            gen1();
    }

    function gen() {

        var d = new Array();
        var e = new Array();
        var f = new Array();
        var tmp = '';
        var tmpn = '';
        var sep = $('#sel1').val();
        c = $('#nomor').val().length;
        if (c >= 4) {

            str = $('#nomor').val();
            x = 0;
            tmpn = '';
            for (i = 0; i < c; i++) {
                for (j = 0; j < c; j++) {
                    if ((i != j) && (d.indexOf(str.substring(i, i + 1) + str.substring(j, j + 1)) == -1)) {
                        d[x] = str.substring(i, i + 1) + str.substring(j, j + 1);
                        x += 1;
                        tmp = tmp + str.substring(i, i + 1) + str.substring(j, j + 1) + sep;
                        tmpn = tmpn + str.substring(i, i + 1) + str.substring(j, j + 1) + sep;
                    }
                }
            }
            $('#tempat2').text(tmpn);
            x = 0;
            tmpn = '';
            for (i = 0; i < c; i++) {
                for (j = 0; j < c; j++) {
                    for (k = 0; k < c; k++) {
                        if ((i != j) && (i != k) && ((k != j)) && (e.indexOf(str.substring(i, i + 1) + str.substring(j, j + 1) + str.substring(k, k + 1)) == -1)) {
                            e[x] = str.substring(i, i + 1) + str.substring(j, j + 1) + str.substring(k, k + 1);
                            x += 1;
                            tmp = tmp + str.substring(i, i + 1) + str.substring(j, j + 1) + str.substring(k, k + 1) + sep;
                            tmpn = tmpn + str.substring(i, i + 1) + str.substring(j, j + 1) + str.substring(k, k + 1) + sep;
                        }
                    }
                }
            }
            $('#tempat3').text(tmpn);

            x = 0;
            tmpn = '';
            for (i = 0; i < c; i++) {
                for (j = 0; j < c; j++) {
                    for (k = 0; k < c; k++) {
                        for (l = 0; l < c; l++) {
                            if ((i != j) && (i != k) && (i != l) && (j != k) && (j != l) && (k != l) && (f.indexOf(str.substring(i, i + 1) + str.substring(j, j + 1) + str.substring(k, k + 1) + str.substring(l, l + 1)) == -1)) {
                                f[x] = str.substring(i, i + 1) + str.substring(j, j + 1) + str.substring(k, k + 1) + str.substring(l, l + 1);
                                x += 1;
                                tmp = tmp + str.substring(i, i + 1) + str.substring(j, j + 1) + str.substring(k, k + 1) + str.substring(l, l + 1) + sep;
                                tmpn = tmpn + str.substring(i, i + 1) + str.substring(j, j + 1) + str.substring(k, k + 1) + str.substring(l, l + 1) + sep;
                            }
                        }
                    }
                }
            }
            $('#tempat4').text(tmpn);
            $('#tempat').val(tmp);
        }
    }

    function gen1() {
        var d = new Array();
        var e = new Array();
        var f = new Array();
        var tmp = '';
        var tmpn = '';
        var sep = $('#sel1').val();
        c = $('#nomor').val().length;
        if (c >= 4) {
            str = $('#nomor').val();
            x = 0;
            tmpn = '';
            for (i = 0; i < c; i++) {
                for (j = 0; j < c; j++) {
                    if (str.substring(i, i + 1) == str.substring(j, j + 1)) {
                        d[x] = str.substring(i, i + 1) + str.substring(j, j + 1);
                        x += 1;
                        tmp = tmp + str.substring(i, i + 1) + str.substring(j, j + 1) + sep;
                        tmpn = tmpn + str.substring(i, i + 1) + str.substring(j, j + 1) + sep;
                    }
                }
            }
            $('#tempat2').text(tmpn);
            x = 0;
            tmpn = '';
            for (i = 0; i < c; i++) {
                for (j = 0; j < c; j++) {
                    for (k = 0; k < c; k++) {
                        if ((str.substring(i, i + 1) == str.substring(j, j + 1)) || (str.substring(i, i + 1) == str.substring(k, k + 1)) || (str.substring(j, j + 1) == str.substring(k, k + 1))) {
                            e[x] = str.substring(i, i + 1) + str.substring(j, j + 1) + str.substring(k, k + 1);
                            x += 1;
                            tmp = tmp + str.substring(i, i + 1) + str.substring(j, j + 1) + str.substring(k, k + 1) + sep;
                            tmpn = tmpn + str.substring(i, i + 1) + str.substring(j, j + 1) + str.substring(k, k + 1) + sep;
                        }
                    }
                }
            }
            $('#tempat3').text(tmpn);
            x = 0;
            tmpn = '';
            for (i = 0; i < c; i++) {
                for (j = 0; j < c; j++) {
                    for (k = 0; k < c; k++) {
                        for (l = 0; l < c; l++) {
                            if ((str.substring(i, i + 1) == str.substring(j, j + 1)) || (str.substring(i, i + 1) == str.substring(k, k + 1)) || (str.substring(i, i + 1) == str.substring(l, l + 1)) || (str.substring(j, j + 1) == str.substring(k, k + 1)) || (str.substring(j, j + 1) == str.substring(l, l + 1)) || (str.substring(k, k + 1) == str.substring(l, l + 1))) {
                                f[x] = str.substring(i, i + 1) + str.substring(j, j + 1) + str.substring(k, k + 1) + str.substring(l, l + 1);
                                x += 1;
                                tmp = tmp + str.substring(i, i + 1) + str.substring(j, j + 1) + str.substring(k, k + 1) + str.substring(l, l + 1) + sep;
                                tmpn = tmpn + str.substring(i, i + 1) + str.substring(j, j + 1) + str.substring(k, k + 1) + str.substring(l, l + 1) + sep;
                            }
                        }
                    }
                }
            }
            $('#tempat4').text(tmpn);
            $('#tempat').val(tmp);
        }
    }

    function gen2() {

        var d = new Array();
        var e = new Array();
        var f = new Array();
        var tmp = '';
        var tmpn = '';
        var sep = $('#sel1').val();
        c = $('#nomor').val().length;
        if (c >= 4) {

            str = $('#nomor').val();
            x = 0;
            tmpn = '';
            for (i = 0; i < c; i++) {
                for (j = 0; j < c; j++) {
                    if ((i != j) && (d.indexOf(str.substring(i, i + 1) + str.substring(j, j + 1)) == -1)) {
                        d[x] = str.substring(i, i + 1) + str.substring(j, j + 1);
                        x += 1;
                        tmp = tmp + str.substring(i, i + 1) + str.substring(j, j + 1) + sep;
                        tmpn = tmpn + str.substring(i, i + 1) + str.substring(j, j + 1) + sep;
                    }
                }
            }
            x = 0;
            for (i = 0; i < c; i++) {
                for (j = 0; j < c; j++) {
                    if (str.substring(i, i + 1) == str.substring(j, j + 1)) {
                        d[x] = str.substring(i, i + 1) + str.substring(j, j + 1);
                        x += 1;
                        tmp = tmp + str.substring(i, i + 1) + str.substring(j, j + 1) + sep;
                        tmpn = tmpn + str.substring(i, i + 1) + str.substring(j, j + 1) + sep;
                    }
                }
            }
            $('#tempat2').text(tmpn);
            x = 0;
            tmpn = '';
            for (i = 0; i < c; i++) {
                for (j = 0; j < c; j++) {
                    for (k = 0; k < c; k++) {
                        if ((i != j) && (i != k) && ((k != j)) && (e.indexOf(str.substring(i, i + 1) + str.substring(j, j + 1) + str.substring(k, k + 1)) == -1)) {
                            e[x] = str.substring(i, i + 1) + str.substring(j, j + 1) + str.substring(k, k + 1);
                            x += 1;
                            tmp = tmp + str.substring(i, i + 1) + str.substring(j, j + 1) + str.substring(k, k + 1) + sep;
                            tmpn = tmpn + str.substring(i, i + 1) + str.substring(j, j + 1) + str.substring(k, k + 1) + sep;
                        }
                    }
                }
            }
            x = 0;
            for (i = 0; i < c; i++) {
                for (j = 0; j < c; j++) {
                    for (k = 0; k < c; k++) {
                        if ((str.substring(i, i + 1) == str.substring(j, j + 1)) || (str.substring(i, i + 1) == str.substring(k, k + 1)) || (str.substring(j, j + 1) == str.substring(k, k + 1))) {
                            e[x] = str.substring(i, i + 1) + str.substring(j, j + 1) + str.substring(k, k + 1);
                            x += 1;
                            tmp = tmp + str.substring(i, i + 1) + str.substring(j, j + 1) + str.substring(k, k + 1) + sep;
                            tmpn = tmpn + str.substring(i, i + 1) + str.substring(j, j + 1) + str.substring(k, k + 1) + sep;
                        }
                    }
                }
            }
            $('#tempat3').text(tmpn);
            x = 0;
            tmpn = '';
            for (i = 0; i < c; i++) {
                for (j = 0; j < c; j++) {
                    for (k = 0; k < c; k++) {
                        for (l = 0; l < c; l++) {
                            if ((i != j) && (i != k) && (i != l) && (j != k) && (j != l) && (k != l) && (f.indexOf(str.substring(i, i + 1) + str.substring(j, j + 1) + str.substring(k, k + 1) + str.substring(l, l + 1)) == -1)) {
                                f[x] = str.substring(i, i + 1) + str.substring(j, j + 1) + str.substring(k, k + 1) + str.substring(l, l + 1);
                                x += 1;
                                tmp = tmp + str.substring(i, i + 1) + str.substring(j, j + 1) + str.substring(k, k + 1) + str.substring(l, l + 1) + sep;
                                tmpn = tmpn + str.substring(i, i + 1) + str.substring(j, j + 1) + str.substring(k, k + 1) + str.substring(l, l + 1) + sep;
                            }
                        }
                    }
                }
            }
            x = 0;
            for (i = 0; i < c; i++) {
                for (j = 0; j < c; j++) {
                    for (k = 0; k < c; k++) {
                        for (l = 0; l < c; l++) {
                            if ((str.substring(i, i + 1) == str.substring(j, j + 1)) || (str.substring(i, i + 1) == str.substring(k, k + 1)) || (str.substring(i, i + 1) == str.substring(l, l + 1)) || (str.substring(j, j + 1) == str.substring(k, k + 1)) || (str.substring(j, j + 1) == str.substring(l, l + 1)) || (str.substring(k, k + 1) == str.substring(l, l + 1))) {
                                f[x] = str.substring(i, i + 1) + str.substring(j, j + 1) + str.substring(k, k + 1) + str.substring(l, l + 1);
                                x += 1;
                                tmp = tmp + str.substring(i, i + 1) + str.substring(j, j + 1) + str.substring(k, k + 1) + str.substring(l, l + 1) + sep;
                                tmpn = tmpn + str.substring(i, i + 1) + str.substring(j, j + 1) + str.substring(k, k + 1) + str.substring(l, l + 1) + sep;
                            }
                        }
                    }
                }
            }
            $('#tempat4').text(tmpn);
            $('#tempat').text(tmp);
        }
    }
</script>

<body>
    <div class="container" style="border-style: solid;">
        <br><br>
        <div class="form-group row">
            <label for="example-text-input" class="col-2 col-form-label">Angka</label>
            <div class="col-10">
                <input class="form-control" type="text" id="nomor" name="nomor">
            </div>
        </div>
        <div class="form-group row">
            <label for="sel1" class="col-2 col-form-label">Separator</label>
            <div class="col-10">
                <select class="form-control" id="sel1">
                    <option value="*">*</option>
                    <option value="-">-</option>
                    <option value=",">,</option>
                    <option value=";">;</option>
                    <option value="+">+</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="sel1" class="col-2 col-form-label">Mode</label>
            <div class="col-10">
                <select class="form-control" id="sel2">
                    <option value="1">Bbfs campuran</option>
                    <option value="2">Bbfs tanpa kembar</option>
                    <option value="3">Bbfs khusus kembar</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-10">
                <button class="btn-primary" onclick="pilih()">Generate</button>
                <input type="button" class="btn-danger" value="Reset" onclick="window.location.href=window.location.href;" />
            </div>
        </div>
    </div>

    <div class="container" style="border-style: solid; padding-left: 0.5cm;">
        <div class="form-group row">
            <label for="judul" class="control-label col-xs-2">
                <h5>Angka jadi set 2D - 3D - 4D</h5>
            </label>
            <div class="col-12">
                <textarea class="form-control" id="tempat" rows="8" cols="50"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="judul" class="control-label col-xs-2">
                <h5>Angka khusus jadi 2D</h5>
            </label>
            <div class="col-12">
                <textarea class="form-control" id="tempat2" rows="6" cols="50"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="judul" class="control-label col-xs-2">
                <h5>Angka khusus jadi 3D</h5>
            </label>
            <div class="col-12">
                <textarea class="form-control" id="tempat3" rows="6" cols="50"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="judul" class="control-label col-xs-2">
                <h5>Angka khusus jadi 4D</h5>
            </label>
            <div class="col-12">
                <textarea class="form-control" id="tempat4" rows="6" cols="50"></textarea>
            </div>
        </div>
    </div>
    <br>
    <center> <a href="http://zonapaito.club"><b>ZONAPAITO.CLUB</b></a></center>
    <br>
    <!-- Histats.com  START  (aync)-->
    <script type="text/javascript">
        var _Hasync = _Hasync || [];
        _Hasync.push(['Histats.start', '1,3614491,4,0,0,0,00010000']);
        _Hasync.push(['Histats.fasi', '1']);
        _Hasync.push(['Histats.track_hits', '']);
        (function() {
            var hs = document.createElement('script');
            hs.type = 'text/javascript';
            hs.async = true;
            hs.src = ('//s10.histats.com/js15_as.js');
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(hs);
        })();
    </script>
    <noscript><a href="/" target="_blank"><img src="//sstatic1.histats.com/0.gif?3614491&101" alt="web statistics" border="0"></a></noscript>
    <!-- Histats.com  END  -->
</body>

</html>