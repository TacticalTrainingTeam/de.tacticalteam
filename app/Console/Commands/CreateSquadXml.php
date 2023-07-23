<?php

namespace App\Console\Commands;

use App\Models\SquadXml;
use Illuminate\Console\Command;

class CreateSquadXml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-squad-xml';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Erstellt die SquadXML';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $xmlEntries = SquadXml::all();
        $header = '<?xml version="1.0"?><!DOCTYPE squad SYSTEM "squad.dtd"><squad nick="TTT"><name>Tactical Training Team</name><email>kontakt@tacticalteam.de</email><web>tacticalteam.de</web><picture>tttsquadxml.paa</picture><title>Tactical Training Team</title>';
        $footer = '</squad>';

        foreach ($xmlEntries as $xmlEntry) {
            $xml = "";
            $xml = '<member id="' . $xmlEntry->steam_id . '" nick="' . $xmlEntry->name . '"><name>N/A</name><email>N/A</email><icq>N/A</icq><remark>' . $xmlEntry->remark . '</remark></member>';
            $header .= $xml;
        }
        $header .= $footer;
        $dom = new \DOMDocument;
        $dom->preserveWhiteSpace = FALSE;
        $dom->loadXML($header);
        $dom->formatOutput = TRUE;
        $file = public_path() . '\\squadxml\\squad.xml';
        fwrite(fopen($file, 'w'), $dom->saveXML());
    }
}
