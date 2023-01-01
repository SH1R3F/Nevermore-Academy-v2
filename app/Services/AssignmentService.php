<?php

namespace App\Services;

use App\Models\Assignment;
use Illuminate\Support\Facades\Auth;

class AssignmentService
{

    public function store(array $data): void
    {

        $assignment = new Assignment($data);
        $assignment->setTranslation('title', 'ar', $data['title_ar'])->setTranslation('title', 'en', $data['title_en']);
        $assignment->setTranslation('requirement', 'ar', $data['requirement_ar'])->setTranslation('requirement', 'en', $data['requirement_en']);
        $assignment->teacher()->associate(Auth::user());
        $assignment->save();
    }

    public function update(array $data, Assignment $assignment): void
    {
        $assignment->fill($data);
        $assignment->setTranslation('title', 'ar', $data['title_ar'])->setTranslation('title', 'en', $data['title_en']);
        $assignment->setTranslation('requirement', 'ar', $data['requirement_ar'])->setTranslation('requirement', 'en', $data['requirement_en']);
        $assignment->save();
    }
}
