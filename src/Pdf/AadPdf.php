<?php

namespace App\Pdf;

use App\Entity\MergedUserEntity;

class AadPdf extends \TCPDF
{
    const BASE_FONT = 'times';
    const ENTRIES_PER_PAGE = 12;


    public function __construct(
        string $orientation = 'P',
        string $unit = 'mm',
        string $format = "A4",
        bool   $unicode = true,
        string $encoding = "UTF-8",
        bool   $diskcache = false,
        bool   $pdfa = true
    )
    {
        parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);

        // metadata
        $this->SetCreator("PDF-Creator by scriptman.de");
        $this->SetAuthor('Martin Aulenbach');
        $this->SetTitle("Azure Active Directory Passwortbrief");

        // base settings
        $this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $this->SetMargins(25, 5, 15);
        $this->SetAutoPageBreak(true, 10);
        $this->SetFooterMargin(PDF_MARGIN_FOOTER);
        $this->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $this->SetFont(self::BASE_FONT, '', 11, '', true);
    }

    public function Header()
    {
        return;
    }

    public function Footer()
    {
        $this->setFontSize(6);
        $this->Cell(0, 10, "aad-helper by scriptman.de ©2021 Martin Aulenbach");
        $this->setFontSize(11);
    }

    public function createPdf(string $filedest, array &$entries):void
    {
        $counter = 0;

        $this->AddPage('P', 'A4');

        /** @var MergedUserEntity $entry */
        foreach ($entries as $entry) {
            if ($counter == self::ENTRIES_PER_PAGE) {
                $counter = 0;
                $this->AddPage('P', 'A4');
            }

            $this->ResetFont();
            $this->Write(0, "Microsoft 365 Zugangsdaten für:  ");
            $this->SetFontBold();
            $this->Write(0, $entry->getFirstName() . " " . $entry->getSurName(), ln: true);
            $this->ResetFont();

            $this->Cell(40, 0, "Anmeldename:");
            $this->Cell(60, 0, $entry->getUsername());
            $this->setX(170);
            $this->Write(0, $entry->getDepartment(), ln: true);

            $this->Cell(40, 0, "Startpasswort:");
            $this->SetFontMono();
            $this->Cell(60, 0, $entry->getPassword(), ln: true);
            $this->ResetFont();

            $this->Ln();
            $this->Ln();

            $counter++;
        }

        $this->Output($filedest, 'D');
    }

    private function ResetFont(): void
    {
        $this->SetFont(self::BASE_FONT, '');
    }

    private function SetFontBold(): void
    {
        $this->SetFont('', 'B');
    }

    private function SetFontMono(): void
    {
        $this->SetFont(PDF_FONT_MONOSPACED);
    }
}
