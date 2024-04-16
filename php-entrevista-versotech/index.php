<?php
require 'loader.php';

$userDao = new UserDao($db);
$users = $userDao->getAll();

include_once 'layout/header.php';

?>


<main>


        <section id="Propósito" class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12 text-content">
                    <h1>Bem vindo ao Centro de Cadastro</h1>
                    <h4>Fornecemos uma solução simples e prática para melhorar a gestão interna da sua empresa!
                    </h4>                  
                    <button class="btn"><a href="lista_user.php">Lista de usuários</a></button>
                    </div>                    
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <img src="images/images2.png" alt="" class="img-fluid">
                </div>


            </div>
         </div>
         </section>


        <section class="services-section" id="Serviços">
            <div class="container">
                 <div class="row">

                    <div class="col-lg-6 col-md-12 col-sm-12 services">

                        <div class="row row1">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="card">
                                    
                                    <div class="card-body">
                                        <h4 class="card-title" style= "color:red;">Vermelho</h4>
                                        <p class="card-text">O líder vermelho busca gerar resultados a curto prazo: está sempre controlando e mobilizando a equipe para alcançar as metas estabelecidas. Está pronto para um grande desafio!</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="card">
                                    
                                    <div class="card-body">
                                        <h4 class="card-title" style= "color:#FFA500;">Amarelo</h4>
                                        <p class="card-text">A palavra-chave do líder amarelo é inspiração. Lidera sua equipe com base no seu discurso, sempre motivador. Gosta de demonstrar suas habilidades de liderança em reuniões e treinamentos.</p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row row2">

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="card">
                                    
                                    <div class="card-body">
                                        <h4 class="card-title" style= "color:blue;" >Azul</h4>
                                        <p class="card-text">O líder azul é conservador, metódico e cauteloso. Gosta de manter a ordem e qualidade e lidera a equipe com base em sua credibilidade.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="card">
                                    
                                    <div class="card-body" >
                                        <h4 class="card-title" style= "color:green;" >Verde</h4>
                                        <p class="card-text">O líder verde tem um estilo mais democrático. É incentivador, empático e conciliatório com a equipe, um lider confiável!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
             
                <div class="col-lg-6 col-md-12 col-sm-12 text-content">
                    <h3>Serviços</h3>
                    <h1>Agrupamos os cadastrados das suas lideranças por cores de interesse</h1>
                    <p>Identificar qual estilo de liderança se encaixa cada pessoa ajuda a formar equipes mais coesas e ativas! </p>
                    <div><button class="btn btn-success"><a href="cluster_cores.php">Edite as cores </a></button>
                    </div>
            </div>
        </div>
    </div>


<!-- contact section  -->

    <section class="contact-section" id="Contato">
        <div class="container">

            <div class="row gy-4">

                <h1>Contato</h1>
                <div class="col-lg-6">

                    <div class="row gy-4">
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="bi bi-geo-alt"></i>
                                <h3>Endereço</h3>
                                <p>Av. Princesa Isabel 57,<br>Porto Alegre</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="bi bi-telephone"></i>
                                <h3>Telefone</h3>
                                <p>+51 997635839</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="bi bi-envelope"></i>
                                <h3>Email</h3>
                                <p>danieldasilvacg<br>@gmail.com</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="bi bi-clock"></i>
                                <h3>Horários</h3>
                                <p>Segunda - Sexta<br>9:00AM - 06:00PM</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-6 form">
                    <form action="contact.php" method="POST" class="php-email-form">
                        <div class="row gy-4">

                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                            </div>

                            <div class="col-md-6 ">
                                <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                            </div>

                            <div class="col-md-12">
                                <input type="text" class="form-control" name="subject" placeholder="Subject" required>
                            </div>

                            <div class="col-md-12">
                                <textarea class="form-control" name="message" rows="5" placeholder="Message"
                                    required></textarea>
                            </div>

                            <div class="col-md-12 text-center">
                                <button type="submit" name="submit">Mandar Mensagem</button>
                            </div>

                        </div>
                    </form>

                </div>


            </div>

        </div>
    </section>





</body>
</html>

</main>


<?php include_once 'layout/footer.php'; ?>