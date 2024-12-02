<?php

use App\Infra\Database;
use App\Routes\Router;

// Recupera os dados para as opções do formulário
$searchAll = Database::getInstance()->getSearchAll();
$superfamily = Database::getInstance()->getSuperfamily();
$order = Database::getInstance()->getOrder();
$class = Database::getInstance()->getClass();
$results = [];

// Verifica se o formulário foi enviado e aplica o filtro correspondente
if (isset($_POST['search-radio'])) {
    $filter = $_POST['search-radio']; // Identifica o filtro selecionado (class, order, superfamily)
    $name_fish = $_POST['scientific_name_fish'];

    if ($filter === 'class') {
        $className = $_POST['class_name'];
        $results = Database::getInstance()->createTable($name_fish, 'class', $className);
    } elseif ($filter === 'order') {
        $orderName = $_POST['order_name'];
        $results = Database::getInstance()->createTable($name_fish, 'order', $orderName);
    } elseif ($filter === 'superfamily') {
        $superfamilyName = $_POST['superfamily_name'];
        $results = Database::getInstance()->createTable($name_fish, 'superfamily', $superfamilyName);
    } else {
        echo "Nenhum filtro foi selecionado.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search - LORFISH</title>
    <link rel="stylesheet" href="./CSS/style.css">
</head>

<body id="search-page">
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
                    <a class="active-page font-m-ru color-w01" href="/search"><span class="nav-link font-m-ru color-w01">Search</span></a>
                </li>
                <li class="nav-list-item">
                    <a class="font-m-ru color-w01" href="/downloads"><span class="nav-link font-m-ru color-w01">download</span></a>
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
            <h1>Search</h1>
        </div>
    </header>

    <main class="search-main">
        <form action="/search" method="POST" class="search-form">
            <div class="search-main-container grid">
                <div>
                    <input type="checkbox" name="fish" id="fish">
                    <label class="font2-l-su color-c05" for="fish">Fish</label>
                    <select class="font2-l-r color-c05" name="scientific_name_fish">
                        <?php foreach ($searchAll as $s): ?>
                            <option value="<?= htmlspecialchars($s['scientific_name_fish']) ?>"><?= htmlspecialchars($s['scientific_name_fish']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="search-radionbuttons-container grid">
                    <div>
                        <input type="radio" name="search-radio" value="class" id="class">
                        <label class="font2-l-su color-c05" for="class">Class</label>
                        <select class="font2-l-r color-c05" name="class_name">
                            <?php foreach ($class as $c): ?>
                                <option value="<?= htmlspecialchars($c['class_name']) ?>"><?= htmlspecialchars($c['class_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <input type="radio" name="search-radio" value="order" id="order">
                        <label class="font2-l-su color-c05" for="order">Order</label>
                        <select class="font2-l-r color-c05" name="order_name">
                            <?php foreach ($order as $o): ?>
                                <option value="<?= htmlspecialchars($o['order_name']) ?>"><?= htmlspecialchars($o['order_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <input type="radio" name="search-radio" value="superfamily" id="superfamily">
                        <label class="font2-l-su color-c05" for="superfamily">Superfamily</label>
                        <select class="font2-l-r color-c05" name="superfamily_name">
                            <?php foreach ($superfamily as $sf): ?>
                                <option value="<?= htmlspecialchars($sf['superfamily_name']) ?>"><?= htmlspecialchars($sf['superfamily_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="button">SEARCH</button>
            </div>

        </form>
    </main>

    <!-- Exibe a tabela apenas se houver resultados -->
    <?php if (!empty($results)): ?>
        <section>
            <table>
                <tr class="table-header grid color-w01 font2-b-bu">
                    <th>SPECIE</th>
                    <th>CLASS</th>
                    <th>ORDER</th>
                    <th>SUPERFAMILY</th>
                    <th>CHROMOSOME</th>
                    <th>STRAND</th>
                    <th>START</th>
                    <th>END</th>
                </tr>

                <?php foreach ($results as $result): ?>
                    <tr class="table-row grid color-c05 font2-l-r">
                        <td><?= htmlspecialchars($result['scientific_name_fish']) ?></td>
                        <td><?= htmlspecialchars($result['class_name']) ?></td>
                        <td><?= htmlspecialchars($result['order_name']) ?></td>
                        <td><?= htmlspecialchars($result['superfamily_name']) ?></td>
                        <td><?= htmlspecialchars($result['chromossome_name']) ?></td>
                        <td><?= htmlspecialchars($result['strand'] !== null ? $result['scientific_name_fish'] : '') ?></td>
                        <td><?= htmlspecialchars($result['start_sequence']) ?></td>
                        <td><?= htmlspecialchars($result['end_sequence']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </section>
    <?php else: ?>
        <section>
            <!-- <p class="color-c05">Nenhum resultado encontrado.</p> -->
        </section>
    <?php endif; ?>
</body>

</html>