<?php

namespace Portal\Http\Controllers;

use Illuminate\Http\Request;
use Portal\Http\Requests;
use Portal\Http\Controllers\Controller;
use Portal\Libraries\CampaignSelector;
use Portal\Libraries\Interactions\Banner;

class CampaignsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     *
     */
    public function prueba()
    {
//        $camp = new CampaignSelector();
        $banner = new Banner('55c10856a8269769ac822f9a');
        $banner->getData();
        $vista=$banner->getView();
        return view($vista, ['data' => $banner->getData()]);


    }
}
