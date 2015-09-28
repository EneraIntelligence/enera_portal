<?php
/**
 * Created by PhpStorm.
 * User: pedroluna
 * Date: 9/25/15
 * Time: 10:32 AM
 */

namespace Portal\Libraries\Interactions;

use Portal\User;

class CampaignSelector
{
    protected $user;
    protected $campaign;

    /**
     * CampaignSelector constructor.
     * @param $user_id
     */
    public function __construct($user_id)
    {
        $this->user = User::find($user_id);
        $this->campaign = $this->selector();
    }

    private function selector()
    {
        // TODO aqui la consulta para obtener la(s) campaña(s) adecuada(s) al usuario
    }

}