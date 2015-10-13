<?php
/**
 * Created by PhpStorm.
 * User: pedroluna
 * Date: 9/25/15
 * Time: 10:36 AM
 */

namespace Portal\Libraries\Interactions;

use Portal\Libraries\Enera;

class Survey extends Enera
{
    public function __construct(Campaign $campaign)
    {
        $this->view = "interaction.survey";
        $this->campaign = $campaign;
    }
}