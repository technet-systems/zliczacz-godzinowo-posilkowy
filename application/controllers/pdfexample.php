<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//http://stackoverflow.com/questions/19806462/codeigniter-how-to-create-pdf
class Pdfexample extends MY_Controller{ 
    function __construct() { 
        parent::__construct(); 
        $this->load->model('preschooler_m');
        $this->load->helper('text');

    } 
		
    function show($pr_tr_id, $tr_mo_number, $mo_working_days, $tr_name = FALSE) {
        // Odkodowanie nazwy grupy
        $tr_name = decode($tr_name);
        // /.Odkodowanie nazwy grupy
        
        // Pobranie wszystkich przedszkolaków z przekazanego jako argument metody ID grupy ($pr_tr_id)
        $conditions = array(
            'meal' => 'meal.me_id = preschooler.pr_me_id',
            'stay' => 'stay.st_id = preschooler.pr_st_id'

        );

        $where = array(
            'pr_tr_id' => $pr_tr_id

        );

        $preschoolers = $this->preschooler_m->get_join($conditions, $where);
        // /.Pobranie wszystkich przedszkolaków z przekazanego jako argument metody ID grupy ($pr_tr_id)
        
	$this->load->library('Pdf');
        
        // create new PDF document
        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // set default header data | PDF_HEADER_STRING => tcpdf\config\tcpdf_config.php || tcpdf\tcpdf_autoconfig.php
        if($tr_mo_number <= 4) {
            $se_year = $this->data['se_year'] . ' | "' . $tr_name . '"';
            
        } else if($tr_mo_number > 4 && $tr_mo_number <= 10) {
            $se_year = ++$this->data['se_year'] . ' | "' . $tr_name . '"';
            
        }
        
        if($tr_mo_number == 11) {
            $se_year = '"' . $tr_name . '"';
            
        }
        
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('Wydruk wg. grup - ' . $this->data['months'][$tr_mo_number] . ' ' . $se_year);
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        //define ('PDF_HEADER_STRING', "by Nicola Asuni - Tecnick.com\nwww.tcpdf.org");
        
        $pdf->SetHeaderData('', '', 'Zestawienie odpłatności za wyżywienie ' . $this->data['us_address'], 'za ' . $this->data['months'][$tr_mo_number] . ' ' . $se_year . ' | Ilość dni ' . $mo_working_days);

        // set header and footer fonts
        $pdf->setHeaderFont(Array('dejavusans', '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array('dejavusans', '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        global $l;
        $l = Array();

        // PAGE META DESCRIPTORS --------------------------------------

        $l['a_meta_charset'] = 'UTF-8';
        $l['a_meta_dir'] = 'ltr';
        $l['a_meta_language'] = 'pl';

        // TRANSLATIONS --------------------------------------
        $l['w_page'] = 'strona';

        //if (@file_exists(dirname(__FILE__).'/lang/pol.php')) {
            //require_once(dirname(__FILE__).'/lang/pol.php');
            $pdf->setLanguageArray($l);
        //}

        // ---------------------------------------------------------

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // set font
        $pdf->SetFont('dejavusans', '', 8);

        // add a page
        $pdf->AddPage();

        // set color for text
        $pdf->SetTextColor(0, 0, 0);

        //Write($h, $txt, $link='', $fill=0, $align='', $ln=false, $stretch=0, $firstline=false, $firstblock=false, $maxh=0)

        /**
         * SRC: http://www.tcpdf.org/examples.php => numer 48
         * SRC: http://www.w3schools.com/css/css_table.asp => styling tables
         */
        
        $counter = 1;
          
        $html = '
            <style>
                th {
                    background-color: #4CAF50;
                    color: white;
                    
                }

                th, td {
                    border-bottom: 1px solid #ddd;
                    text-align: right;
                    
                }
                
                tr:nth-child(even) {
                    background-color: #f2f2f2;
                    
                }
            </style>
            <table cellspacing="0" cellpadding="4">
            <tr style="background-color: #DEDEDE; font-weight: bold;">
                <th style="width: 27px;">L.p.</th>
                <th>Nazwisko i imię</th> 
                <th>Numer</th>
                <th>Adres</th>
                <th>Posiłek</th>
                <th>Pobyt</th>
                <th>Il. dni</th>
                <th>Opłata<br>za surowiec</th>
                <th>Opłata<br>za pobyt</th>
                <th>Suma</th>
            </tr>

            ';
        foreach($preschoolers as $preschooler) {
            
            
            if($preschooler->pr_help == 1) {
                $html .= '
                    <tr>
                        <td><b>---</b></td>
                        <td><b>' . $preschooler->pr_lname . ' ' . $preschooler->pr_fname . '</b></td>
                        <td><b>' . $preschooler->pr_number . '</b></td>
                        <td><b>' . $preschooler->pr_address . '</b></td>
                        <td><b>' . $preschooler->me_name . '</b></td>
                        <td><b>' . $preschooler->st_name . '</b></td>
                        <td><b>' . $preschooler->pr_working_days . '</b></td>
                        <td><b>' . str_replace(".", ",", $preschooler->pr_me_cost) . '</b></td>
                        <td><b>---</b></td>
                        <td><b>' . number_format(((($preschooler->pr_me_cost) * $preschooler->pr_working_days) - ($preschooler->pr_refund * $preschooler->pr_absence) + $preschooler->pr_interest), 2, ',', ' ') . '</b></td>
                    </tr>
                    ';
                
            } else {
                $html .= '
                    <tr>
                        <td>' . $counter++ . '</td>
                        <td>' . $preschooler->pr_lname . ' ' . $preschooler->pr_fname . '</td>
                        <td>' . $preschooler->pr_number . '</td>
                        <td>' . $preschooler->pr_address . '</td>
                        <td>' . $preschooler->me_name . '</td>
                        <td>' . $preschooler->st_name . '</td>
                        <td>' . $preschooler->pr_working_days . '</td>
                        <td>' . str_replace(".", ",", $preschooler->pr_me_cost) . '</td>
                        <td>' . str_replace(".", ",", $preschooler->pr_st_cost) . '</td>
                        <td>' . number_format((((($preschooler->pr_me_cost + $preschooler->pr_st_cost)) * $preschooler->pr_working_days) - ($preschooler->pr_refund * $preschooler->pr_absence) + $preschooler->pr_interest), 2, ',', ' ') . '</td>
                    </tr>
                    ';
                
            }
        }
        
        $html .= '</table>';

        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        // ---------------------------------------------------------

        //Close and output PDF document
        //$pdf->Output('example_008.pdf', 'I');
        
        $pdf->Output(convert_accented_characters($this->data['months'][$tr_mo_number]) . '-' . convert_accented_characters($se_year) . '.pdf', 'I');
			
    }
    
    function order_by_alphabet($pr_tr_id, $tr_mo_number, $mo_working_days, $tr_name = FALSE, $pr_se_id) {
        // Odkodowanie nazwy grupy
        $tr_name = decode($tr_name);
        // /.Odkodowanie nazwy grupy
        
        // Pobranie wszystkich przedszkolaków bez względu na ID grupy
        $conditions = array(
            'meal' => 'meal.me_id = preschooler.pr_me_id',
            'stay' => 'stay.st_id = preschooler.pr_st_id'

        );
        
        $where = array(
            'pr_mo_number' => $tr_mo_number,
            'pr_se_id' => $pr_se_id

        );

        $preschoolers = $this->preschooler_m->get_join($conditions, $where);
        // /.Pobranie wszystkich przedszkolaków bez względu na ID grupy (w stosunku do metody 'show' usunięto tablicę $where)
        
	$this->load->library('Pdf');
        
        // create new PDF document
        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // set default header data | PDF_HEADER_STRING => tcpdf\config\tcpdf_config.php || tcpdf\tcpdf_autoconfig.php
        if($tr_mo_number <= 4) {
            $se_year = $this->data['se_year'];
            
        } else if($tr_mo_number > 4 && $tr_mo_number <= 10) {
            $se_year = ++$this->data['se_year'];
            
        }
        
        if($tr_mo_number == 11) {
            $se_year = '"' . $tr_name . '"';
            
        }
        
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('Wydruk wg. alfabetu - ' . $this->data['months'][$tr_mo_number] . ' ' . $se_year);
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        //define ('PDF_HEADER_STRING', "by Nicola Asuni - Tecnick.com\nwww.tcpdf.org");
        
        $pdf->SetHeaderData('', '', 'Zestawienie odpłatności za wyżywienie ' . $this->data['us_address'], 'za ' . $this->data['months'][$tr_mo_number] . ' ' . $se_year . ' | Ilość dni ' . $mo_working_days);

        // set header and footer fonts
        $pdf->setHeaderFont(Array('dejavusans', '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array('dejavusans', '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        global $l;
        $l = Array();

        // PAGE META DESCRIPTORS --------------------------------------

        $l['a_meta_charset'] = 'UTF-8';
        $l['a_meta_dir'] = 'ltr';
        $l['a_meta_language'] = 'pl';

        // TRANSLATIONS --------------------------------------
        $l['w_page'] = 'strona';

        //if (@file_exists(dirname(__FILE__).'/lang/pol.php')) {
            //require_once(dirname(__FILE__).'/lang/pol.php');
            $pdf->setLanguageArray($l);
        //}

        // ---------------------------------------------------------

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // set font
        $pdf->SetFont('dejavusans', '', 6);

        // add a page
        $pdf->AddPage();

        // set color for text
        $pdf->SetTextColor(0, 0, 0);

        //Write($h, $txt, $link='', $fill=0, $align='', $ln=false, $stretch=0, $firstline=false, $firstblock=false, $maxh=0)

        /**
         * SRC: http://www.tcpdf.org/examples.php => numer 48
         * SRC: http://www.w3schools.com/css/css_table.asp => styling tables
         */
        
        $counter = 1;
          
        $html = '
            <style>
                th {
                    background-color: #4CAF50;
                    color: white;
                    
                }

                th, td {
                    border-bottom: 1px solid #ddd;
                    text-align: right;
                    
                }
                
                tr:nth-child(even) {
                    background-color: #f2f2f2;
                    
                }
            </style>
            <table cellspacing="0" cellpadding="4">
            <tr style="background-color: #DEDEDE; font-weight: bold;">
                <th style="width: 27px;">L.p.</th>
                <th>Nazwisko i imię</th> 
                <th>Numer</th>
                <th>Adres</th>
                <th>Posiłki</th>
                <th>Godziny</th>
                <th>Il. dni</th>
                <th>Dzienny koszt posiłku za dany m-c</th>
                <th>Dzienny koszt pobytu za dany m-c</th>
                <th>Liczba nieobecn. w poprzednim m-cu</th>
                <th>Dzienny koszt posiłku w poprzednim m-cu</th>
                <th>Dzienny koszt pobytu w poprzednim m-cu</th>
                <th>Odpis</th>
                <th>Opłata za żywienie minus nieobecności</th>
                <th>Oplata za pobyt minus nieobecności</th>
                <th>Razem bez odsetek</th>
                <th>Odsetki</th>
                <th>Kwota do zapłaty z odsetkami</th>
            </tr>

            ';
        foreach($preschoolers as $preschooler) {
            
            // Wyświetlenie danych w tabelce dla 'miesięcy'
            if($preschooler->pr_help == 1 && $preschooler->pr_mo_number < 11) {
                $html .= '
                    <tr>
                        <td><b>---</b></td>
                        <td><b>' . $preschooler->pr_lname . ' ' . $preschooler->pr_fname . '</b></td>
                        <td><b>' . $preschooler->pr_number . '</b></td>
                        <td><b>' . $preschooler->pr_address . '</b></td>
                        <td><b>' . $preschooler->me_name . '</b></td>
                        <td><b>' . $preschooler->st_name . '</b></td>
                        <td><b>' . $preschooler->pr_working_days . '</b></td>
                        <td><b>' . str_replace(".", ",", $preschooler->pr_me_cost) . '</b></td>
                        <td><b>---</b></td>
                        <td><b>' . number_format(((($preschooler->pr_me_cost) * $preschooler->pr_working_days) - ($preschooler->pr_refund * $preschooler->pr_absence) + $preschooler->pr_interest), 2, ',', ' ') . '</b></td>
                    </tr>
                    ';
                
            } else if($preschooler->pr_help == 0 && $preschooler->pr_mo_number < 11) {
                $html .= '
                    <tr>
                        <td>' . $counter++ . '</td>
                        <td>' . $preschooler->pr_lname . ' ' . $preschooler->pr_fname . '</td>
                        <td>' . $preschooler->pr_number . '</td>
                        <td>' . $preschooler->pr_address . '</td>
                        <td>' . $preschooler->me_name . '</td>
                        <td>' . $preschooler->st_name . '</td>
                        <td>' . $preschooler->pr_working_days . '</td>
                        <td>' . str_replace(".", ",", $preschooler->pr_me_cost) . '</td>
                        <td>' . str_replace(".", ",", $preschooler->pr_st_cost) . '</td>
                        <td>' . $preschooler->pr_absence . '</td>
                        <td>' . $preschooler->pr_me_cost_prev_month . '</td>
                        <td>' . $preschooler->pr_st_cost_prev_month . '</td>
                        <td>' . number_format(($preschooler->pr_refund * $preschooler->pr_absence), 2, ',', ' ') . '</td>
                        <td>' . number_format(($preschooler->pr_working_days * $preschooler->pr_me_cost - $preschooler->pr_absence * $preschooler->pr_me_cost_prev_month), 2, ',', ' ') . '</td>
                        <td>' . number_format(($preschooler->pr_working_days * $preschooler->pr_st_cost - $preschooler->pr_absence * $preschooler->pr_st_cost_prev_month), 2, ',', ' ') . '</td>
                        <td>' . number_format((((($preschooler->pr_me_cost + $preschooler->pr_st_cost)) * $preschooler->pr_working_days) - ($preschooler->pr_refund * $preschooler->pr_absence)), 2, ',', ' ') . '</td>
                        <td>' . number_format(($preschooler->pr_interest), 2, ',', ' ') . '</td>
                        <td>' . number_format((((($preschooler->pr_me_cost + $preschooler->pr_st_cost)) * $preschooler->pr_working_days) - ($preschooler->pr_refund * $preschooler->pr_absence) + $preschooler->pr_interest), 2, ',', ' ') . '</td>
                    </tr>
                    ';
                
            }
            // /Wyświetlenie danych w tabelce dla 'miesięcy'
            
            // Wyświetlenie danych w tabelce dla 'dyżurów'
            if($preschooler->pr_help == 1 && $preschooler->pr_mo_number == 11) {
                $html .= '
                    <tr>
                        <td><b>---</b></td>
                        <td><b>' . $preschooler->pr_lname . ' ' . $preschooler->pr_fname . '</b></td>
                        <td><b>' . $preschooler->pr_number . '</b></td>
                        <td><b>' . $preschooler->pr_address . '</b></td>
                        <td><b>' . $preschooler->me_name . '</b></td>
                        <td><b>' . $preschooler->st_name . '</b></td>
                        <td><b>' . $preschooler->pr_working_days . '</b></td>
                        <td><b>' . str_replace(".", ",", $preschooler->pr_me_cost) . '</b></td>
                        <td><b>---</b></td>
                        <td><b>' . number_format(((($preschooler->pr_me_cost) * $preschooler->pr_working_days) - ($preschooler->pr_refund * $preschooler->pr_absence) + $preschooler->pr_interest), 2, ',', ' ') . '</b></td>
                    </tr>
                    ';
                
            } else if($preschooler->pr_help == 0 && $preschooler->pr_mo_number == 11) {
                $html .= '
                    <tr>
                        <td>' . $counter++ . '</td>
                        <td>' . $preschooler->pr_lname . ' ' . $preschooler->pr_fname . '</td>
                        <td>' . $preschooler->pr_number . '</td>
                        <td>' . $preschooler->pr_address . '</td>
                        <td>' . $preschooler->me_name . '</td>
                        <td>' . $preschooler->st_name . '</td>
                        <td>' . $preschooler->pr_working_days . '</td>
                        <td>' . str_replace(".", ",", $preschooler->pr_me_cost) . '</td>
                        <td>' . str_replace(".", ",", $preschooler->pr_st_cost) . '</td>
                        <td>' . $preschooler->pr_absence . '</td>
                        <td>' . $preschooler->pr_me_cost_prev_month . '</td>
                        <td>' . $preschooler->pr_st_cost_prev_month . '</td>
                        <td>' . number_format(($preschooler->pr_refund * $preschooler->pr_absence), 2, ',', ' ') . '</td>
                        <td>' . number_format(($preschooler->pr_working_days * $preschooler->pr_me_cost - $preschooler->pr_absence * $preschooler->pr_me_cost_prev_month), 2, ',', ' ') . '</td>
                        <td>' . number_format(($preschooler->pr_working_days * $preschooler->pr_st_cost - $preschooler->pr_absence * $preschooler->pr_st_cost_prev_month), 2, ',', ' ') . '</td>
                        <td>' . number_format((((($preschooler->pr_me_cost + $preschooler->pr_st_cost)) * $preschooler->pr_working_days) - (($preschooler->pr_me_cost + $preschooler->pr_st_cost) * $preschooler->pr_absence)), 2, ',', ' ') . '</td>
                        <td>' . number_format(($preschooler->pr_interest), 2, ',', ' ') . '</td>
                        <td>' . number_format((((($preschooler->pr_me_cost + $preschooler->pr_st_cost)) * $preschooler->pr_working_days) - (($preschooler->pr_me_cost + $preschooler->pr_st_cost) * $preschooler->pr_absence) + $preschooler->pr_interest), 2, ',', ' ') . '</td>
                    </tr>
                    ';
                
            }
            // /Wyświetlenie danych w tabelce dla 'dyżurów'
            
        }
        
        $html .= '</table>';

        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        // ---------------------------------------------------------

        //Close and output PDF document
        //$pdf->Output('example_008.pdf', 'I');
        
        $pdf->Output(convert_accented_characters($this->data['months'][$tr_mo_number]) . '-' . convert_accented_characters($se_year) . '_Wszystkie_przedszkolaki.pdf', 'I');
			
    }
		
}