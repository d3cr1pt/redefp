<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>RedeFP - Uma rede social escolar</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="icon" href="css/logo.png">
    <script src="../js/login.js"></script>
    <script src="../../vendor/jquery-3.3.1.min.js"></script>
    <script src="../../vendor/popper.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../js/libGET.js"></script>
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap-grid.css">
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap-reboot.css">
    <script src="../vendor/mobile-detect.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
        $(function(){
            $("#type").prop('selectedIndex',0);
            $("#type").change(function(){
                console.log($("#type").val());
                if($("#type").val() == 2) {
                    console.log("Selecionou professor");
                    window.location.href = "../prp/login.php"
                }
            });
        });
    </script>
</head>
<body style="background: lightgrey">
    <div class="container-fluid" style="padding: 0px;">
        <div class="jumbotron">
            <a href="../"><img src="../css/logo.png" class="logicon" style="max-width: 250px !important"></a>
        </div>
        <div id="error"></div>
        <div class="container containerlog">
        <div class="form-group row">
            <label for="exampleFormControlSelect1" class="col-3 col-form-label text-right">Login como</label>
            <div class="col-9">
                <select class="form-control" id="type">
                <option value="1" checked="checked">Aluno</option>
                <option value="2">Professor</option>
                </select>
            </div>
        </div>
            <div class="form-group row">
                <label for="inputRA" class="col-3 col-form-label text-right">RA</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" maxlength="6" size="7" name="inputRA" id="inputRA" step="0" placeholder="RA">
                    <small id="emailHelp" class="form-text text-muted">Utilize o RA provido pela Secretaria Acadêmica.</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-3 col-form-label text-right">Senha</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="inputPassword" placeholder="*****">
                </div>
            </div>
            <div class="col" style="text-align: center">
                <input type="submit" onclick="Submit()" class="btn btn-success" value="Entrar"/>
            </div>
        </div>
    </div>
</body>
</html>