<?php

class Dates
{
    static private $months = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre',
    ];

    static public function month($month)
    {
        return self::$months[$month];
    }

    static public function toSpanish($date)
    {
        $date = substr($date, 0, 10);

        $numeroDia = date('d', strtotime($date));
        $mes = date('F', strtotime($date));
        $anio = date('Y', strtotime($date));

        $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

        $nombreMes = str_replace($meses_EN, $meses_ES, $mes);

        return $numeroDia." de ".$nombreMes." de ".$anio;
    }

    static public function calculateSeniority($from, $to)
    {
        $seniorityYears = $from->diff($to)->y;
        $seniorityMonths = $from->diff($to)->m;
        return $seniorityYears.' años '.$seniorityMonths.' meses';
    }

    /**
     * Verifica si el momento actual es al inicio del año
     * hasta determinada hora.
     * Sirve para controlar que no se realizen cobros durante
     * el cierre del ejercicio por ej.
     */
    static public function isStartingYear($hour = '00:30:00')
    {
        $now = strtotime(date('Y-m-d H:i:s'));
		$to = strtotime(date('Y-01-01 '.$hour));

		return ($now < $to);
    }

    /**
     * Verifica que el momento actual esté entre un rango horario
     */
    static public function isInTimeRange($from, $to)
    {
        $now = strtotime(date('Y-m-d H:i:s'));
        $start = strtotime(date('Y-m-d '.$from));
		$end = strtotime(date('Y-m-d '.$to));

        if ($star > $end) {
            // se verifica entre dos días
            return ($now > $start OR $now < $end);
        }else{
            // se verifica en el mismo día
            return ($now >= $start AND $now <= $end);
        }
    }

}
