<!DOCTYPE html>
<html lang="fr">
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
                // Récupération de la table productions
                $sqlProductions = '
                    SELECT `id`, `intitule` FROM `productions`;
                ';
                $resultProductions = $dbh->query($sqlProductions)->fetchAll();
            ?>
            <form method="post" action="" id="productionForm">
                <select class="research__values" name="productions" id="productions">
                    <option value="0" disabled >Rechercher</option>
                    <?php
                        foreach ($resultProductions as $production) {
                            ?>
                            <option <?= count($_POST) !== 0 && strval($_POST['productions'])=== $production['id'] ? "selected" : "" ?> value="<?= $production['id'] ?>"><?= $production['intitule'] ?></option>
                            <?php
                        }
                    ?>
                </select>
            </form>

            <script>
                const productions = document.querySelector('.research__values');
                let productionSelected = "";
                const handleChangeProduction = (event) => {
                    productionSelected = event.target.value
                    console.log(document.querySelector('#productionForm'));
                    document.querySelector('#productionForm').submit();
                };
                productions.addEventListener('change', handleChangeProduction);
            </script>
    </div>
    <div class="informations">
        <div class="informations__header">
            <?php

                $idProduction = intval($_POST['productions']);

                // Récupération des tables productions et productions_date avec l'id de la production selectionnée
                $sqlProductionsDates = '
                    SELECT
                        productions.id,
                        productions.intitule,
                        productions.compositeur,
                        productions_dates.dateHeure
                    FROM `productions`

                    INNER JOIN `productions_dates` ON productions.id = productions_dates.idProduction
                    WHERE productions.id = ' . $idProduction . '
                    ORDER BY productions_dates.dateHeure;
                ';

                $resultProductionsDates = $dbh->query($sqlProductionsDates)->fetchAll(PDO::FETCH_CLASS);

                // Format date pour les représentation
                $fmtMedium = datefmt_create( "fr-FR" ,
                    IntlDateFormatter::FULL,
                    IntlDateFormatter::SHORT,
                    'Europe/Paris',
                    IntlDateFormatter::GREGORIAN
                );

                // Format date pour le header
                $fmtShort = datefmt_create( "fr-FR" ,
                    IntlDateFormatter::LONG,
                    IntlDateFormatter::NONE,
                    'Europe/Paris',
                    IntlDateFormatter::GREGORIAN
                );
                $firstDate = date_format(date_create($resultProductionsDates[0]->dateHeure), 'j');
                $lastDate = datefmt_format($fmtShort , date_create(end($resultProductionsDates)->dateHeure));
            ?>
            <h2 class="header__title"><?= $resultProductionsDates[0]->intitule ?></h2>
            <h3 class="header__name"><?= $resultProductionsDates[0]->compositeur ?></h3>
            <p class="header__dates">du <?= $firstDate?> au <?= $lastDate ?></p>
        </div>
        <div class="informations__representations">
            <h2 class="representations__title">Représentations :</h2>
            <?php
                $year = date_format(date_create($resultProductionsDates[0]->dateHeure), 'Y');
                
                foreach ($resultProductionsDates as $date) {
                    $representationsDate = datefmt_format($fmtMedium , date_create($date->dateHeure));
                    $fmtH = str_replace(':', 'h', $representationsDate);
                    $fmtYear = str_replace($year . ' ', '', $fmtH);
                    ?>
                        <p class="representations__date"><?= $fmtYear ?></p>
                    <?php
                }
            ?>
        </div>
        <div class="informations__cast">
            <h2 class="cast__title">Distribution : <img src="assets/img/person-plus-fill.svg" alt="add performer"> </h2>
            
            <?php 
                // Récupération des tables productions et productions_date avec l'id de la production selectionnée
                $sqlDistribution = '
                    SELECT role, artiste FROM `distribution`
                    WHERE idProduction = ' . $idProduction . ';
                ';

                $resultDistribution = $dbh->query($sqlDistribution)->fetchAll(PDO::FETCH_CLASS);

                foreach ($resultDistribution as $distribution) {
                    ?>
                        <div class="cast__name">
                            <p class="name__role"><?= $distribution->role ?></p>
                            <p class="name__artiste"><?= $distribution->artiste ?></p>
                        </div>

                    <?php
                }
            ?>
        </div>
    </div>
</body>
</html>