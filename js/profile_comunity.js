function loadPerfil()
{
    var id;
    if(typeof($_GET['id']) != "undefined") {
        id = $_GET['id'];    
    } else {
        id = JSON.parse(localStorage.user)['id'];
    }
    $.get("gateway/getJSON.php",{f:"one-profile", id: id}, function(result){
        aluno = result;
        if(aluno.profile_pic_url != "") {
            $(".user-pic").attr("src",URLBASE+aluno.profile_pic_url);
        }
        $("#aluno_id").attr("href","profile.php?id="+aluno.id);
        $("#aluno_id").html(aluno.nome);
        $("#aluno_apelido").html("@"+aluno.apelido);
        document.getElementById("aluno_apelido").setAttribute("href","profile.php?id="+aluno.id);
        $("#l1").attr("href","profile.php?id="+aluno.id);
        $("#l2").attr("href","profile-pictures.php?id="+aluno.id);
        $("#l3").attr("href","profile-comunity.php?id="+aluno.id);
        $("#l4").attr("href","profile-contact.php?id="+aluno.id);
        $("#import").load(URLBASE+'/handler/profile-comunity.php?id='+aluno.id)
    });
}

function modalSairComunidade($id) {
    $(".modal-title").text("Saindo de uma comunidade");
    $(".btn-primary").addClass(".btn-danger").html("Confirmar").attr("onclick","sairComunidade("+$id+")");
    $(".modal-body").text("Você tem certeza que quer sair dessa comunidade");
    $(".modal").modal('show');
}

function modalFotoPerfil() {
    hideModal();
    $(".modal-title").text("Foto de Perfil");
    $(".modal .btn-primary").hide();
    $(".modal .btn-success").hide();
    $(".modal .btn-secondary").hide();
    if(parseUser().profile_pic_url != "") {
        $(".modal .btn-warning").show().html("<i class='fas fa-sync-alt'></i>").attr("onclick","modalEditFotoPerfil()");
        $(".modal .modal-body").html("<img src='"+URLBASE+parseUser().profile_pic_url+"' style='width: 60%;'>").attr("align","center");
        $(".modal .btn-danger").show().html(`<i class="fas fa-trash-alt"></i>`).attr("onclick","modalDeleteFotoPerfil()");
    } else {
        $(".modal .modal-body").hide();
        $(".modal .btn-success").show().html(`<i class="fas fa-plus"></i>`).attr("onclick","modalAddFotoPerfil()");
    }
    showModal();
}

function modalEditFotoPerfil() {
    $(".modal-title").text("Atualizando a Foto de Perfil");
    $(".modal .btn-primary").hide();
    $(".modal .btn-success").show().html(`<i class="fas fa-check"></i>`).attr("onclick","saveEditFotoPerfil()");
    $(".modal .btn-danger").show().html(`<i class="fas fa-times"></i>`).attr("onclick","").attr("data-dismiss","modal");
    $(".modal .btn-warning").hide();
    $(".modal .btn-secondary").hide();
    $(".modal .modal-body").html(`<form id="dataFoto" enctype="multipart/form-data" name="dataFoto" method="post" action="handler/photo_upload.profile.php"><input type="file" name="fileToUpload" class="form-control">`)
    showModal();
}

function saveEditFotoPerfil() {
    $("#dataFoto").append(`<input type="hidden" name="id" value="`+parseUser().id+`">`);
    document.getElementById('dataFoto').submit();
}

function modalDeleteFotoPerfil() {
    $(".modal-title").text("Removendo a foto de perfil");
    $(".modal .btn-primary").hide();
    $(".modal .btn-warning").hide();
    $(".modal .btn-danger").show().html("<i class='fas fa-times'></i>").data("dismiss","modal");
    $(".modal .btn-success").show().html("<i class='fas fa-check'></i>").attr("onclick","deleteFotoPerfil()");
    $(".modal .btn-secondary").hide();
    $(".modal .modal-body").text("Você tem certeza disso?");
}

function deleteFotoPerfil() {
    $data = {
        f: "deleteFotoPerfil",
        id: parseUser().id
    };
    $.get(URLBASE+"gateway/getJSON.php",$data,function(result){
        if(result == true) {
            obj = parseUser();
            obj.profile_pic_url = "";
            localStorage.user = JSON.stringify(obj);
            window.location.reload();
        } else {
            $(".modal-body").html(result);
        }
    })
}

function showModal() {
    $(".modal").modal('show');
}

function hideModal() {
    $(".modal").modal('hide');
}

function modalAddFotoPerfil() {
    $(".modal-title").text("Adicionando uma foto de Perfil");
    $(".modal-body").show().html(`<form id="addFoto" action="handler/photo_upload.profile.php" method="GET"><input type="file" id="varFoto" class="form-control"></form>`)
    $(".modal .btn-success").show().html("<i class='fas fa-check'></i>").attr("onclick","addFotoPerfil()");
}

function addFotoPerfil() {
    $("#addFoto").append('<input type="hidden" value="'+parseUser().id+'"> id="id" name="id">');
    $("#addFoto").submit();
    hideModal();
}


function sairComunidade($id) {
    var id = $id;
    var aluno = JSON.parse(localStorage.user)['id'];
    $var = {
        id: id,
        idaluno: aluno,
        f: 'deleteComunidadeEntrada'
    };
    $.get(URLBASE+"gateway/getJSON.php",$var, function(result) {
        if(result != "false") {
            window.location.reload();
        } else {
            console.log(result)
        }
    });
}

$(function(){
    md = new MobileDetect(window.navigator.userAgent);
    loadPerfil();
    $(".nav-item")[1].setAttribute("class","nav-item active");
    $(document).one("ajaxStop",function(){
        if(md.mobile() != null){
            $(".col-3").remove();
            $(".col-9").attr("class","col");
            if(typeof($_GET['id']) != "undefined") {
                id = $_GET['id'];    
            } else {
                id = JSON.parse(localStorage.user)['id'];
            }
            loadNavMob(id);
        }
    })
});
$(document).one("ajaxStop",function(){
    $(".user-pic").click(modalFotoPerfil);
});

function sugerirTema() {
    $(".modal .modal-body").html("");
    $(".modal .modal-title").text("Modal Title")
    $(".modal .modal-title").text("Sugerindo tema");
    $(".modal .modal-body").append("Nome: <input type='text' class='form-control' id='txNome' maxlength='50'><br>");
    $(".modal .btn-primary").hide();
    $(".modal .btn-success").show().attr("onclick","sugerirTemaReq()").html("<i class='fas fa-save'></i>");
    $(".modal .btn-secondary").hide();
}

function sugerirTemaReq() {
    data = {
        url: URLBASE + SERVER,
        id: $("#txNome").val(),
        f: "sugerirTema"
    }
    $.get(data.url,data,failsafe);
}

function failsafe(result) {
    if(isValid(result)) {
        window.location.reload()
    } else {
        alert("Ocorreu um erro: "+result.data);
    }
}

function inscreve(result) {
    data = {
        url: URLBASE + SERVER,
        f: "inscreveAdm",
        id: result.data,
        idu: parseUser().id
    }
    $.get(data.url,data,failsafe)
}

function addComunidade() {
    data = {
        url: URLBASE + SERVER,
        f: "addComunidade",
        txNome: $("#txNome").val(),
        txDescricao: $("#txDescricao").val(),
        selectIdTema: $("#selectIdTema").val(),
        selectIdEntrada: $("#selectIdEntrada").val()
    }
    $.get(data.url,data,inscreve)
    return data;
}

function modalAddComunidade() {
    $(".modal .modal-body").html("");
    $(".modal .modal-title").text("Modal title");
    $(".modal").modal('show');
    $(".modal .modal-title").text("Criando nova Comunidade");
    $(".modal .modal-body").append("Nome: <input type='text' class='form-control' id='txNome' maxlength='100' style='width: auto; display: inline-block;' ><br>")
    $(".modal .modal-body").append("Descrição: <input type='text' class='form-control' id='txDescricao' maxlength='180' style='width: auto; display: inline-block;'><br>")
    $(".modal .modal-body").append("Tema: <select name='selectIdTema' id='selectIdTema' class='form-control' style='display: inline-block; width: auto;'></select>&nbsp;<button class='btn btn-light' data-toggle='tooltip' data-placement='bottom' title='Tema escolhido para a comunidade' onclick='sugerirTema()'><i class='far fa-question-circle'></i>&nbsp;Sugerir tema</button><br>");
    $.ajax({
        url: URLBASE + "gateway/getJSON.php?f=loadTema",
        global: true,
        type: "GET",
        dataType: 'json',
        async: false,
        success: function(result) {
            var index;
            for(index =0; index < result.data.length; ++index){
                    option = document.createElement("option");
                    option.value = result.data[index].id;
                    option.innerHTML = result.data[index].nome;
                    $("#selectIdTema").append(option);
            };
        }
    });
    $(".modal .modal-body").append("Privacidade: <select name='selectIdEntrada' id='selectIdEntrada' class='form-control' style='display: inline-block; width: auto;'></select>&nbsp;<button class='btn btn-light' data-toggle='tooltip' data-placement='bottom' title='Forma que os membros poderam entrar'><i class='far fa-question-circle'></i></button><br>");
    $.ajax({
        url: URLBASE + SERVER + "?f=loadEntrada",
        global: true,
        type: "GET",
        dataType: 'json',
        async: false,
        success: function(result){
            var index;
            for(index=0;index < result.data.length; ++index) {
                $("#selectIdEntrada").append('<option value="'+result.data[index].id+'">'+result.data[index].nome+'</option>');
            }
        }
    });
    $(".modal .btn-primary").hide();
    $(".modal .btn-success").show().text("Criar").off().click(addComunidade);
}