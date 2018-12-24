<!DOCTYPE html>
<html>
	<head>
		<?php include("./res/common/head.php"); ?>
		<script src="./js/loadEventoChat.js"></script>
	</head>
	<body>
		<?php include("./res/common/nav.php"); ?>
		<main class="container" role="main" style="margin-top: 71px; padding-top: 10px;">
		<div class="jumbotron" style="background-color: #e30613;">
			<h1 class="display-4">Nome do Evento</h1>
			<h3>25/12/2018 23:59</h3>
			<h4>Quadra da ETEC Fernando Prestes</h6>
			<h5>Rua Natal, 340 - Jd. Paulistano - Sorocaba</h5>
			<h6>Organizado por: Unidade 016</h6>
		</div>
		<?php include("./res/common/evento-nav.php"); ?>
			<h1>Publicações dos administradores</h1>
			<div class="container post" data-id="1">
				<a href="profile.php?id-15">
					<img src="./css/user.png" class="user-icon">Alberto Benedito de Morais Trevisan
				</a>
				<br />
				<textarea class="form-control-plaintext" readonly width="100vh">Edelson é demais! sz</textarea>
				<button class="hitbox" onclick="likePost(1);" data-id="1">
					<img class="hitpic" src="./vendor/custom-icons/like.png">10
				</button>
				<button class="hitbox" onclick="deslikePost(1);" data-id="1">
					<img class="hitpic" src="./vendor/custom-icons/deslike.png">10
				</button>
				<button class="hitbox comment" onclick="montaModal(1)">
					<img class="hitpic" src="./vendor/custom-icons/comment.png">
				</button>
			</div>
			<br>
			<h1>Publicações dos membros</h1>
			<div class="container post" data-id="1">
                                <a href="profile.php?id-15">     
                                        <img src="./css/user.png" class="user-icon">Alberto Benedito de Morais Trevisan
                                </a>
                                <br />
                                <textarea class="form-control-plaintext" readonly width="100vh">Edelson é demais! sz</textarea>
                                <button class="hitbox" onclick="likePost(1);" data-id="1">
                                        <img class="hitpic" src="./vendor/custom-icons/like.png">10
                                </button>
                                <button class="hitbox" onclick="deslikePost(1);" data-id="1">
                                        <img class="hitpic" src="./vendor/custom-icons/deslike.png">10
                                </button>  
                                <button class="hitbox comment" onclick="montaModal(1)">
                                        <img class="hitpic" src="./vendor/custom-icons/comment.png">
                                </button>
                        </div>
			<h1>Galeria de fotos</h1>
			<div id="carouselGaleria" class="carousel slide" data-ride="carousel" height="100px">
				<ol class="carousel-indicators">
					<li data-target="#carouselGaleria" data-slide-to="0" class="active"></li>
					<li data-target="#carouselGaleria" data-slide-to="1"></li>
					<li data-target="#carouselGaleria" data-slide-to="2"></li>
					<li data-target="#carouselGaleria" data-slide-to="3"></li>
				</ol>
				<div class="carousel-inner">
					<div class="carousel-item active">
						<img class="d-block w-100" src="./photo/IMG201811020024.jpg" alt="Primeira imagem">
					</div>
					<div class="carousel-item">
						<img class="d-block w-100" src="./photo/IMG201810141943.jpg" alt="Segunda imagem">
					</div>
					<div class="carousel-item">
						<img class="d-block w-100" src="./photo/IMG201810141520.jpg" alt="Terceira imagem">
					</div>
					<div class="carousel-item">
						<img class="d-block w-100" src="./photo/IMG201811152232.jpeg" alt="Quarta imagem">
					</div>
				</div>
				<a class="carousel-control-prev" href="#carouselGaleria" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next" href="#carouselGaleria" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</main>
		<?php include("./res/common/modal.php"); ?>
	<!--
		Discussão:
        	    - Publicações dos Administradores
	            - Publicações dos perseguidores
        	    - Galeria
	-->
	</body>
</html>
