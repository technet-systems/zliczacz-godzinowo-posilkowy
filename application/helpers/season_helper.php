<?php

function school_year ($se_year = FALSE) {
    if($se_year) {
        return $se_year . '/' . ++$se_year;

    } else {
        return 'brak';

    }

}