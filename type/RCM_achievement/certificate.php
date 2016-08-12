<?php

// This file is part of the Certificate module for Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * A4_embedded certificate type
 *
 * @package    mod
 * @subpackage certificate
 * @copyright  Mark Nelson <markn@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.'); // It must be included from view.php
}


global $CFG;



$pdf = new PDF($certificate->orientation, 'mm', 'A4', true, 'UTF-8', false);

$pdf->SetTitle($certificate->name);
$pdf->SetProtection(array('modify'));
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAutoPageBreak(false, 0);
$pdf->AddPage();

// Define variables
// Landscape
if ($certificate->orientation == 'L') {


    $x = 20;
    $y = 60;
    $rcmx = 20;
    $rcmy = 20;
    $mlgy = 20;
    $mlgx = 120;
    $rlgy = 20;
    $rlgx = 252;
    $addx = 20;
    $addy = 185;
$datx  = 20;
$daty  = 127;
$outx  = 10;
$outy  = 135;
$comx = 20;
$comy = 103;
$modx = 20;
$mody = 115;
$namx = 20;
$namy = 85;
$certifyx = 20;
$certifyy = 75;




    $sealx = 105;
    $sealy = 20;
    $sigx = 125;
    $sigy = 145;
    $custx = 47;
    $custy = 180;
    $wmarkx = 41;
    $wmarky = 31;
    $wmarkw = 212;
    $wmarkh = 148;
    $brdrx = 0;
    $brdry = 0;
    $brdrw = 297;
    $brdrh = 210;
    $codey = 175;
	$credity = 140;


} else { // Portrait
    $x = 10;
    $y = 70;
    $sealx = 165;
    $sealy = 20;
    $rcmx = 20;
    $rcmy = 20;
    $mlgy = 20;
    $mlgx = 80;
    $rlgy = 20;
    $rlgx = 165;

    $addx = 20;
    $addy = 270;
$datx  = 10;
$daty  = 160;
$outx  = 10;
$outy  = 177;
$comx = 10;
$comy = 125;
$modx = 10;
$mody = 142;
$namx = 10;
$namy = 102;
$certifyx = 10;
$certifyy = 90;

    $sigx = 80;
    $sigy = 220;
    $custx = 30;
    $custy = 265;
    $wmarkx = 26;
    $wmarky = 58;
    $wmarkw = 158;
    $wmarkh = 170;
    $brdrx = 0;
    $brdry = 0;
    $brdrw = 210;
    $brdrh = 297;
    $codey = 250;
	$credity = 170;
}

//The royal college of midwives watermark
$pdf->SetAlpha(1.0);
certificate_print_image($pdf, $certificate, CERT_IMAGE_WATERMARK, $wmarkx, $wmarky, $wmarkw, $wmarkh);
//$pdf->Image($path."rcm_i-learn_logo_120.jpg", $mlgx , $mlgy, 25, 25);

// Add images and lines
certificate_print_image($pdf, $certificate, CERT_IMAGE_BORDER, $brdrx, $brdry, $brdrw, $brdrh);
certificate_draw_frame($pdf, $certificate);
// Set alpha to semi-transparency
//$pdf->SetAlpha(0.2);
//$pdf->SetAlpha(1);
certificate_print_image($pdf, $certificate, CERT_IMAGE_SIGNATURE, $sigx, $sigy, '', '');






$path = "$CFG->dirroot/mod/certificate/pix/seals/";
//RCM i learn
$pdf->SetAlpha(1);
//The royal college of midwives

$pdf->Image($path."rcm_i-learn_logo_120.jpg", $rcmx , $rcmy, 25, 25);
$pdf->Image($path."new-rcm-logo-l.jpg", $mlgx, $mlgy, 50, 30);
$pdf->Image($path."i-folio_logo_120b.jpg", $rlgx, $rlgy, 25, 25);







$cfont	=	"helvetica";

// Add text
$pdf->SetTextColor(0, 0, 120);
certificate_print_text($pdf, $x, $y, 'C', 'freesans', '', 30, get_string('title', 'certificate'));
$pdf->SetTextColor(0, 0, 0);
certificate_print_text($pdf, $certifyx , $certifyy , 'C', $cfont, '', 20, get_string('certify', 'certificate'));
certificate_print_text($pdf, $namx, $namy, 'C', $cfont, '', 30, fullname($USER));
certificate_print_text($pdf, $comx, $comy, 'C', $cfont, '', 16, get_string('hascompleted', 'certificate'));
certificate_print_text($pdf, $modx, $mody, 'C', $cfont, '', 20, $course->fullname);
certificate_print_text($pdf, $x, $y + 85, 'C', $cfont, '', 14, "in i-learn");
certificate_print_text($pdf, $datx+10, $daty + 7, 'C', $cfont, '', 14,  certificate_get_date($certificate, $certrecord, $course));
certificate_print_text($pdf, $outx, $outy + 5, 'C', $cfont, '', 10, certificate_get_outcome($certificate, $course));


certificate_print_text($pdf, $addx, $addy, 'C', $cfont, '', 10, get_string('rcmaddress', 'certificate'));

if ($certificate->printhours) {

    certificate_print_text($pdf, $x, $credity + 5, 'C', 'freeserif', '', 10, get_string('credithours', 'certificate').': '.$certificate->printhours);
}
certificate_print_text($pdf, $x, $codey + 5 , 'C', 'freeserif', '', 10, certificate_get_code($certificate, $certrecord));
$i = 0;
if ($certificate->printteacher) {
    $context = context_module::instance($cm->id);
    if ($teachers = get_users_by_capability($context, 'mod/certificate:printteacher', '', $sort = 'u.lastname ASC', '', '', '', '', false)) {
        foreach ($teachers as $teacher) {
            $i++;
            certificate_print_text($pdf, $sigx, $sigy + ($i * 4), 'L', 'freeserif', '', 12, fullname($teacher));
        }
    }
}

certificate_print_text($pdf, $x, $custy, 'C', null, null, null, $certificate->customtext);
?>