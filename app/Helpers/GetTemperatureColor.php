<?php

function getTemperatureColor($temperature, $temperatureSetting)
{
    if ($temperatureSetting == 1):
        $temperature = round($temperature*9/5+32, 1);
        if ($temperature >= 102.2) :
            $tempColor = '#FF2B2B';
        elseif ($temperature < 102.2 && $temperature >= 100.4) :
            $tempColor = '#F1955E';
        else :
            $tempColor = '#40C8C6';
        endif;
        return array('temp' => $temperature, 'tempcol' => $tempColor);
    elseif ($temperatureSetting == 0):
        $temperature = round($temperature, 1);
        if ($temperature >= 39.0) :
            $tempColor = '#FF2B2B';
        elseif ($temperature < 39.0 && $temperature >= 38.0) :
            $tempColor = '#F1955E';
        else :
            $tempColor = '#40C8C6';
        endif;
        return array('temp' => $temperature, 'tempcol' => $tempColor);
    endif;
}
