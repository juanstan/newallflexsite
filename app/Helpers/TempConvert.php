<?php

function tempConvert($temperature, $temperatureSetting)
{
    if ($temperatureSetting == 'F'):
        return $temperature*9/5+32;
    else:
        return $temperature;
    endif;
}
