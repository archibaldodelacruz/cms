<?php

namespace App\ProteCMS\Backend\Controllers\Admin\Panel\Animals;

use PDF;
use App\ProteCMS\Core\Models\Animals\Animal;
use App\ProteCMS\Backend\Controllers\Admin\BaseAdminController;

class ExportController extends BaseAdminController
{
    protected $animal;

    public function __construct(Animal $animal)
    {
        parent::__construct();

        $this->animal = $animal;
    }

    public function pdf($id)
    {
        $animal = $this->animal
            ->with(['web', 'translations', 'photos' => function ($query) {
                $query->main();
            }])
            ->findOrFail($id);

        $pdf = PDF::loadView('exports.animals.pdf', compact('animal'));

        return $pdf->stream();
    }

    public function word($id)
    {
    }
}
