<?php
    include("../res/bd.php");
    $id = filter_input(INPUT_GET,'id');
    $search = "SELECT * FROM aluno_galeria WHERE id_aluno = '$id'";
    $query = mysqli_query($bd,$search);
    while($row = mysqli_fetch_assoc($query)) {
        $dt = $row['dtpublicacao'];
        echo '<div class="col user-image" align="center">';
        echo '<img src="'.$row['image_url'].'" class="user-image-src" data-id="'.$row['id_foto'].'"><br />';
        echo '<span>'.$row['txlegenda'].'</span><br>';
        echo '<span>'.$dt.'</span>';
        echo '</div>';
    }
    