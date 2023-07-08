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
