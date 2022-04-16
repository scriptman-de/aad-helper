<?php
/*
 * @author Martin Aulenbach, 2022
 * @package de.scriptman.aad-parser-php
 */

namespace App\Helper;

class CsvHelper
{
    public static array $AADCsvColumns = [
        "Benutzername",
        "Vorname",
        "Nachname",
        "Anzeigename",
        "Position",
        "Abteilung",
        "Telefon – Geschäftlich",
        "Telefon (geschäftlich)",
        "Mobiltelefon",
        "Fax",
        "Alternative E-Mail-Adresse",
        "Adresse",
        "Ort",
        "Bundesstaat",
        "Postleitzahl",
        "Land oder Region",
    ];

    public static function FileToArray(string $filename, string $separator = ';', bool $skipHeader = true, string $enclosure = '"', string $escape = "\\"): array
    {
        $result = [];

        try {
            // open file
            $fh = fopen($filename, 'r');

            if ($fh === false) {
                throw new \RuntimeException("File could not be opened!");
            }

            if ($skipHeader) {
                fgets($fh);
            }

            while(!feof($fh)) {
                $line = fgets($fh, 2048);

                if(strlen($line) === 0 || str_starts_with($line, ";") || str_starts_with($line, "#")) {
                    continue;
                }

                $result[] = str_getcsv($line, $separator, $enclosure, $escape);
            }
        } catch (\Exception $e){
            // noop
        }

        return $result;
    }

    public static function Array2Csv(array $content, string $filename = 'data.csv', string $separator = ';', string $enclosure = '"', string $escape = "\\")
    {
        ob_start();
        $fh = fopen("php://output", "w");
        foreach ($content as $csvline) {
            fputcsv($fh, $csvline, $separator, $enclosure, $escape);
        }
        fclose($fh);
        $result = ob_get_clean();

        static::renderCsv($result, $filename);
    }

    private static function renderCsv($contents, $filename = 'data.csv')
    {
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        echo $contents;
    }
}
