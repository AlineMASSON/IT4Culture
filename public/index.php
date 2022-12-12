<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/reset.css">
    <link rel="stylesheet" href="assets/styles.css">
    <title>IT4Culture</title>
</head>
<body>
    <?php 
        // Connexion BDD

        $configData = parse_ini_file(__DIR__.'/../config.ini');

        try {
            $dbh = new PDO(
                "mysql:host={$configData['DB_HOST']};dbname={$configData['DB_NAME']};charset=utf8",
                $configData['DB_USERNAME'],
                $configData['DB_PASSWORD'],
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)
            );
        }
        catch(\Exception $exception) {
            echo 'Erreur de connexion...<br>';
            echo $exception->getMessage().'<br>';
            echo '<pre>';
            echo $exception->getTraceAsString();
            echo '</pre>';
            exit;
        }
    ?>
    <div class="research">
        <h1 class="research__title">Productions</h1>
            <?php
                // Récupéra rtion de la table productions
                $sqlProductions = '
                    SELECT `id`, `intitule` FROM `productions`;
                ';
                $resultProductions = $dbh->query($sqlProductions)->fetchAll();
            ?>
            <select class="research__values" name="productions" id="productions">
                <?php 
                    foreach ($resultProductions as $production) { 
                        ?>
                        <option value="<?= $production['id'] ?>"><?= $production['intitule'] ?></option>
                        <?php
                    }
                ?>
            </select>
    </div>
    <div class="informations">
        <div class="informations__header">
            <h2 class="header__title">Tosca</h2>
            <h3 class="header__name">Giuseppe Verdi</h3>
            <p class="header__dates">du 11 au 21 janvier 2022</p>
        </div>
        <div class="informations__representations">
            <h2 class="representations__title">Représentations :</h2>
            <p class="representations__date">Mardi 11 janvier à 19h30</p>
            <p class="representations__date">Jeudi 13 janvier à 19h30</p>
            <p class="representations__date">Samedi 11 janvier à 19h30</p>
            <p class="representations__date">Jeudi 20 janvier à 19h30</p>
            <p class="representations__date">Vendredi 21 janvier à 19h30</p>
        </div>
        <div class="informations__cast">
            <h2 class="cast__title">Distribution : <img src="assets/img/person-plus-fill.svg" alt="add performer"> </h2>
            <div class="cast__name">
                <p class="name__character">Tosca</p>
                <p class="name__performer">Marie Lemieux</p>
            </div>
            <div class="cast__name">
                <p class="name__character">Mario Cavaradossi</p>
                <p class="name__performer">Anja Harteros</p>
            </div>
            <div class="cast__name">
                <p class="name__character">Scarpia</p>
                <p class="name__performer">Marcelo Spuente</p>
            </div>
            <div class="cast__name">
                <p class="name__character">Cesare Angelotti</p>
                <p class="name__performer">Luca Salsi</p>
            </div>
        </div>
    </div>
</body>
</html>