<?php
    include('../res/bd.php');
    include('../res/config.php');
    $id = filter_input(INPUT_GET,'id');
    
    $search = "SELECT * FROM aluno_post WHERE id_aluno = '$id' ORDER BY id_post DESC";
    $query = mysqli_query($bd,$search);
    $search_p = "SELECT * FROM aluno WHERE id = '$id'";
    $query_p = mysqli_query($bd,$search_p);
    $aluno = mysqli_fetch_assoc($query_p);
    while($row = mysqli_fetch_assoc($query)) {
        $id_aluno = $row['id_aluno'];
       if($aluno['profile_pic_url'] != ""){
            $prp_pic = URL.$aluno['profile_pic_url'];
        } else {
            $prp_pic = URL.'/css/user.png';
        }
        $nome = $aluno['nome'];
        echo '<div class="container post" data-id="'.$row['id_post'].'">'.PHP_EOL;
        echo'<a style="vertical-align: middle;" href="profile.php?id='.$aluno['id'].'">';
        
        echo '<img class="user-icon" src="'.$prp_pic.'">'.$nome;
        echo '</a><br>';
        echo '<textarea class="form-control-plaintext" width="100vh">'.$row['txpost'].'</textarea>';
        echo '</div>';

        
        
        
    }
    
   