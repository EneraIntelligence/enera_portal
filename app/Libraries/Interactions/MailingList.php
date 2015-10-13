<?php
/**
 * Created by PhpStorm.
 * User: pedroluna
 * Date: 9/25/15
 * Time: 10:37 AM
 */

namespace Portal\Libraries\Interactions;

use Portal\Libraries\Enera;
use Portal\Campaign;

class MailingList extends Enera
{
    protected $data;
    protected $campaign;

    public function __construct(Campaign $campaignData)
    {
        $this->view = "interaction.mailingList";
        $this->campaign = $campaignData;
    }
}