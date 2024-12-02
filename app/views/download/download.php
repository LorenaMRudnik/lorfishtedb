<?php

use App\Infra\Database;

// Recupera os dados para as opções do formulário
$searchAll = Database::getInstance()->getSearchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>
    <header>
        <nav aria-label="navigation-menu">
            <ul class="nav-list grid">
                <li class="nav-list-item" id="header-logo-title">
                    <a class="color-c05" href="/home" id="logotipo-header">LORFISH</a>
                </li>
                <li class="nav-list-item">
                    <a class="font-m-ru color-c05" href="/home"><span class="nav-link font-m-ru color-w01">Home</span></a>
                </li>
                <li class="nav-list-item">
                    <a class="font-m-ru color-w01" href="/search"><span class="nav-link font-m-ru color-w01">Search</span></a>
                </li>
                <li class="nav-list-item">
                    <a class="active-page font-m-ru color-w01" href="/downloads"><span class="nav-link font-m-ru color-w01">Downloads</span></a>
                </li>
                <li class="nav-list-item">
                    <a class="font-m-ru color-w01" href="/statistics"><span class="nav-link font-m-ru color-w01">Statistics</span></a>
                </li>
                <li class="nav-list-item">
                    <a class="font-m-ru color-w01" href="/blast"><span class="nav-link font-m-ru color-w01">Blast</span></a>
                </li>
                <li class="nav-list-item">
                    <a class="font-m-ru color-w01" href="/team"><span class="nav-link font-m-ru color-w01">Team</span></a>
                </li>
            </ul>
        </nav>
        <div class="page-main-title font-m-r color-c05">
            <h1 class="">Downloads</h1>
        </div>
    </header>

    <main class="results-main grid">
        <?php foreach ($searchAll as $s): ?>
            <div class="grid results-main-fish" aria-label="fish specie">
                <h4 class="font-b-mic color-c08"><?= htmlspecialchars($s['scientific_name_fish']) ?></h4>
                <ul class="grid">
                    <li><a class="button font-m-m" href="/files/fasta/<?= urlencode($s['scientific_name_fish']) ?>.fasta" download>FASTA</a></li>
                    <li><a class="button font-m-m" href="/files/gff/<?= urlencode($s['scientific_name_fish']) ?>.gff" download>GFF</a></li>
                    <li><a class="button font-m-m" href="/statistics?fish=<?= urlencode($s['scientific_name_fish']) ?>">Statistics</a></li>
                </ul>

            </div>
        <?php endforeach; ?>
    </main>
</body>

</html>