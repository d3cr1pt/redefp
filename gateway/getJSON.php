<?php
$webservice = GET( 'f');
include('../res/bd.php');
if(isset($_GET['id'])) {
    $id = GET( 'id');
}

unset($_GET['url']);

function error($level) {
    error_reporting($level);
}

function GET($param) {
    return filter_input(INPUT_GET,$param);
}

function headerJSON(){
    header('Content-Type: application/json');
}

error(E_ALL);

function loadCursos()
{
    global $bd;
    $array = [];
    $search = "SELECT * FROM curso";
    $query = mysqli_query($bd,$search);
    if($query) {
        while($row = mysqli_fetch_assoc($query))
        {
            $array[]=$row;
        }
        echo json_encode($array);
    } else {
        return "Erro: não foi possível recuperar a lista de cursos";
    }
}

function loadPost($mult = 0) 
{
    
    global $bd;
    $array = [];
    $search = "SELECT * FROM aluno_post ORDER BY id_post DESC LIMIT 50";
    $query = mysqli_query($bd,$search);
    if($query) 
    {
        while($row = mysqli_fetch_assoc($query))
        {
            $array[]=$row;
        }
        echo json_encode($array);
    }
    else
    {
        return "Erro: não foi possível recuperar os posts";
    }
}

function readPost($id,$mult = 0) 
{
    global $bd;
    $array = [];
    $search = "SELECT * FROM comunidade_post WHERE id_comunidade = '$id' ORDER BY id_post DESC LIMIT 20";
    $query = mysqli_query($bd,$search);
    if($query)
    {
        while($row = mysqli_fetch_assoc($query))
        {
            $array[]=$row;
        }
        echo json_encode($array);
    }
    else
    {
        return "400 ERROR";
    }
}

function searchProfile($id)
{
    global $bd;
    $search = "SELECT id,ra,curso,ano,nome,apelido,email,institucional,telefone,profile_pic_url FROM aluno WHERE id = '$id'";
    $query = mysqli_query($bd,$search);
    if($query)
    {
            echo json_encode(mysqli_fetch_assoc($query));
    }
    else
    {
        return "Erro: não foi possível recuperar as informações sobre este usuário";
    }
}

function retornaCurso($id)
{
	global $bd;
	$query = mysqli_query($bd, "SELECT * FROM curso WHERE id='$id'");
	if($query) { $obj = mysqli_fetch_assoc($query); return $obj; }
}

function retornaProfile($id)
{
    global $bd;
    $search = "SELECT id,ra,curso,ano,nome,apelido,email,institucional,telefone,profile_pic_url FROM aluno WHERE id = '$id'";
    $query = mysqli_query($bd,$search);
    if($query)
    {
        while ($row = mysqli_fetch_assoc($query)) {
            $row['curso'] = retornaCurso($row['curso']);
			return $row;
        }
    }
    else
    {
        return "Erro: não foi possível recuperar as informações sobre este usuário";
    }
}

function likePost($id) {
    global $bd;
    $search = "SELECT * FROM aluno_post WHERE id_post = '$id' ";
    $query = mysqli_query($bd,$search);
    if($query){
        $row = mysqli_fetch_assoc($query);
            $like = $row['nlike'] + 1;
            $id = $row['id_post'];
            $search2 = "UPDATE aluno_post SET nlike = '$like' WHERE id_post = '$id' ";
            $query = mysqli_query($bd,$search2);
            if($query) {
                echo "";
            } else {
                echo mysqli_error($bd);
            }
        
    } else {
        echo mysqli_error($bd);
    }
}

function likeComunityPost($id) {
    global $bd;
    $search = "SELECT * FROM comunidade_post WHERE id_post = '$id' ";
    $query = mysqli_query($bd,$search);
    if($query){
        $row = mysqli_fetch_assoc($query);
        $like = $row['nlike'] + 1;
        $id = $row['id_post'];
        $search2 = "UPDATE comunidade_post SET nlike = '$like' WHERE id_post = '$id' ";
        $query = mysqli_query($bd,$search2);
        if($query) {
            echo "";
        } else {
            echo mysqli_error($bd);
        }
    } else {
        echo mysqli_error($bd);
    }
}

function deslikePost($id) {
    global $bd;
    $search = "SELECT * FROM aluno_post WHERE id_post = '$id' ";
    $query = mysqli_query($bd,$search);
    $row = mysqli_fetch_assoc($query);
    $deslike = $row['ndeslike'] + 1;
    $search2 = "UPDATE aluno_post SET ndeslike = '$deslike' WHERE id_post = '$id'";
    $query2 = mysqli_query($bd,$search2);
    if($query2) {
        echo "";
    } else {
        echo mysqli_error($bd);
    }
}

function deslikeComunityPost($id) {
    global $bd;
    $search = "SELECT * FROM comunidade_post WHERE id_post = '$id' ";
    $query = mysqli_query($bd,$search);
    $row = mysqli_fetch_assoc($query);
    $deslike = $row['ndeslike'] + 1;
    $search2 = "UPDATE comunidade_post SET ndeslike = '$deslike' WHERE id_post = '$id'";
    $query2 = mysqli_query($bd,$search2);
    if($query2) {
        echo "";
    } else {
        echo mysqli_error($bd);
    }
}

function salvaComentario($id,$comentario,$usuario) {
    global $bd;
    $search = "INSERT INTO aluno_post_comentario (id_post,id_aluno,txcomentario) VALUES ('$id','$usuario','$comentario')";
    $query = mysqli_query($bd,$search);
    if($query) {
        echo "200 OK";
    } else {
        echo mysqli_error($bd);
    }
}

function salvaComunityComentario($id,$comentario,$usuario) {
    global $bd;
    $search = "INSERT INTO comunidade_post_comentario (id_post,id_aluno,txcomentario) VALUES ('$id','$usuario','$comentario')";
    $query = mysqli_query($bd,$search);
    if($query) {
        echo "";
    } else {
        echo mysqli_error($bd);
    }
}

function salvaPost($id,$comentario)
{
    global $bd;
    $search = "INSERT INTO aluno_post (id_aluno,txpost,nlike,ndeslike) VALUES ('$id','$comentario','0','0')";
    $query = mysqli_query($bd,$search);
    if($query){
        echo "";
    } else {
        echo "400 ERROR";
    }
}

function loadComunity($id)
{
    global $bd;
    $search = "SELECT * FROM comunidade WHERE id='$id'";
    $query = mysqli_query($bd,$search);
    if($query) {
        $info = mysqli_fetch_assoc($query);
        echo json_encode($info);
    } else {
        echo "400 ERROR";
    }
}

function returnComunity($id)
{
    global $bd;
    $search = "SELECT * FROM comunidade WHERE id='$id'";
    $query = mysqli_query($bd,$search);
    if($query) {
        $info = mysqli_fetch_assoc($query);
        return $info;
    } else {
        echo "400 ERROR";
    }
}

function loadComunityPictures($id)
{
	global $bd;
	$array = [];
	$search = "SELECT * FROM comunidade_galeria WHERE id_comunidade = '$id'";
	$query = mysqli_query($bd,$search);
	if($query){
		while($row = mysqli_fetch_assoc($query))
		{
			$array[]=$row;
		}
		echo json_encode($array);
	}
	else
	{
		echo "400 ERROR";
	}
	
}

function loadComunityMembers($id)
{
	global $bd;
	$array = [];
	$search = "SELECT * FROM comunidade_inscrito WHERE id_comunidade = '$id'";
	$query = mysqli_query($bd,$search);
	if($query)
	{
		while($row = mysqli_fetch_assoc($query))
		{
			$array[]=$row;
		}
		echo json_encode($array);
	}
	else
	{
		echo "400 ERROR";
	}
}

function postImage($id,$nome,$arquivo)
{
   global  $bd;
	$search = "INSERT INTO aluno_galeria (id,id_aluno,dtpublicacao,image_url) VALUES (NULL,'$id', '$nome', '". timestamp ()."', '$arquivo')";
	$query = mysqli_query ($bd,$search);
	if($query)
	{
		echo "";
	}
	else
	{
		echo "400 ERROR";
	}
}

function loadImage($id)
{
    global $bd;
    $array = [];
    $search = "SELECT * FROM aluno_galeria WHERE id_aluno = '$id'";
    $query = mysqli_query ($bd,$search);
    {
        while($row = mysqli_fetch_assoc($query))
        {
                $array[]=$row;
        }
        echo json_encode($array);
    }
}

function loadCamisetasTurmas()
{
    global $bd;
    $array = [];
    $search = "SELECT * FROM vendas_produto WHERE type='2'";
    $query = mysqli_query($bd,$search);
    if($query)
    {
        while($row = mysqli_fetch_assoc($query))
        {
            $array[]=$row;
        }
        echo json_encode($array);
    } else {
        echo "400 ERROR";
    }
}

function loadVendedor($id)
{
    global $bd;
    $search = "SELECT * FROM vendas_vendedor WHERE id_vendedor = '$id'";
    $query = mysqli_query($bd,$search);
    if($query)
    {
        
        $obj = mysqli_fetch_assoc($query);
        if($obj['type'] == 0){}
        if($obj['type'] == 1)
        {
            $in = $obj['id_interna'];
            $query = mysqli_query($bd,"SELECT * FROM comunidade WHERE id = '$in'");
            if($query){$obj['vendedor'] = mysqli_fetch_assoc($query);}
            $in = $obj['vendedor']['tema'];
            $query = mysqli_query($bd,"SELECT * FROM comunidade_tema WHERE id = '$in'");
            $obj['vendedor']['tema'] = mysqli_fetch_assoc($query);
            $in = $obj['vendedor']['entrada'];
            $query = mysqli_query($bd,"SELECT * FROM comunidade_entrada WHERE id = '$in'");
            $obj['vendedor']['entrada'] = mysqli_fetch_assoc($query);
            echo json_encode($obj);
        }
        if($obj['type'] == 2){}
        if($obj['type'] == 3){}
    }
    else
    {
        echo "400 ERROR";
    }
}

function expandePost($id)
{
    global $bd;
    $array1 = [];
    $array2 = [];
    $search1 = "SELECT * FROM aluno_post WHERE id_post = '$id'";
    $query1 = mysqli_query($bd,$search1);
    if($query1)
    {
        $search2 = "SELECT * FROM aluno_post_comentario WHERE id_post = '$id'";
        $query2 = mysqli_query($bd,$search2);
        if($query2)
        {
            while($row1 = mysqli_fetch_assoc($query1))
            {
                $row1['aluno'] = retornaProfile($row1['id_aluno']);
                $array1=$row1;
            }
            while($row2 = mysqli_fetch_assoc($query2))
            {
                $row2['aluno'] = retornaProfile($row2['id_aluno']);
                $array2[]=$row2;
            }
            $post = $array1;
            $comentarios = $array2;
            $data = [
                'post' => $post,
                'comentarios' => $array2
            ];
            echo json_encode($data);
        }
        else
        {
            echo "400 ERROR1";
        }
    }
    else
    {
        echo "400 ERROR2";
    }
}

function expandeCPost($id)
{
    global $bd;
    $array1 = [];
    $array2 = [];
    $search1 = "SELECT * FROM comunidade_post WHERE id_post = '$id'";
    $query1 = mysqli_query($bd,$search1);
    if($query1)
    {
        $search2 = "SELECT * FROM comunidade_post_comentario WHERE id_post = '$id'";
        $query2 = mysqli_query($bd,$search2);
        if($query2)
        {
            while($row1 = mysqli_fetch_assoc($query1))
            {
                $row1['aluno'] = retornaProfile($row1['id_aluno']);
                $array1=$row1;
            }
            while($row2 = mysqli_fetch_assoc($query2))
            {
                $row2['aluno'] = retornaProfile($row2['id_aluno']);
                $array2[]=$row2;
            }
            $post = $array1;
            $comentarios = $array2;
            $data = [
                'post' => $post,
                'comentarios' => $array2
            ];
            echo json_encode($data);
        }
        else
        {
            echo "400 ERROR";
        }
    }
    else
    {
        echo "400 ERROR";
    }
}

function loadProdutosTurma()
{
    global $bd;
    $array = [];
    $search = "SELECT * FROM vendas_produtos WHERE type='1' ORDER BY id DESC LIMIT 15";
    $query = mysqli_query($bd,$search);
    if($query)
    {
        while($row=mysqli_fetch_assoc($query))
        {
            $array[]=$row;
        }
        echo json_encode($array);
    }
    else
    {
        echo "400 ERROR";
    }
}

function loadProdutosTurma2()
{
    global $bd;
    $array = [];
    $search = "SELECT * FROM vendas_produtos WHERE type='1' ORDER BY id DESC LIMIT 4";
    $query = mysqli_query($bd,$search);
    if($query)
    {
        while($row=mysqli_fetch_assoc($query))
        {
            $array[]=$row;
        }
        echo json_encode($array);
    }
    else
    {
        echo "400 ERROR";
    }
}

function loadComunitysInscrito($id)
{
    global $bd;
    $array = [];
    $search = "SELECT * FROM comunidade_inscrito WHERE id_aluno = '$id'";
    $query = mysqli_query($bd,$search);
    if($query)
    {
        while($row=mysqli_fetch_assoc($query))
        {
            $row['comunidade'] = returnComunity($row['id_comunidade']);
            $array[]=$row;
        }
        echo json_encode($array);
    }
    else
    {
        echo "400 ERROR";
    }
}

function reservaItem($id,$aluno)
{
    global $bd;
    $query = mysqli_query($bd,"SELECT * FROM vendas_produtos WHERE id = '$id'");
    $obj = mysqli_fetch_assoc($query);
    $vendedor = $obj['vendedor'];
    $query = mysqli_query($bd,"INSERT INTO produtos_reserva (id_produto,id_vendedor,id_comprador,tp_venda) VALUES ('$id','$vendedor','$aluno','2')");
    if($query) { echo ""; } else { echo "400 ERROR"; }
}

function loadProdutosComunidades($id)
{
    global $bd;
    $array = [];
    $query = mysqli_query($bd,"SELECT id_vendedor FROM vendas_vendedor WHERE type = '1' AND id_interna = '$id'");
    if($query) { $obj = mysqli_fetch_assoc($query); $in = $obj['id_vendedor']; }
    $query = mysqli_query($bd,"SELECT * FROM vendas_produtos WHERE id_vendedor = '$in'");
    if($query) { while($row=mysqli_fetch_assoc($query)) { $array[]=$row; } echo json_encode($array); }
}

function retornaLocal($id)
{
    global $bd;
    $query = mysqli_query($bd,"SELECT * FROM local WHERE id_local='$id'");
    if($query){ $obj = mysqli_fetch_assoc($query); return $obj;}
}

function loadLocal()
{
    global $bd;
    $array=[];
    $query = mysqli_query($bd,"SELECT * FROM local");
    if($query){  while($row=mysqli_fetch_assoc($query)) { $array[]=$row; } echo json_encode($array); }
}

function retornaOrganizador($id)
{
    global $bd;
    $query = mysqli_query($bd,"SELECT * FROM organizador WHERE id_organizador='$id'");
    if($query){ $obj = mysqli_fetch_assoc($query); return $obj;}
}

function retornaEventoAvisos($id)
{
    global $bd;
    $array = [];
    $query = mysqli_query($bd, "SELECT * FROM evento_avisos WHERE id_evento = '$id' ORDER BY id_aviso DESC LIMIT 5");
    if($query) { 
        while($row = mysqli_fetch_assoc($query))
        {
			if($row['tp_responsavel'] == 0){
				$row['id_responsavel'] = retornaProfile($row['id_responsavel']);
			}
            $array[]=$row;
        }
        return $array;
    }
}

function retornaEventoPubAdm($id)
{
    global $bd;
    $array = [];
    $query = mysqli_query($bd, "SELECT * FROM evento_pub_adm WHERE id_evento = '$id' ORDER BY id_pub DESC LIMIT 10");
    if($query) { 
        while($row = mysqli_fetch_assoc($query))
        {
			if($row['tp_responsavel'] == 0){
				$row['id_responsavel'] = retornaProfile($row['id_responsavel']);
			}
            $array[]=$row;
        }
        return $array;
    }
}

function retornaEventoPubMem($id)
{
    global $bd;
    $array = [];
    $query = mysqli_query($bd, "SELECT * FROM evento_pub_mem WHERE id_evento = '$id' ORDER BY id_pub DESC LIMIT 10");
    if($query) { 
        while($row = mysqli_fetch_assoc($query))
        {
			if($row['tp_responsavel'] == 0){
				$row['id_responsavel'] = retornaProfile($row['id_responsavel']);
			}
            $array[]=$row;
        }
        return $array;
    }
}

function retornaProduto($id)
{
	global $bd;
	$query = mysqli_query($bd, "SELECT * FROM vendas_produtos WHERE id = '$id'");
	if($query){ return mysqli_fetch_assoc($query); }
}

function retornaVendedor($id)
{
	global $bd;
	$query = mysqli_query($bd, "SELECT * FROM vendas_vendedor WHERE id = '$id'");
	if($query) { return mysqli_fetch_assoc($query); }
}

function retornaVenda($id)
{
	global $bd;
	$query = mysqli_query($bd, "SELECT * FROM vendas_reservas WHERE id_reserva = '$id'");
	if($query){ 
		$obj = mysqli_fetch_assoc($query); 
		$obj['id_produto'] = retornaProduto($obj['id_produto']);
		$obj['id_vendedor'] = retornaVendedor($obj['id_vendedor']);
		return $obj; 
	}
}

function retornaEventoConvite($id)
{
    global $bd;
    $array = [];
    $query = mysqli_query($bd, "SELECT * FROM evento_convite WHERE id_evento = '$id'");
    if($query){
        while($row = mysqli_fetch_assoc($query))
        {
			if($row['tp_convidado'] == 0){
				$row['id_convidado'] = retornaProfile($row['id_convidado']);
			}
			$row['id_venda'] = retornaVenda($row['id_venda']);
            $array[]=$row;
        }
        return $array;
    }
}

function retornaEventoPhotos($id)
{
	global $bd;
	$array = [];
	$query = mysqli_query($bd, "SELECT * FROM evento_photo WHERE id_evento = '$id'");
	if($query){
		while($row = mysqli_fetch_assoc($query))
		{
			$array[]=$row;
		}
		return $array;
	}
}

function retornaEventoPerseguidores($id)
{
	global $bd;
	$array = [];
	$query = mysqli_query($bd, "SELECT * FROM perseguicao WHERE id_perseguido = '$id' AND tp_perseguido = '2'");
	if($query){
		while($row = mysqli_fetch_assoc($query))
		{
			if($row['tp_perseguidor'] == 0){
				$row['id_perseguidor'] = retornaProfile($row['id_perseguidor']);
			}
			$array[]=$row;
			
		}
		return $array;
	}
}

function loadEvento($id)
{
    global $bd;
    $query = mysqli_query($bd,"SELECT * FROM evento WHERE id_evento = '$id'");
    if($query){ $obj = mysqli_fetch_assoc($query);}
    $obj['id_local'] = retornaLocal($obj['id_local']);
    $obj['id_organizador'] = retornaOrganizador($obj['id_organizador']);
    $obj['avisos'] = retornaEventoAvisos($id);
    $obj['pub_adm'] = retornaEventoPubAdm($id);
    $obj['pub_mem'] = retornaEventoPubMem($id);
	$obj['convites'] = retornaEventoConvite($id);
	$obj['perseguidores'] = retornaEventoPerseguidores($id);
	$obj['galeria'] = retornaEventoPhotos($id);
	if(mysqli_error($bd) != ""){
		$obj['error'] = mysqli_error($bd);
	} else {
		$obj['error'] = "FALSE";
	}
    echo json_encode($obj, JSON_PRETTY_PRINT);
}

function retornaEvento($id)
{
    global $bd;
    $query = mysqli_query($bd,"SELECT * FROM evento WHERE id_evento = '$id'");
    if($query){ $obj = mysqli_fetch_assoc($query);}
    $obj['id_local'] = retornaLocal($obj['id_local']);
    $obj['id_organizador'] = retornaOrganizador($obj['id_organizador']);
    $obj['avisos'] = retornaEventoAvisos($id);
    $obj['pub_adm'] = retornaEventoPubAdm($id);
    $obj['pub_mem'] = retornaEventoPubMem($id);
	$obj['convites'] = retornaEventoConvite($id);
	$obj['perseguidores'] = retornaEventoPerseguidores($id);
	$obj['galeria'] = retornaEventoPhotos($id);
	if(mysqli_error($bd) != ""){
		$obj['error'] = mysqli_error($bd);
	} else {
		$obj['error'] = "FALSE";
	}
    return $obj;
}

function loadEventosPerseguidos($id)
{
    global $bd; $array = [];
    $datanow = new DateTime();
    $datanow = $datanow->format("Y-m-d H:i");
	$query = mysqli_query($bd, "SELECT * FROM perseguicao WHERE id_perseguidor = '$id' AND tp_perseguidor = '0' AND tp_perseguido = '2'");
	if($query)
	{
		while($row = mysqli_fetch_assoc($query))
		{
            if($row['dt_evento'] > $datanow) {
                $row['id_perseguidor'] = retornaProfile($row['id_perseguidor']);
                $row['id_perseguido'] = retornaEvento($row['id_perseguido']);
                $array[]=$row;
            }
		}
		echo json_encode($array, JSON_PRETTY_PRINT);
	}
}

function sEditPost($id,$comentario) {
    global $bd;
    $search = "UPDATE aluno_post SET txpost = '$comentario' WHERE id_post='$id'";
    $query = mysqli_query($bd, $search);
    if($query) { echo "200 OK"; } else { echo "400 ERROR"; }
}

function delPost($id) {
    global $bd;
    $search1 = "DELETE FROM aluno_post_comentario WHERE id_post='$id'";
    $query1 = mysqli_query($bd,$search1);
    $search2 = "DELETE FROM aluno_post WHERE id_post='$id'";
    $query2 = mysqli_query($bd,$search2);
    if($query2) { echo ""; } else { echo $search2; }
}

function searchFoto($id){
    global $bd;
    $search = "SELECT * FROM aluno_galeria WHERE id_foto = '$id'";
    $query = mysqli_query($bd,$search);
    if($query) {
        $row=mysqli_fetch_assoc($query);
        $row['id_aluno']=retornaProfile($row['id_aluno']);
        echo json_encode($row,JSON_PRETTY_PRINT);
    }
}

function delFoto($id) {
    global $bd;
    $retrieve = "SELECT * FROM aluno_galeria WHERE id_foto='$id'";
    $quer2 = mysqli_query($bd,$retrieve);
    $search = "DELETE FROM aluno_galeria WHERE id_foto = '$id'";
    $query = mysqli_query($bd,$search);
    $quer = mysqli_fetch_assoc($quer2);
    // delete("uploads/".basename($quer['image_url']));
        unlink("C:/xampp/htdocs/uploads/".basename($quer['image_url']));
    
    
}

function sEditCPost($id,$post)
{
    global $bd;
    $query1 = mysqli_query($bd,"UPDATE aluno_post SET txpost='$post' WHERE id_post='$id'");
}

function retornaProfessor($id) {
    global $bd;
    $query1 = mysqli_query($bd,"SELECT * FROM professores WHERE idprofessores = '$id'");
    $ready = mysqli_fetch_assoc($query1);
    unset($ready['pwsenha_professores']);
    return $ready;
}

function prp_avisos_load()
{
    global $bd;
    $sql = "SELECT * FROM avisos";
    $query1 = mysqli_query($bd,$sql);// ORDER BY idaviso DESC LIMIT 50
    // echo var_dump($query1);
    if($query1){
        $array = array();
        while($row = mysqli_fetch_assoc($query1)) {
            $row['idresponsavel'] = retornaProfessor($row['idresponsavel']);
            $array[]=$row;
        }
        echo json_encode($array,JSON_PRETTY_PRINT);
    }
}

function loadAnotacoes($id) {
    global $bd;
    $query = mysqli_query($bd,"SELECT * FROM notes WHERE idprofessor='$id' ORDER BY id DESC LIMIT 20");
    if($query) {
        $array=[];
        while($row = mysqli_fetch_assoc($query)) {
            $array[]=$row;
        }
        echo json_encode($array,JSON_PRETTY_PRINT);
    }
}

function findAnotacoes($id) {
    global $bd;
    $query = mysqli_query($bd,"SELECT * FROM `notes` WHERE id='$id'");
    if($query) {
        $data = mysqli_fetch_assoc($query);
        echo json_encode($data,JSON_PRETTY_PRINT);
    }
}

function saveAviso($id,$aviso) {
    global $bd;
    $query = mysqli_query($bd,"INSERT INTO avisos (txpost,idresponsavel) VALUES ('$aviso','$id')");
    if($query) { echo "true"; } else { echo "false"; }
}

function deleteNote($id) {
    global $bd;
    $query = mysqli_query($bd,"DELETE FROM notes WHERE id='$id'");
    if($query) { echo "true"; } else { echo "false"; }
}

function saveNote($id,$note){
    global $bd;
    $sql = "INSERT INTO notes (txnotes,idprofessor) VALUES ('$note','$id')";
    $query = mysqli_query($bd,$sql);
    if($query) { echo "true"; } else { echo $sql; }
}

function editNote($id,$note) {
    global $bd;
    $sql = "UPDATE notes SET txnotes='$note' WHERE id='$id'";
    $query = mysqli_query($bd,$sql);
    if($query) { echo "true"; } else { echo $sql; }
}

function loadCalendar($id) {
    global $bd;
    $sql = "SELECT id_reuniao AS id, date_reuniao AS date, title_reuniao AS title, txpost_reuniao AS body, id_local FROM professores_reunioes WHERE id_professor='$id'";
    $query = mysqli_query($bd,$sql);
    if($query) {
        $array=[];
        while($row = mysqli_fetch_assoc($query)) {
            $row['badge']=true;
            $row['title'] = "&nbsp;<button onclick='editEvento(".$row['id'].")' class='btn btn-primary'><i class='fas fa-pencil-alt'></i></button>"."&nbsp;<button onclick='deleteEvento(".$row['id'].")' class='btn btn-danger'><i class='fas fa-trash-alt'></i></button>&nbsp;".$row['title'];
            $row['modal']=true;
            $row['classname']="purple-event";
            $row['footer'] = retornaLocal($row['id_local'])['no_local'];
            unset($row['id_local']);
            $array[]=$row;
            
        }
        echo json_encode($array);
    } else {
        echo "false";
    }
}

function saveReuniao($a,$b,$c,$d,$e) {
    global $bd;
    $sql = "INSERT INTO professores_reunioes (id_professor,title_reuniao,date_reuniao,txpost_reuniao,id_local) VALUES ('$e','$a','$b','$c','$d') ";
    $query = mysqli_query($bd,$sql);
    if($query) { echo "true"; } else { echo "false"; };
}

function deleteReuniao($id) {
    global $bd;
    $sql = "DELETE FROM professores_reunioes WHERE id_reuniao = '$id'";
    $query = mysqli_query($bd,$sql);
    if($query) { echo "true"; } else { echo "false"; }
}

function findReuniao($id) {
    global $bd;
    $sql = "SELECT * FROM professores_reunioes WHERE id_reuniao = '$id'";
    $query = mysqli_query($bd,$sql);
    if($query) { echo json_encode(mysqli_fetch_assoc($query)); } else { echo "false"; }
}

function editReuniao($id,$a,$b,$c) {
    global $bd;
    $sql = "UPDATE professores_reunioes SET title_reuniao='$a', date_reuniao='$b', txpost_reuniao='$c' WHERE id_reuniao = '$id'";
    $query = mysqli_query($bd,$sql);
    if($query) { echo "true"; } else { echo $sql; }
}

function deleteComunidadeEntrada($id,$idaluno)
{
    global $bd;
    $SQL = "DELETE FROM comunidade_inscrito WHERE id_aluno = '$idaluno' AND id_comunidade = '$id'";
    $query = mysqli_query($bd,$SQL);
    if($query) {
        echo "true";
    } else {
        echo $SQL;
    }
}

function salvarTelefone($id,$telefone) 
{
    global $bd;
    $sql = "UPDATE aluno SET telefone='$telefone' WHERE id='$id'";
    $query = mysqli_query($bd,$sql);
    if($query) {
        echo $telefone;
    }
    else {
        echo "false";
    }
}

function deleteFotoPerfil($id) 
{
    global $bd;
    $sql = "UPDATE aluno SET profile_pic_url = '' WHERE id='$id'";
    $query = mysqli_query($bd,$sql);
    if($query) {
        echo "true";
    } else {
        echo "false";
    }
}

function salvaPostComunidade($id,$idc,$post) {
    global $bd;
    $sql = "INSERT INTO comunidade_post (id_aluno,id_comunidade,txpost,nlike,ndeslike) VALUES ('$id','$idc','$post',0,0)";
    $query = mysqli_query($bd,$sql);
    if($query) {
        $response = array (
            "data" => mysqli_insert_id($bd),
            "error" => false,
            "operation" => "comunidade_post->store"
        );
    } else {
        $response = array (
            "data" => mysqli_error($bd),
            "error" => true,
            "operation" => "comunidade_post->store"
        );
    }
    echo json_encode($response,JSON_PRETTY_PRINT);
} 

function deletarPostComunidade($id) {
    global $bd;
    $sql = "DELETE FROM comunidade_post WHERE id_post = '$id'";
    $query = mysqli_query($bd,$sql);
    if($query) {
        $response = [
            "data" => $id,
            "error" => false,
            "operation" => "comunidade_post->delete"
        ];
    } else {
        $response = [
            "data" => mysqli_error($bd),
            "error" => true,
            "operation" => "comunidade_post->delete"
        ];
    }
    echo json_encode($response,JSON_PRETTY_PRINT);
}

function salvarEditarPostComunidade($id,$post) {
    global $bd;
    $sql = "UPDATE comunidade_post SET txpost='$post' WHERE id_post='$id' ";
    $query = mysqli_query($bd,$sql);
    if($query) {
        $response = [
            "data" => $id,
            "error" => false,
            "operation" => "comunidade_post->update"
        ];
    } else {
        $response = [
            "data" => mysqli_error($bd),
            "error" => true,
            "operation" => "comunidade_post->update"
        ];
    }
    echo json_encode($response,JSON_PRETTY_PRINT);
}

function deletarFotoComunidade($id) {
    global $bd;
    $sql = "DELETE FROM comunidade_galeria WHERE id_post='$id'";
    $query = mysqli_query($bd,$sql);
    if($query) {
        $response = [
            "data" => $id,
            "error" => false,
            "operation" => "comunidade_galeria->delete"
        ];
    } else {
        $response = [
            "data" => mysqli_error($bd),
            "error" => true,
            "operation" => "comunidade_galeria->delete"
        ];
    }
    echo json_encode($response);
}

function editComunidadeLegenda($id,$legenda) {
    global $bd;
    $sql = "UPDATE comunidade_galeria SET txlegenda='$legenda' WHERE id_post='$id'";
    $query = mysqli_query($bd,$sql);
    if($query) {
        $response = [
            "data" => $sql,
            "error" => false,
            "operation" => "comunidade_galeria->update"
        ];
    } else {
        $response = [
            "data" => mysqli_error($bd),
            "error" => true,
            "operation" => "comunidade_galeria->update"
        ];
    }
    echo json_encode($response,JSON_PRETTY_PRINT);
}

function removeComunidadeInscrito($id,$cid) {
    global $bd;
    $sql = "DELETE FROM comunidade_inscrito WHERE id_aluno='$id' AND id_comunidade='$cid' ";
    $query = mysqli_query($bd,$sql);
    if($query) {
        $response = [
            "data" => $id,
            "error" => false,
            "operation" => "comunidade_inscrito->delete"
        ];
    } else {
        $response = [
            "data" => mysqli_error($bd),
            "error" => true,
            "operation" => "comunidade_inscrito->delete"
        ];
    }
    echo json_encode($response);
}

function loadComunidadeDetalhes($id) {
    global $bd;
    $sql = "SELECT * FROM comunidade WHERE id='$id'";
    $query = mysqli_query($bd,$sql);
    if($query) {
        $response = [
            "data" => mysqli_fetch_assoc($query),
            "error" => false,
            "operation" => "comunidade->find"
        ];
    } else {
        $response = [
            "data" => mysqli_error($bd),
            "error" => true,
            "operation" => "comunidade-> find"
        ];
    }
    echo json_encode($response);
}

function loadInscrito($id) {
    global $bd;
    $sql = "SELECT * FROM comunidade_inscrito WHERE id_comunidade='$id'";
    $query = mysqli_query($bd,$sql);
    if($query) {
        $data = [];
        while($row = mysqli_fetch_assoc($query)) {
            $row['id_aluno'] = retornaProfile($row['id_aluno']);
            $data[]=$row;
        }
        $response = [
            "data" => $data,
            "error" => false,
            "operation" => "comunidade_inscrito->findAll"
        ];
    } else {
        $response = [
            "data" => mysqli_error($bd),
            "error" => true,
            "operation" => "comunidade_inscrito->findAll"
        ];
    }
    echo json_encode($response,JSON_PRETTY_PRINT);
}

function denunciaMembro($id,$uid,$cid,$txDenuncia) {
    global $bd;
    $sql = "INSERT INTO comunidade_denuncia (id_aluno,id_acusado,id_comunidade,txdenuncia) VALUES ('$id','$uid','$cid','$txDenuncia')";
    $query = mysqli_query($bd,$sql);
    if($query) {
        $response = [
            "data" => mysqli_insert_id($bd),
            "error" => false,
            "operation" => "comunidade_denuncia->insert"
        ];
    } else {
        $response = [
            "data" => mysqli_error($bd),
            "error" => true,
            "operation" => "comunidade_denuncia->insert"
        ];
    }
    echo json_encode($response);
}

function verificaInscricao($id,$cid) {
    global $bd;
    $sql = "SELECT * FROM comunidade_inscrito WHERE id_aluno ='$id' AND id_comunidade = '$cid'";
    $query = mysqli_query($bd,$sql);
    if(mysqli_num_rows($query) > 0) {
        $response = [
            "data" => mysqli_fetch_assoc($query),
            "error" => false,
            "operation" => "comunidade_inscrito->find"
        ];
    } else {
        $response = [
            "data" => mysqli_error($bd),
            "error" => true,
            "operation" => "comunidade_inscrito->find"
        ];
    }
    echo json_encode($response);
}

function estaInscrito($id,$cid) {
    global $bd;
    $sql = "SELECT * FROM comunidade_inscrito WHERE id_aluno ='$id' AND id_comunidade = '$cid'";
    $query = mysqli_query($bd,$sql);
    if(mysqli_num_rows($query) > 0) {
       return true;
    } else {
       return false;
    }
}

function criaInscrito($id,$cid) {
    global $bd;
    $sql = "INSERT INTO comunidade_inscrito (id_aluno,id_comunidade) VALUES ('$id','$cid')";
    $query = mysqli_query($bd,$sql);
    if($query) {
        $response = [
            "data" => mysqli_insert_id($bd),
            "error" => false,
            "operation" => "comunidade_inscrito->create"
        ];
    } else {
        $response = [
            "data" => mysqli_error($bd),
            "error" => true,
            "operation" => "comunidade_inscrito->create"
        ];
    }
    echo json_encode($response);
}

function loadTema(){
    global $bd;
    $sql = "SELECT * FROM comunidade_tema WHERE app = 1";
    $query = mysqli_query($bd,$sql);
    if(mysqli_num_rows($query) > 0) {
        $rows=[];
        while($row=mysqli_fetch_assoc($query)) {
            $rows[]=$row;
        }
        $response = [
            "data" => $rows,
            "error" => false,
            "operation" => "comunidade_tema->findAll"
        ];
    } else {
        $response = [
            "data" => mysqli_error($bd),
            "error" => false,
            "operation" => "comunidade_tema->findAll"
        ];
    }
    echo json_encode($response);
}

function sugerirTema($id) {
    global $bd;
    $sql = "INSERT INTO comunidade_tema (nome,app) VALUES ('$id','0')";
    $query = mysqli_query($bd,$sql);
    if($query) {
        $response = [
            "data" => mysqli_insert_id($bd),
            "error" => false,
            "operation" => "comunidade_tema->insert"
        ];
    } else {
        $response = [
            "data" => mysqli_error($bd),
            "error" => true,
            "operation" => "comunidade_tema->insert"
        ];
    }
    echo json_encode($response);
}

function criaComunidade($nome,$txDescricao,$tema,$entrada) {
    global $bd;
    $sql = "INSERT INTO `comunidade`( `nome`, `txDescricao`, `tema`, `entrada`) VALUES ('$nome','$txDescricao','$tema','$entrada')";
    $query = mysqli_query($bd,$sql);
    if($query) {
        $response = [
            "data" => mysqli_insert_id($bd),
            "error" => false,
            "extradata" => $sql,
            "operation" => "comunidade->create"
        ];
    } else {
        $response = [
            "data" => mysqli_error($bd),
            "error " => true,
            "extradata" => $sql,
            "operation" => "comunidade->create"
        ];
    }
    echo json_encode($response);
}

function loadEntrada() {
    global $bd;
    $sql = "SELECT * FROM comunidade_entrada";
    $query = mysqli_query($bd,$sql);
    if(mysqli_num_rows($query) > 0) {
        $rows = [];
        while($row=mysqli_fetch_assoc($query)) {
            $rows[]=$row;
        }
        $response = [
            "data" => $rows,
            "error" => false,
            "operation" => "comunidade_entrada->findAll"
        ];
    } else {
        $response = [
            "data" => mysqli_error($bd),
            "error" => true,
            "operation" => "comunidade_entrada->findAll"
        ];
    }
    echo json_encode($response);
}

function inscreveComunidade($idc,$idu) {
    global $bd;
    $sql = "INSERT INTO comunidade_inscrito (id_comunidade,id_aluno,is_Adm) VALUES ('$idc','$idu','0')";
    $query = mysqli_query($bd,$sql);
    if($query) {
        $response = [
            "data" => mysqli_insert_id($bd),
            "error" => false,
            "operation" => "comunidade_inscrito->insert"
        ];
    } else {
        $response = [
            "data" => mysqli_error($bd),
            "error" => true,
            "operation" => "comunidade_inscrito->insert"
        ];
    }
    echo json_encode($response);
} 

function inscreveAdm($idc,$idu) {
    global $bd;
    $sql = "INSERT INTO comunidade_inscrito (id_comunidade,id_aluno,is_Adm) VALUES ('$idc','$idu','1')";
    $query = mysqli_query($bd,$sql);
    if($query) {
        $response = [
            "data" => mysqli_insert_id($bd),
            "error" => false,
            "operation" => "comunidade_inscrito->insert"
        ];
    } else {
        $response = [
            "data" => mysqli_error($bd),
            "error" => true,
            "operation" => "comunidade_inscrito->insert"
        ];
    }
    echo json_encode($response);
}

function listComunidades($id) {
    global $bd;
    $sql = "SELECT * FROM comunidade ORDER BY id DESC LIMIT 20";
    $query = mysqli_query($bd,$sql);
    if($query) {
        $rows=[];
        while($row=mysqli_fetch_assoc($query)):
            if(!estaInscrito($id,$row['id'])) {
                $rows[]=$row;
            }
        endwhile;
        $response = [
            "data" => $rows,
            "error" => false,
            "operation" => "comunidade->findAll"
        ];
    } else {
        $response = [
            "data" => mysqli_error($bd),
            "error" => true,
            "operation" => "comunidade->findAll" 
        ];
    }
    echo json_encode($response);
}

function verificaPerseguiçãoUserEvento($eid,$uid) {
    global $bd;
    $sql = "SELECT * FROM perseguicao WHERE tp_perseguido = '2' AND tp_perseguidor = '0' AND id_perseguido = '$eid' AND id_perseguidor='$uid' ";
    $query = mysqli_query($bd,$sql);
    if(mysqli_num_rows($query) > 0) {
        return true;
    } else {
        return false;
    }
}

function listEventos($id) {
    global $bd;
    $datanow = new DateTime();
    $datanow = $datanow->format("Y-m-d H:i");
    $sql = "SELECT * FROM evento ORDER BY id_evento DESC LIMIT 4";
    $query = mysqli_query($bd,$sql);
    if(mysqli_num_rows($query) > 0) {
        $rows=[];
        while($row=mysqli_fetch_assoc($query)) {
            if(!verificaPerseguiçãoUserEvento($row['id_evento'],$id) and $row['dt_evento'] > $datanow) {
                $rows[]=$row;
            }
        }
        $response = [ 
            "data" => $rows,
            "error" => false,
            "operation" => "evento->findAll"
        ];
    } else {
        $response = [ 
            "data" => mysqli_error($bd),
            "error" => true,
            "operation" => "evento->findAll"
        ];
    }
    echo json_encode($response);
}

function loadLocais() {
    global $bd;
    $sql = "SELECT * FROM local";
    $query = mysqli_query($bd,$sql);
    if(mysqli_num_rows($query) > 0) {
        $rows=[];
        while($row=mysqli_fetch_assoc($query)) {
            $rows[]=$row;
        }
        $response = [
            "data" => $rows,
            "error" => false,
            "operation" => "local->findAll"
        ];
    } else {
        $response = [
            "data" => mysqli_error($bd),
            "error" => true,
            "operation" => "local->findAll"
        ];
    }
    echo json_encode($response);
}

function addAlunoEvento($id,$no,$dt,$idl) {
    global $bd;
    $sql = "INSERT INTO aluno_evento (id_organizador,no_evento,dt_evento,id_local) VALUES ('$id','$no','$dt','$idl') ";
    $query = mysqli_query($bd,$sql);
    if($query) {
        $response = [
            "data" => mysqli_insert_id($bd),
            "error" => false,
            "operation" => "aluno_evento->insert"
        ];
    } else {
        $response = [
            "data" => mysqli_error($bd),
            "error" => true,
            "operation" => "aluno_evento->insert"
        ];
    }
    echo json_encode($response);
}

switch($webservice) {
    case "addAlunoEvento":
    {
        headerJSON();
        addAlunoEvento($id,GET("no_evento"),GET("dt_evento"),GET("id_local"));
        break;
    }
    case "loadLocais":
    {
        headerJSON();
        loadLocais();
        break;
    }
    case "carregaNovosEventos":
    {
        headerJSON();
        listEventos($id);
        break;
    }
    case "ComunidadeInscricao":
    {
        headerJSON();
        criaInscrito($id,GET("cid"));
        break;
    }
    case "carregaNovasComunidades":
    {
        headerJSON();
        listComunidades($id);
        break;
    }
    case "inscreveAdm":
    {
        headerJSON();
        inscreveAdm(GET("id"),GET("idu"));
        break;
    }
    case "inscreveComunidade":
    {
        headerJSON();
        inscreveComunidade(GET("json"));
        break;
    }
    case "addComunidade":
    {
        headerJSON();
        criaComunidade(GET("txNome"),GET("txDescricao"),GET("selectIdTema"),GET("selectIdEntrada"));
        break;
    }
    case "sugerirTema":
    {
        headerJSON();
        sugerirTema($id);
        break;
    }
    case "loadEntrada":
    {
        headerJSON();
        loadEntrada();
        break;
    }
    case "criaComunidade":
    {
        headerJSON();
        criaComunidade(GET("json"));
        break;
    }
    case "loadTema":
    {
        headerJSON();
        loadTema();
        break;
    }
    case "verificaInscricao":
    {
        headerJSON();
        verificaInscricao($id,GET('cid'));
        break;
    }
    case "denunciaMembro":
    {
        headerJSON();
        denunciaMembro($id,GET('uid'),GET('cid'),GET('txDenuncia'));
        break;
    }
    case "loadInscritos":
    {
        headerJSON();
        loadInscrito($id);
        break;
    }
    case "loadComunidadeDetalhes":
    {
        headerJSON();
        loadComunidadeDetalhes($id);
        break;
    }
    case "removeComunidadeInscrito":
    {
        headerJSON();
        removeComunidadeInscrito($id,GET('cid'));
        break;
    }
    case "editComunidadeLegenda":
    {
        headerJSON();
        editComunidadeLegenda($id,GET('legendav'));
        break;
    }
    case "deletarFotoComunidade":
    {
        headerJSON();
        deletarFotoComunidade($id);
        break;
    }
    case "salvarEditarPostComunidade":
    {
        headerJSON();
        salvarEditarPostComunidade($id,GET('post'));
        break;
    }
    case "deletarPostComunidade":
    {
        headerJSON();
        deletarPostComunidade($id);
        break;
    }
    case "salvaPostComunidade":
    {
        headerJSON();
        salvaPostComunidade($id,GET('idc'),GET('post'));
        break;
    }
    case "deleteFotoPerfil":
    {
        headerJSON();
        deleteFotoPerfil($id);
        break;
    }
    case "saveTelefone":
    {
        headerJSON();
        salvarTelefone($id,GET('telefone')); 
        break;
    }
    case "deleteComunidadeEntrada":
    {
        headerJSON();
        deleteComunidadeEntrada($id,GET('idaluno'));
        break;
    }
    case "editReuniao":
    {
        headerJSON();
        editReuniao($id,$_GET['a'],$_GET['b'],$_GET['c']);
        break;
    }
    case "findReuniao":
    {
        headerJSON();
        findReuniao($id);
        break;
    }
    case "deleteReuniao":
    {
        headerJSON();
        deleteReuniao($id);
        break;
    
    }
    case "saveReuniao":
    {
        $e = GET('id_professor');
        $a = GET('title_reuniao');
        $b = GET('date_reuniao');
        $c = GET('txpost_reuniao');
        $d = GET('id_local');
        headerJSON();
        saveReuniao($a,$b,$c,$d,$e);
        break;
    }
    case "loadLocal":
    {
        headerJSON();
        loadLocal();
        break;
    }
    case "loadCalendar":
    {
        headerJSON();
        loadCalendar($id);
        break;
    }
    case "editNote":
    {
        $note = GET('input',FILTER_SANITIZE_STRING);
        editNote($id,$note);
        break;
    }
    case "salvarNote":
    {
        $note = GET('input',FILTER_SANITIZE_STRING);
        saveNote($id,$note);
        break;
    }
    case "deleteNote":
    {
        deleteNote($id);
        break;
    }
    case "saveAviso":
    {
        $aviso = GET('input',FILTER_SANITIZE_STRING);
        saveAviso($id,$aviso);
        break;
    }
    case "viewNote":
    {
        headerJSON();
        findAnotacoes($id);
        break;
    }
    case "delFoto":
    {
        delFoto($id);
        break;
    }
    case "searchFoto":
    {
        searchFoto($id);
        break;
    }
    case "delPost":
    {
        delPost($id);
        break;
    }
    case "sEditPost":
    {
        $comentario = GET('comentario');
        sEditPost($id,$comentario);
        break;
    }
    case "reservaItem":
    {
        $aluno = GET( 'aluno');
        reservaItem($id,$aluno);
        break;
    }
    case "loadPC":
    {
        loadProdutosComunidades($id);
        break;
    }
    case "postImage":
    {
        postImage($id,$nome,$arqivo);
        break;
    }
    case "cursos" :
    {
        loadCursos();
        break;
    }
    case "posts":
    {
        loadPost($id);
        break;
    }
    case "one-profile":
    {
        header("Content-Type: application/json");
        searchProfile($id);
        break;
    }
    case "one-comunity":
    {
        loadComunity($id);
        break;
    }
    case "like":
    {
        likePost($id);
        break;  
    }
    case "deslike":
    {
        deslikePost($id);
        break;
    }
    case "comentar":
    {
        $comentario = $_GET['comentar'];
        $usuario = filter_input(1,'usuario',513);
        salvaComentario($id, $comentario,$usuario);
        break;
    }
    case "comunity-comentar":
    {
        $comentario = filter_input(1,'comentar',513);
        $usuario = filter_input(1,'usuario',513);
        salvaComunityComentario($id, $comentario,$usuario);
        break;
    }
    case "post":
    {
        expandePost($id);
        break;
    }
    case "loadPostComunity":
    {
        readPost($id);
        break;
    }
    case "comunity-like":
    {
        likeComunityPost($id);
        break;
    }
    case "comunity-deslike":
    {
        deslikeComunityPost($id);
        break;
    }
    case "comunity-pictures":
    {
        loadComunityPictures($id);
        break;
    }
    case "comunity-members":
    {
        loadComunityMembers($id);
        break;
    }
    case "savePost":
    {
        $comentario = $_GET['post'];
        salvaPost($id, $comentario);
        break;
    }
    case "loadEMCamisa":
    {
        loadCamisetasTurmas();
        break;
    }
    case "one-vendedor":
    {
        loadVendedor($id);
        break;
    }
    case "expandePost":
    {
        expandePost($id);
        break;
    }
    case "expandeCPost":
    {
        expandeCPost($id);
        break;
    }
    case "loadProdutoTurma":
    {
        loadProdutosTurma();
        break;
    }
    case "loadProdutoTurma2":
    {
        loadProdutosTurma2();
        break;
    }
    case "loadComunitysInscrito":
    {
        loadComunitysInscrito($id);
        break;
    }
    case "loadEvento":
    {
        headerJSON();
        loadEvento($id);
        break;
    }
	case "eventoPerseguidos":
	{
		headerJSON();
		loadEventosPerseguidos($id);
		break;
    }
    case "avisosLoad":
    {
        headerJSON();
        prp_avisos_load();
        break;
    }
    case "notesload":
    {
        headerJSON();
        loadAnotacoes($id);
        break;
    }
    default:
    {
        echo "Não foi definido um case";
        break;
    }
}