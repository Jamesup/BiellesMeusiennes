<?php

namespace Core\Export;

use \HTML2PDF;
use CSanquer\ColibriCsv\CsvWriter;

/**
 * Class DataExporter
 * @package Core\Export
 */
Class DataExporter {

    /**
     * @var
     */
    private $filename;
    /**
     * @var
     */
    private $file_type;
    /**
     * @var string
     */
    private $view = 'default';
    /**
     * @var
     */
    private $Pdf;
    /**
     * @var string
     */
    private $html= '';
    /**
     * @var null
     */
    private $output = null;
    /**
     * @var string
     */
    private $orientation = 'P' ;
    /**
     * @var string
     */
    private $format = 'A4' ;
    /**
     * @var string
     */
    private $lang = 'fr' ;

    /**
     * @param $filename
     * @param $file_type
     * @param null $output
     */
    public function __construct($filename, $file_type, $output = null)
    {
        $this->filename = $filename;
        $this->file_type = $file_type;
        $this->output = $output;
    }


    /**
     * @param $datas
     * @return string
     * @throws \HTML2PDF_exception
     */
    public function getPdf($datas)
    {

        $this->Pdf = new HTML2PDF($this->orientation, $this->format, $this->lang );
        $this->__getPdfView($datas);
        $this->Pdf->pdf->SetDisplayMode('fullpage');
        $this->Pdf->WriteHTML($this->html);
        try {
            $this->Pdf->Output( $this->filename .'.'. $this->file_type, $this->output);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param $datas
     */
    public function getCsv($datas)
    {
        $filePath = $this->filename.'.csv';
        $writer = new CsvWriter(array(
            'delimiter' => ';',
            'enclosure' => '"',
            'encoding' => 'CP1252',
            'eol' => "\r\n",
            'escape' => "\\",
            'bom' => false,
            'translit' => null,
            'first_row_header' => false,
            'trim' => false,
        ));
        $stream = fopen($filePath, 'wb');
        $writer->open($stream);
        $array = json_decode(json_encode($datas), true);
        $writer->writeRows($array);
        $writer->getFileContent();
        $writer->close();
        $maxRead    = 1 * 2048 * 2048;
        $fileSize   = filesize($filePath);
        $fh         = fopen($filePath, 'r');
        $read       = 0;
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . str_replace('../', '', $this->filename).".csv" . '"');
        while (!feof($fh)) {
            echo fread($fh, $maxRead);
        }
        exit;
    }

    /**
     * @param null $orientation
     * @param null $format
     * @param null $lang
     * @param string $view
     * @return $this
     */
    public function setPdfAttributes( $orientation = null, $format = null, $lang = null, $view = "default" )
    {
        $this->view = $view;
        $this->orientation = $orientation;
        $this->format = $format;
        $this->lang = $lang;
        return $this;
    }

    /**
     * @param $datas
     * @return bool|string|void
     */
    public function export( $datas )
    {
        if ( !$datas ) {
            return false;
        } else if ( $this->file_type === "pdf") {
            return $this->getPdf($datas);
        } else if ($this->file_type === "csv") {
            return $this->getCsv($datas);
        }
    }

    /**
     * @param $datas
     * @return string
     */
    private function __getPdfView($datas)
    {
        ob_start();
        extract($datas);
        require('../includes/App/Views/pdf/'. $this->view .'.php');
        $content = ob_get_clean();
        $this->html = $content;
        return $this->html;
    }

}
