<?php
/**
 * Pomocnikowy przeliczacz odsetkowy
 */

function interest($payment, $due, $amount) {
    $payment_year = substr($payment, 0, 4);
    $due_year = substr($due, 0, 4);

    $payment = strtotime($payment);
    $due = strtotime($due);

    $free_days_payment = array(
        strtotime($payment_year.'-01-01'),
        strtotime($payment_year.'-01-06'),
        strtotime($payment_year.'-05-01'),
        strtotime($payment_year.'-05-03'),
        strtotime($payment_year.'-08-15'),
        strtotime($payment_year.'-11-01'),
        strtotime($payment_year.'-11-11'),
        strtotime($payment_year.'-12-25'),
        strtotime($payment_year.'-12-26'),
        easter_date($payment_year),
        easter_date($payment_year)+86400,
        easter_date($payment_year)+5184000

    );

    $free_days_due = array(
        strtotime($due_year.'-01-01'),
        strtotime($due_year.'-01-06'),
        strtotime($due_year.'-05-01'),
        strtotime($due_year.'-05-03'),
        strtotime($due_year.'-08-15'),
        strtotime($due_year.'-11-01'),
        strtotime($due_year.'-11-11'),
        strtotime($due_year.'-12-25'),
        strtotime($due_year.'-12-26'),
        easter_date($due_year),
        easter_date($due_year)+86400,
        easter_date($due_year)+5184000

    );

    // Sprawdzenie czy obie daty (termin i wpłata) wypadają w ww. święta - jeśli tak, to dodajemy do danej daty dobę (86400)
    if(in_array($payment, $free_days_payment)) {
        $payment += 86400;

        if(in_array($payment, $free_days_payment)) {
            $payment += 86400;

        }

        $what_day = date('N', $payment);

        if($what_day > 6) { // 7 jako niedziela
            $payment += 86400;

            if(in_array($payment, $free_days_payment)) {
                $payment += 86400;

            }

        };

    }

    if(in_array($due, $free_days_due)) {
        $due += 86400;

        if(in_array($due, $free_days_due)) {
            $due += 86400;

        }

        $what_day = date('N', $due);

        if($what_day > 6) { // 7 jako niedziela
            $due += 86400;

            if(in_array($due, $free_days_due)) {
                $due += 86400;

            }

        };

    }
    // /.Sprawdzenie czy obie daty (termin i wpłata) wypadają w ww. święta - jeśli tak, to dodajemy do danej daty dobę (86400)

    $delay = ((($payment - $due)/60)/60)/24;

    $rate = 0.07;

    $interest = round((($delay * $rate) / 365) * $amount, 2);

    return $interest;

}