<?php

use App\Infra\Database;

// Recupera dados para o dropdown de espécies de peixes
$searchAll = Database::getInstance()->getSearchAll();

// Função para obter dados do gráfico com base na espécie selecionada
function getChartData($name)
{
    return Database::getInstance()->createTableStatistics($name);
}

// Inicializa os dados do gráfico
$chartData = [];
$selectedFish = '';

// Verifica se uma espécie foi selecionada
if (isset($_GET['fish']) && !empty($_GET['fish'])) {
    $selectedFish = $_GET['fish'];
    $chartData = getChartData($selectedFish);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">

    <!-- Importa Google Charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            // Dados para o gráfico de pizza (Superfamília)
            var chartData = <?php echo json_encode($chartData); ?>;
            var dataArray = [
                ['Superfamily', 'Count']
            ];

            chartData.forEach(function(row) {
                dataArray.push([row.superfamily_name, parseInt(row.count)]);
            });

            var data = google.visualization.arrayToDataTable(dataArray);

            var options = {
                title: 'Distribuição de Elementos Transponíveis por Superfamília',
                legend: 'none',
                pieSliceText: 'label',
                width: 600,
                height: 400
            };

            var pieChart = new google.visualization.PieChart(document.getElementById('piechart_superfamily'));
            pieChart.draw(data, options);
        }

        // Atualiza o gráfico ao selecionar uma nova espécie
        function updateChart() {
            var select = document.getElementById('fish_select');
            var selectedValue = select.value;

            if (selectedValue) {
                window.location.search = 'fish=' + encodeURIComponent(selectedValue);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            var select = document.getElementById('fish_select');
            select.addEventListener('change', updateChart);
        });
    </script>
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
                    <a class="font-m-ru color-w01" href="/downloads"><span class="nav-link font-m-ru color-w01">Downloads</span></a>
                </li>
                <li class="nav-list-item">
                    <a class="active-page font-m-ru color-w01" href="/statistics"><span class="nav-link font-m-ru color-w01">Statistics</span></a>
                </li>
                <li class="nav-list-item">
                    <a class="font-m-ru color-w01" href="/blast"><span class="nav-link font-m-ru color-w01">Blast</span></a>
                </li>
                <li class="nav-list-item">
                    <a class="font-m-ru color-w01" href="/team"><span class="nav-link font-m-ru color-w01">Team</span></a>
                </li>
            </ul>
        </nav>
        <div class="page-main-title font-m-r">
            <h1>Project Lorfish</h1>
        </div>
    </header>

    <main>
        <form class="search-form-statistic">
            <label for="fish_select">Select a Fish Species:</label>
            <select id="fish_select" name="fish">
                <option value="">Select...</option>
                <?php foreach ($searchAll as $row): ?>
                    <option value="<?php echo htmlspecialchars($row['scientific_name_fish']); ?>" <?php echo $row['scientific_name_fish'] === $selectedFish ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($row['scientific_name_fish']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <!-- Div para o gráfico de pizza -->
        <?php if ($selectedFish): ?>
            <div id="piechart_superfamily" style="width: 600px; height: 400px; margin: auto;"></div>
        <?php endif; ?>
    </main>
</body>

</html>