<!DOCTYPE html>
<html>
    <head>
    	<?php include("./res/common/head.php"); ?>
        <script src="js/navmob.js"></script>
        <script src="js/profile_comunity.js"></script>
    </head>
    <body>
        <?php include("res/common/nav.php") ?>
        <main role="main" class="container-fluid" style="margin-top: 71px; padding-top: 10px;">
            <div class="row">
                <div class="col-3 profile-list">
                    <div class="user-pic-div">
                        <img src="css/user.png" class="user-pic">
                    </div>
                    <div>
                        <center><b><a href="#" id="aluno_id">Fulano</a></b><br />
                        <a id="aluno_apelido" href="profile.php?id=" style="color: black;">@fulano</a></center>
                    </div>
                    <div class="user-items" style="margin-top: 20px;">
                        <ul class="list-group">
                            <a href="profile.php" id="l1"><li class="list-group-item list-group-item-hover-danger" style="margin-top:2px; ">Publicações</li></a>
                            <a href="profile-pictures.php" id="l2"><li class="list-group-item list-group-item-hover-success" style="margin-top:2px; ">Fotos</li></a>
                            <a href="profile-comunity.php" id="l3"><li class="list-group-item list-group-item-warning" style="margin-top: 2px;">Comunidades</li></a>
                            <a href="profile-contact.php" id="l4"><li class="list-group-item list-group-item-hover-primary" style="margin-top:2px; ">Contato</li></a>
                        </ul>
                    </div>
                </div>
                <div class="col-9">
                    <div class="col-12" style="margin-bottom: 5px;">
                        <script>

                            </script>
                            <button class='btn btn-success' onclick="modalAddComunidade()"><i class='fas fa-plus'></i>&nbsp;Criar comunidade</button>
                    </div>    
                    <div class="col-12" id="import">
                        <!-- AJax loads in this place -->
                    </div>
                </div>
            </div>
        </main>
        <?php include("res/common/modal.php"); ?>
    </body>
</html>