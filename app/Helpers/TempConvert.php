<?php

function tempConvert($temperature, $temperatureSetting)
{
    if ($temperatureSetting == 1):
        return $temperature*9/5+32;
    else:
        return $temperature;
    endif;
}
