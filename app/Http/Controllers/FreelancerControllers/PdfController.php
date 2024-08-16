<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Controllers\Controller;
use App\Models\Freelancer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    //$html = view('cv-template', [
    //            'work_profile' => $workProfile
    //        ])->render();
    //
    //        $dompdf = new Dompdf();
    //        $dompdf->loadHtml($html);
    //        $dompdf->setPaper('A4', 'portrait');
    //        $dompdf->render();
    //        $output = $dompdf->output();
    //
    //        $folderPath = public_path('media/generated_CVs/');
    //        if (!file_exists($folderPath)) {
    //            mkdir($folderPath, 0755, true);
    //        }
    //        $userId   = $userId ?? auth()->id();
    //        $file     = 'generated_cv_user' . $userId . '.pdf';
    //        $filePath = $folderPath . $file;
    //
    //        file_put_contents($filePath, $output);

    public function generateCV()
    {
        $id = Auth::guard('Freelancer')->user()->id;
        $freelancer = Freelancer::find($id);
        $data = [
            'freelancer' => $freelancer,
            'experiences' => $freelancer->experiences,
            'educations' => $freelancer->eductions,
            'certifications' => $freelancer->certifications,
            'skills' => $freelancer->skills,
            'portfolios' => $freelancer->portfolios,
        ];


        $pdf = Pdf::loadView('cv-template', $data);

        return $pdf->download('cv.pdf');

    }
}
