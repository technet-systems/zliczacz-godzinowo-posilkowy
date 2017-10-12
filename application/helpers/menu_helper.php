<?php

function link_access($href, $name, $set_year = FALSE) {
    if($set_year) {
        $link = '<li><a href="' . $href . '">' . $name . '</a></li>';
        return $link;

    } else {
        $link = '<li class="disabled"><a href="#">' . $name . '</a></li>';
        return $link;

    }

}