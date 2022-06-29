<?php

namespace App\Http\Controllers;

use App\Data\CSUN;
use App\Data\Models\Classes;
use App\Data\Models\Semester;
use App\Data\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class ClassesController extends Controller
{
    private CSUN $csun;

    public function __construct()
    {
        $this->csun = new CSUN();
    }

    public function index()
    {
        $startTime = microtime(true);

        $classes = $this->csun->getClasses();

        $endTime = microtime(true);
        $executionTime = ($endTime - $startTime);

        return view('home', [
            'classes' => $classes,
            'executionTime' => $executionTime,
        ]);
    }

    public function classes(Request $request)
    {
        $this->validateRequest($request);

        $semester = isNullOrEmpty($request['semester']) ? Term::getCurrentSemester() : Semester::getThisByName($request['semester']);
        $year = $request['year'] ?? Term::getCurrentYear();
        $term = new Term($semester, $year);

        $subject = $request['subject'] ?? 'Comp';
        $catalogNumber = $request['catalog_number'] ?? 110;
        $classesParam = new Classes($subject, $catalogNumber);

        // TODO: Measuring script execution time
        $startTime = microtime(true);

        $classes = $this->csun->getClasses($term, $classesParam); // TODO: It takes too long to unload classes, so I use a cache with 1 hour storage

        $endTime = microtime(true);
        $executionTime = ($endTime - $startTime);

        $response = [
            'classes' => $classes,
            'executionTime' => round($executionTime, 2),
            'currentSemester' => Term::getCurrentSemester()->name,
            'currentYear' => Term::getCurrentYear(),
        ];

        if ($request->ajax()) {
            $response += [
                'listHtml' => view('table.classlist', ['classes' => $classes])->render()
            ];

            return response()->json($response);
        }

        return view('classes', $response);
    }

    private function validateRequest(Request $request)
    {
        $request->validate([
            // Term
            'semester'          => ['nullable', new Enum(Semester::class)],
            'year'              => ['nullable', 'required_with:semester', 'digits:4', 'integer', 'min:' . Term::getMinYear(), 'max:' . Term::getMaxYear()],

            // Class
            'subject'           => ['nullable', 'required_with:catalog_number', 'string'],
            'catalog_number'    => ['nullable', 'required_with:subject', 'integer', 'min:1']
        ]);
    }
}
