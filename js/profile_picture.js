function loadPerfil()
{
    var id;
    if(typeof($_GET['id']) != "undefined") {
        id = $_GET['id'];    
    } else {
        id = JSON.parse(localStorage.user)['id'];
    }
    $.get("gateway/getJSON.php",{f:"one-profile", id: id}, function(result){
        aluno = JSON.parse(result);
        if(aluno.profile_pic_url != "") {
            $(".user-pic").attr("src",aluno.profile_pic_url);
        }
        $("#aluno_id").attr("href","profile.php?id="+aluno.id);
        $("#aluno_id").html(aluno.nome);
        $("#aluno_apelido").html("@"+aluno.apelido);
        document.getElementById("aluno_apelido").setAttribute("href","profile.php?id="+aluno.id);
        $("#l1").attr("href","profile.php?id="+aluno.id);
        $("#l2").attr("href","profile-pictures.php?id="+aluno.id);
        $("#l3").attr("href","profile-comunity.php?id="+aluno.id);
        $("#l4").attr("href","profile-contact.php?id="+aluno.id);
        $("#import").load('/handler/profile-pictures.php?id='+aluno.id,function(){
            $("#import").prepend('<div class="col-3 user-image" id="upload" align="center"><img src="/uploads/plus.jpg" class="user-image-src"><br><span>Enviar fotos</span><br><span>05/01/2019</span></div>');
            $("#upload").on("click",function(){
                console.log("função em breve"); //insert upload form here
                $(".modal-title").html('Upload de Fotos');
                $(".modal-body").html('<form id="fotoup" action="gateway/upload/profile-image.php" method="post" enctype="multipart/form-data">Escolha a imagem:<br><input type="file" name="fileToUpload" id="fileToUpload" accept="image/*"></form>');
                $(".btn-primary").html('Enviar Imagem');
                $(".btn-primary").attr('onclick','salvarFoto()');
                $(".btn-secondary").html('Cancelar');
                $("#commentmodal").modal('show');
            });
        });
    });
}

function salvarFoto()
{
    
}

$(function(){
    loadPerfil();
    $(".nav-item")[1].setAttribute("class","nav-item active");
});