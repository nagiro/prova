<?php
//Esta clase se usa para generar las domiciliaciones en formato AEB19
//Vamos a tener un array para la cabecera de presentador, otro para la del ordenante (que pueden ser varios)
//otro de registros individuales obligatorios, otro de opcionales, otro del total ordenante (pueden ser varios) y
//otro del total general; las longitudes de las subzonas, junto con otras propiedades, las almacenamos en arrays aparte
//Esos arrays de propiedades contendrán: longitud y relleno (el caracter de relleno, espacio, 0...)
class HTML2PDF{

    private $url_gen;
    private $url_pdf;

    public function __construct()
    {                
        $this->pdf_gen  = OptionsPeer::getString( 'SF_HTML_TO_PDF_EXEC' , 1 );
    }

    public function doPdf($html)
    {
        
        // Run wkhtmltopdf
        $descriptorspec = array(
            0 => array('pipe', 'r'), // stdin
            1 => array('pipe', 'w'), // stdout
            2 => array('pipe', 'w'), // stderr
        );
        
        $process = proc_open($this->pdf_gen.' -q - -', $descriptorspec, $pipes);
        
        // Send the HTML on stdin
        fwrite($pipes[0], utf8_decode($html));
        fclose($pipes[0]);
        
        // Read the outputs
        $pdf = stream_get_contents($pipes[1]);
        $errors = stream_get_contents($pipes[2]);
        
        // Close the process
        fclose($pipes[1]);
        $return_value = proc_close($process);
        
        // Output the results
        if ($errors) {
            // Note: On a live site you should probably log the error and give a
            // more generic error message, for security
            echo 'PDF GENERATOR ERROR:<br />' . nl2br(htmlspecialchars($errors));
            
        } else {
            header('Content-Type: application/pdf');
            header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
            header('Pragma: public');
            header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s').' GMT');
            header('Content-Length: ' . strlen($pdf));
            header('Content-Disposition: inline; filename="' . $filename . '";');
            echo $pdf;
        }
    }
}