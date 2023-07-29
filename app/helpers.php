<?php
if (! function_exists('getColorForMissions')) {
    function getColorForMissions($days): array
    {
        if ($days <= 29) {
            return [
                'bg-color' => '#51C900',
                'font'     => 'black',
            ];
        } elseif ($days <= 59) {
            return [
                'bg-color' => '#FFDD00',
                'font'     => 'black',
            ];
        } elseif ($days <= 89) {
            return [
                'bg-color' => '#FF7700',
                'font'     => 'black',
            ];
        }  else {
            return [
                'bg-color' => '#990000',
                'font'     => 'white',
            ];
        }
    }
}
if (!function_exists('getStatusForCampaign')) {
    function getStatusForCampaign($status): string
    {
        if ($status == 0) {
            return '<span class="badge badge-primary">Unsichtbar</span>';
        }
        if ($status == 1) {
            return '<span class="badge badge-warning">Inaktiv</span>';
        }
        if ($status == 5) {
            return '<span class="badge badge-success">Öffentlich</span>';
        }
        return '<span class="badge badge-danger">Status nicht feststellbar!</span>';
    }
}
