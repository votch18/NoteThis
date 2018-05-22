<?php

class Util extends Model {

    public static function generateRandomCode($length = 50) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    public static function generateRandomCode2($length = 4) {
        return substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    public static function n_format($value){

        return number_format((float)$value, 2, '.', ',');
    }

    public static function d_format($value){

        return date_format(new DateTime($value), 'Y/m/d');
    }

    public static function d_format2($value){

        return date_format(new DateTime($value), 'Y/m/d h:m A');
    }

    
    public static function date_format($value){

        return date_format(new DateTime($value), 'Y-m-d');
    }


    public static function draw_calendar($month,$year, $check_in, $check_out){

        $day_from = $check_in->format('d');

        $num_of_days = date_diff($check_in, $check_out);
        $num_of_days = $num_of_days->d;
        $to = $day_from + $num_of_days;

        $style = "";
        $days = array();
        for ($x = $day_from; $x <= $to; $x++){
            array_push($days, $x);
        }


        /* draw table */
        $months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'Nomvember', 'December');
        $calendar = '<table cellpadding="0" cellspacing="0" class="calendar" style="width: 100%;">
        <tr>
            <td colspan="7"><div class="btn btn-primary" style="width: 100%; font-weight: bold; font-size: 18px; padding: 20px; text-align: center;">'.$months[$month-1].' '.$year.'</div></td>
        </tr>
        ';

        /* table headings */
        $headings = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
        $calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

        /* days and weeks vars now ... */
        $running_day = date('w',mktime(0,0,0,$month,1,$year));
        $days_in_month = date('t',mktime(0,0,0,$month,1,$year));
        $days_in_this_week = 1;
        $day_counter = 0;
        $dates_array = array();

        /* row for week one */
        $calendar.= '<tr class="calendar-row">';

        /* print "blank" days until the first of the current week */
        for($x = 0; $x < $running_day; $x++):
            $calendar.= '<td class="calendar-day-np"> </td>';
            $days_in_this_week++;
        endfor;

        /* keep going with days.... */
        for($list_day = 1; $list_day <= $days_in_month; $list_day++):
            $calendar.= '<td class="calendar-day">';
            /* add in the day number */
            if (in_array($list_day, $days)) {
                $style = " style='background: #faaf40;'";
            }else {
                $style = "";
            }
            $calendar.= '<div class="day-number" '.$style.'>'.$list_day.'</div>';

            /** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
            $calendar.= str_repeat('<p> </p>',2);

            $calendar.= '</td>';
            if($running_day == 6):
                $calendar.= '</tr>';
                if(($day_counter+1) != $days_in_month):
                    $calendar.= '<tr class="calendar-row">';
                endif;
                $running_day = -1;
                $days_in_this_week = 0;
            endif;
            $days_in_this_week++; $running_day++; $day_counter++;
        endfor;

        /* finish the rest of the days in the week */
        if($days_in_this_week < 8):
            for($x = 1; $x <= (8 - $days_in_this_week); $x++):
                $calendar.= '<td class="calendar-day-np"> </td>';
            endfor;
        endif;

        /* final row */
        $calendar.= '</tr>';

        /* end the table */
        $calendar.= '</table>';

        /* all done, return result */
        return $calendar;
    }


}
