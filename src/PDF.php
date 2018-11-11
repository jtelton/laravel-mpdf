<?php

namespace Praem90\PDF;

use \Mpdf\Mpdf;

/**
 * mPDF handler for generating invoice
 */
class PDF 
{
    /**
    * mPDF Instance
    */
    protected $mPdf;

    public function __construct()
    {
        $this->mPdf = new Mpdf(['mode' => 'utf-8', 
                                'format' => 'A4', 
                                'orientation' => 'P']);
        $this->mPdf->SetDisplayMode('fullpage');
        $this->mPdf->list_indent_first_level = 0;
    }

    public function loadView($view, $data)
    {
        $this->mPdf->WriteHTML(view($view, $data)->render());
        return $this;
    }

    public function stream($name = 'file.pdf')
    {
        return $this->mPdf->Output($name, \Mpdf\Output\Destination::STRING_RETURN);
    }

    public function download($name = 'file.pdf')
    {
        return $this->mPdf->Output($name, \Mpdf\Output\Destination::DOWNLOAD);
    }

    public function loadHtml($html)
    {
        $this->mPdf->WriteHTML($html);
        return $this;
    }

    public function __call($method, $args)
    {
        call_user_func_array([$this->mPdf, $method], $args);
    }
}
