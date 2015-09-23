<?php
/**
 * Created by PhpStorm.
 * User: rafael
 * Date: 8/17/15
 * Time: 00:09
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\User;
use League\Fractal\TransformerAbstract;

class ProjectMemberTransformer extends TransformerAbstract
{

    public function transform(User $member)
    {
        return [
            'user_id' => $member->id,
            'name' => $member->name
        ];
    }

}