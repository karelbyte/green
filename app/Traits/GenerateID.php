<?php
/**
 * Created by PhpStorm.
 * User: papitoff
 * Date: 23/03/19
 * Time: 04:37 PM
 */

namespace App\Traits;


use App\Models\Surrogate;

trait GenerateID
{
    public function getID($model)
    {

        $su = Surrogate::where('model', $model)->select('next')->first();

        if (!is_null($su)) {

            return $su->next;

        } else {

            $su = Surrogate::create([

                'model' => $model,

                'next' => 1

            ]);

            return $su->next;
        }

    }

    public function setID($model, $id)
    {

        Surrogate::where('model', $model)->update(['next' => $id + 1]);

    }
}
