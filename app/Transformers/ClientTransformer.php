<?php
/**
 * Created by PhpStorm.
 * User: rafael
 * Date: 8/17/15
 * Time: 00:42
 */

namespace CodeProject\Transformers;


use CodeProject\Entities\Client;
use League\Fractal\TransformerAbstract;

class ClientTransformer extends TransformerAbstract
{

    public function transform(Client $client)
    {
        return [
            'id' => $client->id,
            'name' => $client->name,
            'email' => $client->email,
            'phone' => $client->phone
        ];
    }

}