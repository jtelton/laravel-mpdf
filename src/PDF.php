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
                                'orientation' => 'P',
                                'margin_left' => 0,
                                'margin_top' => 25,
                                'margin_right' => 0,
                                'margin_bottom' => 25,
                                'margin_header' => '0',
                                'margin_footer' => '0',
                            ]);
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

    public function SetHTMLHeader($html) 
    {
        $this->mPdf->SetHTMLHeader($html);
        return $this;
    }

    public function SetHTMLFooter($html) 
    {
        $this->mPdf->SetHTMLFooter($html);
        return $this;
    }

    public function SetCSS($file_path) 
    {
        $stylesheet = file_get_contents($file_path);
        $this->mPdf->WriteHTML($stylesheet, 1);
    }

    public function __call($method, $args)
    {
        call_user_func_array([$this->mPdf, $method], $args);
    }
}
