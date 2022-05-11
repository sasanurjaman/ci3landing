<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('./application/third_party/dompdf/autoload.inc.php');
use Dompdf\Dompdf;

class Pdfgenerator {
	public function generate($html, $filename='', $stream=TRUE, $paper='A4', $orientation='portrait')
	{
		$options = new \Dompdf\Options();
		$options->setIsRemoteEnabled(true);

		$dompdf = new DOMPDF($options);
		$dompdf->loadHtml($html);
		$dompdf->setPaper($paper, $orientation);
		$dompdf->render();
		if ($stream) {
			$dompdf->stream($filename.'.pdf');
		} else {
			return $dompdf->output();
		}
	}
}
?>