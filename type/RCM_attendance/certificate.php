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
    $x = 10;
    $y = 50;
    $rcmx = 20;
    $rcmy = 20;
    $sealx = 105;
    $sealy = 20;
    $sigx = 120;
    $sigy = 150;
    $custx = 47;
    $custy = 185;
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
    $sealx = 20;
    $sealy = 20;
    $rcmx = 20;
    $rcmy = 20;
    $sigx = 80;
    $sigy = 210;
    $custx = 30;
    $custy = 250;
    $wmarkx = 26;
    $wmarky = 58;
    $wmarkw = 158;
    $wmarkh = 170;
    $brdrx = 0;
    $brdry = 0;
    $brdrw = 210;
    $brdrh = 297;
    $codey = 250;
	$credity = 172;	
}

// Add images and lines
certificate_print_image($pdf, $certificate, CERT_IMAGE_BORDER, $brdrx, $brdry, $brdrw, $brdrh);
certificate_draw_frame($pdf, $certificate);
// Set alpha to semi-transparency
$pdf->SetAlpha(1.0);
certificate_print_image($pdf, $certificate, CERT_IMAGE_WATERMARK, $wmarkx, $wmarky, $wmarkw, $wmarkh);
$pdf->SetAlpha(1);
certificate_print_image($pdf, $certificate, CERT_IMAGE_SEAL, $sealx +145, $sealy, 25, 25);
certificate_print_image($pdf, $certificate, CERT_IMAGE_SIGNATURE, $sigx, $sigy, '', '');

$path = "$CFG->dirroot/mod/certificate/pix/seals/";

//The royal college of midwives
$pdf->Image($path."RCM_logo.png", $rcmx , $rcmy, 50, 30);
$pdf->SetAlpha(1);

$cfont	=	"helvetica";

// Add text
$pdf->SetTextColor(0, 0, 120);
certificate_print_text($pdf, $x, $y, 'C', $cfont, '', 30, get_string('titleattendance', 'certificate'));
$pdf->SetTextColor(0, 0, 0);
certificate_print_text($pdf, $x, $y + 20, 'C', $cfont, '', 20, get_string('certify', 'certificate'));
certificate_print_text($pdf, $x, $y + 36, 'C', $cfont, '', 30, fullname($USER));
certificate_print_text($pdf, $x, $y + 55, 'C', $cfont, '', 16, get_string('attended', 'certificate'));
certificate_print_text($pdf, $x, $y + 70, 'C', $cfont, '', 20, $course->fullname);
certificate_print_text($pdf, $x, $y + 82, 'C', $cfont, '', 14, certificate_get_date($certificate, $certrecord, $course));
certificate_print_text($pdf, $x, $y + 91, 'C', $cfont, '', 8,  certificate_get_grade($certificate, $course));


certificate_print_text($pdf, $x, $y + 112, 'C', $cfont, '', 10, certificate_get_outcome($certificate, $course));
certificate_print_text($pdf, $x, $y + 180, 'C', $cfont, '', 10, get_string('rcmaddress', 'certificate'));

if ($certificate->printhours) {

    certificate_print_text($pdf, $x, $credity, 'C', 'freeserif', '', 10, get_string('credithours', 'certificate').': '.$certificate->printhours);
}
certificate_print_text($pdf, $x, $codey, 'C', $cfont, '', 10, certificate_get_code($certificate, $certrecord));
$i = 0;
if ($certificate->printteacher) {
    $context = context_module::instance($cm->id);
    if ($teachers = get_users_by_capability($context, 'mod/certificate:printteacher', '', $sort = 'u.lastname ASC', '', '', '', '', false)) {
        foreach ($teachers as $teacher) {
            $i++;
            certificate_print_text($pdf, $sigx, $sigy + ($i * 4), 'L', $cfont, '', 12, fullname($teacher));
        }
    }
}

certificate_print_text($pdf, $x, $custy, 'C', null, null, null, $certificate->customtext);
?>