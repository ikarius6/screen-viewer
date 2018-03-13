<?php
//Screen Viewer V1.0 - By Mr.Jack
$host = "127.0.0.1";
$port = "9876";
$tamano   = 2048;
$new_width = 1024;
        
$socket   = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
$conexion = socket_connect($socket, $host, $port);
do {
    $im = imagegrabscreen();
    if ($conexion) {
        $current_width = imagesx($im);
        $current_height = imagesy($im);
        $ratio = $current_height / $current_width;
        $new_height = $new_width * $ratio;
        $resized = imagecreatetruecolor($new_width, $new_height);
        imagecopyresized($resized, $im, 0, 0, 0, 0, $new_width, $new_height, $current_width, $current_height);
        ob_start();
        imagepng($resized);
        $contents =  ob_get_contents();
        ob_end_clean();
        imagedestroy($im);
        imagedestroy($resized);
        $buffer =  base64_encode($contents);
        $length = strlen($buffer);
        while (true) {
            $sent = socket_write($socket, $buffer, $length);
            if ($sent === false) {
                break;
            }
            if ($sent < $length) {
                $st = substr($buffer, $sent);
                $length -= $sent;
            } else {
                break;
            }
        }
        $end_message = "IMAGE_SENT";
        socket_write($socket, $end_message, strlen($end_message));

        $respuesta = "";
        while ($respuesta .= socket_read($socket, $tamano)) {
            if (strpos($respuesta, "\0"))
                break;
        }
    } else {
        socket_close($socket);
        return false;
    }
    $respuesta = json_decode(str_replace("\0", "", $respuesta));

    while ($respuesta->response != "NOTIFICATION_SENT"); //wait till we get response
    //60hz
    //usleep(16666);
} while( true );

//on exception maybe
socket_close($socket);

?>