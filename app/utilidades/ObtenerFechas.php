<?php

class ObtenerFechas
{
    public static function fechaParaHeader(): string
    {
        date_default_timezone_set('America/Lima');
        $mes = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        return 'Perú ' . date('d') . " de " . $mes[date('n')] . " de " . date('Y');
    }

    public static function fechaActual(): string
    {
        date_default_timezone_set('America/Lima');
        return date('Y-m-d H:i:s');;
    }
}
