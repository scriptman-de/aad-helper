<?php

use App\Helper\CsvHelper;
use App\Helper\TextHelper;
use App\Entity\MergedUserEntity;

include '../vendor/autoload.php';

if (
    isset($_POST['c'])
    && !empty($_POST['c'])
    && $_SERVER['REQUEST_METHOD'] === 'POST'
    && $_POST['c'] === 'convert-classlist'
) {
    $importfile = $_FILES['csv-classlist-file'];
    $domainname = $_POST['domainname'];
    $outputPrefix = $_POST['output-prefix'];

    // domain name sanity
    if (strpos($domainname, "@",) !== 0) {
        $domainname = "@".$domainname;
    }
    if (strlen($domainname) < 5) {
        die("Domainname zu kurz");
    }

    if ($importfile['size'] > 0) {
        // open file for reading
        $fhandle = fopen($importfile['tmp_name'], 'r');

        // read first line
        $firstline = fgetcsv($fhandle, 2048, ";");
        // sanity
        if ($firstline[0] !== "Klasse" || $firstline[1] !== "Vorname" || $firstline[2] !== "Nachname") {
            fclose($fhandle);
            die("Die Datei entspricht nicht den Konventionen. Verarbeitung abgebrochen!");
        }

        $result = [];

        // append header to result array
        $result[] = array_values(CsvHelper::$AADCsvColumns);

        while (!feof($fhandle)) {
            $line = fgets($fhandle, 2048);
            if (strlen($line) < 10) {
                continue;
            }
            // get csv content
            $line = str_getcsv($line, ";");

            // create username
            $username = $line[1].".".$line[2].$domainname;
            $username = str_replace(
                ["ä", "Ä", "ö", "Ö", "ü", "Ü", "ß", " "],
                ["ae", "Ae", "oe", "Oe", "ue", "Ue", "ss", ""],
                $username
            );
            $username = TextHelper::TransliterateText($username);

            // create displayname
            $displayname = $line[2]." ".$line[1];
            $displayname = TextHelper::TransliterateText($displayname);

            // get array elements
            $result[] = [
                $username,
                $line[1],
                $line[2],
                $displayname,
                "",
                $line[0],
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
            ];
        }

        fclose($fhandle);

        CsvHelper::Array2Csv($result, $outputPrefix. "converted.csv");

        exit();
    }
} elseif (
    isset($_POST['c'])
    && !empty($_POST['c'])
    && $_SERVER['REQUEST_METHOD'] === 'POST'
    && $_POST['c'] === 'make-password-pdf'
) {
    $scriptfile = $_FILES['script-output-file'];
    $aadfile = $_FILES['aad-output-file'];
    $result = [];

    // read aad result file to memory/array
    $aadResultCsv = CsvHelper::FileToArray($aadfile['tmp_name'], ';');

    // read importfile line by line
    $fh = fopen($scriptfile['tmp_name'], 'r');
    if($fh === false) {
        die("could not read import file");
    }
    // dispose header line
    fgets($fh);

    while (!feof($fh)) {
        $line = fgets($fh);
        if (str_starts_with($line, "#") || str_starts_with($line, ";") || trim($line) === "") {
            continue;
        }

        // create MergedUserEntity
        $result[] = MergedUserEntity::crateByCsvLine($line, $aadResultCsv);

        // save to result
    }

    // clone file handle
    fclose($fh);

    // generate/output PDF
    $pdf = new \App\Pdf\AadPdf();
    $filename = date("Ymd") . "-AAD-Passwort.pdf";
    $pdf->createPdf($filename, $result);

    die();
    // add password file structure
    // Anzeigename, Benutzername, Kennwort, Lizenzen
} else {
    ?>
    <!doctype html>
    <html lang="de-DE">
    <head>
        <meta charset="UTF-8">
        <title>Azure AD Helper by Scriptman.de</title>
        <link rel="apple-touch-icon" sizes="180x180" href="/image/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/image/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/image/favicon-16x16.png">
        <link rel="manifest" href="/image/site.webmanifest">
        <link rel="mask-icon" href="/image/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#2d89ef">
        <meta name="theme-color" content="#ffffff">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-fork-ribbon-css/0.2.3/gh-fork-ribbon.min.css" />
        <link rel="stylesheet" href="/fonts/fira/fira.css"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/darkly/bootstrap.min.css"
              integrity="sha384-nNK9n28pDUDDgIiIqZ/MiyO3F4/9vsMtReZK39klb/MtkZI3/LtjSjlmyVPS3KdN"
              crossorigin="anonymous">
        <style>
            html {
                position: relative;
                min-height: 100%;
            }
            body {
                font-family: 'Fira Sans', sans-serif;
                /* Margin bottom by footer height */
                margin-bottom: 60px;
            }
            .footer {
                position: absolute;
                bottom: 0;
                width: 100%;
                /* Set the fixed height of the footer here */
                height: 60px;
                line-height: 60px; /* Vertically center the text there */
                background-color: #f5f5f5;
            }
            table, tr, td {
                border: 1px solid black;
            }
        </style>
    </head>
    <body>
    <a class="github-fork-ribbon" href="https://github.com/scriptman-de" data-ribbon="Fork me on GitHub" title="Fork me on GitHub" target="_blank">Fork me on GitHub</a>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-1">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Azure AD Helper by Scriptman.de</a>
        </div>
        </div>
    </nav>
    <main>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#step-1">1. CSV-Export anpassen</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#step-2">2. Password-PDF generieren</a>
            </li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade show active" id="step-1">
                <div class="container">
                    <h1>Exportierte CSV-Datei der Schule einlesen</h1>
                    <p>
                        Format der CSV ist:<br>
                    </p>
                    <p>
                        <code class="bg-white p-2">Klasse;Vorname;Nachname</code>
                    </p>
                    <ul class="text-danger">
                        <li>Die erste Zeile <strong>MUSS</strong> die Feldnamen enthalten (sie wird <u>nicht</u> importiert)
                        </li>
                        <li>Die Datei <span class="text-uppercase"><strong>muss</strong></span> UTF-8 <u>ohne <a
                                        href="https://de.wikipedia.org/wiki/Byte_Order_Mark" target="_blank">BOM</a></u>
                            sein
                        </li>
                        <li>Alle weiteren Felder werden ignoriert!</li>
                    </ul>
                    <br><br>
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="output-prefix">Dateiprefix der Ausgabedatei</label>
                            <input type="text" id="output-prefix" name="output-prefix" class="form-control"
                                   style="font-family: monospace" value="<?php echo date('Ymd'); ?>-importAAD-">
                        </div>
                        <div class="form-group">
                            <label for="domainname">Domainname</label>
                            <input type="text" id="domainname" name="domainname" class="form-control" required
                                   style="font-family: monospace" placeholder="@contoso.onmicrosoft.com">
                        </div>
                        <div class="form-group">
                            <label for="csv-classlist-file">Importdatei</label>
                            <input type="file" name="csv-classlist-file" id="csv-classlist-file" class="form-control-file"
                                   required>
                        </div>
                        <input type="hidden" name="c" value="convert-classlist">
                        <div class="alert alert-warning">Die Adminconsole kann nur max. 250 User am Stück importieren. Die Datei sollte deshalb nicht mehr Datensätze enthalten.</div>
                        <button type="submit" class="btn btn-primary">Konvertiere Klassenliste</button>
                    </form>
                </div>
            </div>
            <div class="tab-pane fade" id="step-2">
                <div class="container">
                    <h1>AAD Passwortdatei als PDF ausgeben</h1>
                    <p>Hier bitte die Datei aus dem ersten Schritt und die Rückgabedatei der Adminconsole einlesen.</p>
                    <p>Aus beiden Dateien wird eine PDF mit den Datensätzen sortiert nach Klasse und Nachname erzeugt.<br>Diese Dateien können alle Datensätze auf einmal beinhalten. Der Server akzeptiert Dateien mit <?php echo ini_get('post_max_size');?></p>
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="script-output-file">Datei aus letztem Schritt</label>
                            <input type="file" name="script-output-file" id="script-output-file" class="form-control-file"
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="aad-output-file">Passwortdatei aus der Adminconsole</label>
                            <input type="file" name="aad-output-file" id="aad-output-file" class="form-control-file"
                                   required>
                        </div>
                        <input type="hidden" name="c" value="make-password-pdf">
                        <button type="submit" class="btn btn-primary">Konvertiere Klassenliste</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <footer class="footer">
        <div class="container">
            <span class="text-muted">Diese Seite verwendet keine Cookies. Warum auch?</span>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
    </body>
    </html>
    <?php
} /// end else
