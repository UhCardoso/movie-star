<?php
include_once("templates/header.php");

include_once("models/User.php");
require_once("dao/UserDAO.php");
require_once("dao/MovieDAO.php");

$user = new User();
$userDao = new UserDAO($conn, $BASE_URL);
$movieDao = new MovieDAO($conn, $BASE_URL);

// verifica se o usuário está autenticado
$userData = $userDao->verifyToken(true);

$userMovies = $movieDao->getMoviesByUserId($userData->id);
?>
<div id="main-container" class="container-fluid">
    <h2 class="section-title">Dashboard</h2>
    <p class="section-description">Adicione ou atualize as informações dos filmes que você enviou</p>
    <div class="col-md-12" id="add-movie-container">
        <a href="<?= $BASE_URL ?>/newmovie.php" class="btn card-btn">
            <i class="fas fa-plus"></i> Adicionar filme
        </a>
    </div>
    <div class="col-md-12" id="movies-dashboard">
        <table class="table">
            <thead>
                <th scope="#">#</th>
                <th scope="#">Titulo</th>
                <th scope="#">Nota</th>
                <th scope="#" class="actions-column">Ações</th>
            </thead>
            <tbody>
                <?php foreach ($userMovies as $movie) : ?>
                    <tr scope="row">
                        <td><?= $movie->id ?></td>
                        <td><a href="<?= $BASE_URL ?>/movie.php?id=<?= $movie->id ?>" class="table-movie-title"><?= $movie->title ?></a></td>
                        <td><i class="fas fa-star"></i> <?= $movie->rating ?></td>
                        <td class="actions-column">
                            <a href="<?= $BASE_URL ?>/editmovie.php?id=<?= $movie->id ?>" class="edit-btn">
                                <i class="far fa-edit"></i> Editar
                            </a>
                            <form action="<?= $BASE_URL ?>/movie_process.php" method="post">
                                <input type="hidden" name="type" value="delete" />
                                <input type="hidden" name="id" value="<?= $movie->id ?>" />
                                <button type="submit" class="delete-btn">
                                    <i class="fas fa-times"></i> Deletar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
include_once("templates/footer.php");
?>