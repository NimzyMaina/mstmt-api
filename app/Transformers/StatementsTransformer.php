<?php
/**
 * Created by PhpStorm.
 * User: Maina
 * Date: 1/23/2018
 * Time: 5:46 PM
 */

namespace App\Transformers;


use App\Statement;
use League\Fractal\TransformerAbstract;

class StatementsTransformer extends TransformerAbstract
{

    public function transform(Statement $statement)
    {
        return [
            'id' => $statement->id,
            'path' => $statement->path,
            'description' => $statement->description,
            'created_at' => (string) $statement->created_at
        ];
    }

}