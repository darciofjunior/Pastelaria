<?php

function formatDateAndTime($value, $format = 'd/m/Y')
{
    //Utiliza a classe de Carbon para converter ao formato de data ou hora ...
    return Carbon\Carbon::parse($value)->format($format);
}