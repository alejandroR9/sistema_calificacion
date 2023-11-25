<?php

class ApiResponse
{
    /**
     * Metodo para trabajar con los errores 200 - 300
     * @param string $message El nombre del mensaje 
     * @param string $status El estado del mensaje
     * @param string $code Código del mensaje
     * @param string $error true si la respuesta da error
     * @param array $data data
     * @return array un array de datos
     */
    public static function success($message = 'success', $error = false, $code = 500, $data = [])
    {
        return json_encode([
            'message' => $message,
            'code' => $code,
            'error' => $error,
            'data' => $data,
        ]);
    }
    /**
     * Metodo para trabajar con los errores 500,400,300
     * @param string $message Mensaje del error
     * @param string $status El estado del error
     * @param string $code del error
     * @param string $error true si la respuesta da error
     * @param array $data Mensaje del error
     * @return array un array de datos
     */
    public static function error($message = 'error', $error = true, $code = 500, $data = [])
    {
        return json_encode([
            'message' => $message,
            'code' => $code,
            'error' => $error,
            'data' => $data,
        ]);
    }
}
