<?php

namespace App\Services;

use App\Models\Language;

class LanguageService
{
    public function create(string $id,array $languages){
        foreach ($languages as $language){
            Language::create([
                'language'=>$language['language'],
                'level'=>$language['level'],
                'freelancer_id'=>$id,
            ]);
        }

    }
    public function delete(string $id){
        Language::where('id',$id)->delete();
    }

}
