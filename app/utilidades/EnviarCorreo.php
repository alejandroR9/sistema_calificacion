<?php
require_once 'ObtenerFechas.php';
class EnviarCorreo
{


    /**
     * @param string $destinatario A quien sera enviado
     * @param string $curso Curso
     * @param string $nota Nota del examen
     * @param string $tiempo El tiempo en que termino el examen
     * @param string $estado Si es aprobado o no desaprobado
     */
    public static function enviarNotas($destinatario, $curso, $nota, $tiempo, $estado)
    {

        $fecha = ObtenerFechas::fechaActual();
        $subject = $fecha . " - Resultado del examen - " . $curso;
        $forMessage    =  $destinatario;

        $body = '
        <html>
        <head>
        <style>
        </style>
        </head>
        <body>
            <div style="pading:10px">
                <h1 style="font-size:24px;">' . $subject . '</h1>
                <p>
                    Tiempo: <strong>' . $tiempo . '</strong> minutos
                </p>
                <p>
                Nota: <strong>' . $nota . '</strong>
                </p>
                <p>
                Estado: <strong>' . $estado . '</strong>
                </p>
            </div>
        </body>
        </html>
        ';
        //Cabecera Obligatoria
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: SRA<padmin@gmail.com>' . "\r\n";
        $headers .= 'Cc: jmrivera_22@hotmail.com' . "\r\n";

        //OPCIONAR
        $headers .= "Reply-To: ";
        $headers .= "Return-path:";
        $headers .= "Cc:";
        $headers .= "Bcc:";
        if (mail($forMessage, $subject, $body, $headers)) {
            return true;
        } else {
            return false;
        }
    }
}
