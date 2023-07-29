<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Models\Campaign;
use App\Models\CampaignAuthors;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    public function show(Request $request, $slug)
    {
        $campaign = Campaign::where('slug',$slug)->firstOrFail();
        if ($campaign->status != 5 and User::UserIn(Roles::Offizier) === false) {
            return redirect()->back();
        }

        $authors  = CampaignAuthors::where('campaign_id', $campaign->id)->get();
        $authorsArray = [];
        foreach ($authors as $author) {
            $authorsArray[] = User::getUsername($author->user());
        }
        return view('campaign.show', compact('campaign', 'authorsArray'));
    }

    public function edit(Request $request, $slug)
    {
        $campaign = Campaign::where('slug',$slug)->firstOrFail();
        return view('campaign.edit', compact('campaign'));
    }

    public function store(Request $request, $slug)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|max:255',
                'description' => 'max:150',
                'status' => 'required|in:0,1,2,3,4,5'
            ],
            [
                'name.required' => "Es muss ein Name angegeben werden!",
                'name.max' => 'Es dürfen maximal 255 Zeichen eingegeben werden',
                'description.max' => 'Es dürfen maximal 150 Zeichen eingegeben werden',
            ]
        );
        $campaign = Campaign::where('slug', $slug)->firstOrFail();
        $campaign->name = $request->get('name');
        $campaign->shortDescription = $request->get('description');
        $campaign->info = $request->get('editor');
        $oldStatus = $campaign->status;
        $campaign->status = $request->get('status');

        try {
            $campaign->saveOrFail();

            if ($oldStatus != $request->get('status')) {
                $allOtherCampaigs = Campaign::where('status', 5)->whereNotIn('id', $campaign->id)->get();
                foreach ($allOtherCampaigs as $otherCampaig) {
                    $otherCampaig->status = 1;
                    $otherCampaig->saveOrFail();
                }
            }
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors('Beim Speichern ist ein Fehler aufgetreten!');
        }
        return redirect()->route('campaign.edit', ['slug' => $campaign->slug])->with('success', 'Deine Daten wurden erfolgreich gespeichert.');
        //return redirect()->back()->withInput();
    }

    public function showall()
    {
        $campaigns = Campaign::all();
        $tabCam = [];
        foreach ($campaigns as $campaign) {
            $tmpArray = [];
            $tmpArray['slug'] = $campaign->slug;
            $tmpArray['name'] = $campaign->name;
            $tmpArray['shortDes'] = $campaign->shortDescription;
            $tmpArray['status'] = $campaign->status;
            $tmpArray['created'] = $campaign->created_at->format('d.m.Y');

            $authors = CampaignAuthors::where('campaign_id', $campaign->id)->get();
            $authorsArray = [];
            foreach ($authors as $author) {
                $authorsArray[] = User::getUsername($author->user());
            }
            $tmpArray['authors'] = $authorsArray;

            $tabCam[] = $tmpArray;
        }

        return view('campaignmanagement.showall', compact('tabCam'));
    }

    public function add()
    {
        return view('campaignmanagement.add');
    }

    public function addstore(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|max:255',
                'description' => 'max:150',
                'editor' => 'max:100000',
            ],
            [
                'name.required' => "Es muss ein Name angegeben werden!",
                'name.max' => 'Es dürfen maximal 255 Zeichen eingegeben werden',
                'description.max' => 'Es dürfen maximal 150 Zeichen eingegeben werden',
            ]
        );

        $campaign = new Campaign();
        $campaign->name = $request->get('name');
        $campaign->shortDescription = $request->get('description');
        $campaign->info = $request->get('editor');
        $campaign->status = 0;

        try {
            $campaign->saveOrFail();
            return redirect()->route('campaign.showall')->with('success', 'Kampagne erfolgreich angelegt');
        } catch (\Throwable $exception) {
            return redirect()->back()->withInput()->withErrors('Beim Speichern ist ein Fehler aufgetreten! Versuche es erneut oder speichere deine Infos bei dir zwischen und probiere es später erneut');
        }
    }
}
