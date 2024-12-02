<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="container grid-12">
    <header>
        <nav aria-label="navigation-menu">
            <ul class="nav-list grid">
                <li class="nav-list-item" id="header-logo-title">
                    <a class="color-c05" href="/home" id="logotipo-header">LORFISH</a>
                </li>
                <li class="nav-list-item">
                    <a class="font-m-ru color-c05" href="/home"><span
                            class="nav-link font-m-ru color-w01">Home</span></a>
                </li>
                <li class="nav-list-item">
                    <a class="font-m-ru color-w01" href="/search"><span
                            class="nav-link font-m-ru color-w01">Search</span></a>
                </li>
                <li class="nav-list-item">
                    <a class="font-m-ru color-w01" href="/downloads"><span
                            class="nav-link font-m-ru color-w01">Downloads</span></a>
                </li>
                <li class="nav-list-item">
                    <a class="font-m-ru color-w01" href="/statistics"><span
                            class="nav-link font-m-ru color-w01">Statistics</span></a>
                </li>
                <li class="nav-list-item">
                    <a class="active-page font-m-ru color-w01" href="/blast"><span
                            class="nav-link font-m-ru color-w01">Blast</span></a>
                </li>
                <li class="nav-list-item">
                    <a class="font-m-ru color-w01" href="/team"><span
                            class="nav-link font-m-ru color-w01">Team</span></a>
                </li>
            </ul>
        </nav>
        <div class="page-main-title font-m-r color-c05">
            <h1 class="">Blast</h1>
        </div>
    </header>
    <main id="blast-main">
        <form class="blast-form" action="/blast" method="POST"> <!-- Mudança para POST -->
            <div id="enterFasta-container">
                <label class="label" for="blast-textarea">Enter Fasta Format</label>
                <textarea class="input" name="fasta" id="blast-textarea"></textarea>
            </div>

            <div id="program-container">
                <label class="label" for="blast-program-select">Program</label>
                <select name="program" id="blast-program-select">
                    <option value="blastn">BLASTN</option>
                    <option value="blastp">BLASTP</option>
                    <!-- Adicione outras opções conforme necessário -->
                </select>
            </div>

            <div id="options-container">
                <label class="label" for="blast-filter-checkbox">Filter</label>
                <input id="blast-filter-checkbox" type="checkbox" name="filter" />
            </div>

            <div id="container-expect">
                <label class="label" for="blast-expect-select">Expect</label>
                <select name="expect" id="blast-expect-select">
                    <option value="0.001">0.001</option>
                    <option value="0.01">0.01</option>
                </select>
            </div>

            <div id="container-alignments">
                <label class="label" for="blast-alignments-select">Alignments</label>
                <select name="alignments" id="blast-alignments-select">
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>

            <button type="submit" class="button">Search</button>
        </form>


    </main>
</body>

</html>