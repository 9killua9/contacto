<?php
/*******
 *
 *@author: Leandro Salar - SECCION DE AJAX
 *
 *******/
session_start();

date_default_timezone_set('America/Argentina/Buenos_Aires');

function conectame()
{
    $host      = "190.228.29.195";
    $user       = "killua";
    $pass       = "alone999";
    $dataBase   = "reiatsu_viajeros";
    $r          = false;    
    
    if(@mysql_connect($host,$user,$pass))
    {
        if(@mysql_select_db($dataBase))
            $r = true;
    }

    return $r;
}

$h = $_POST['h'];

if(conectame())
{
    if($h == "traeCosas")
    {
        $encontrar = $_POST['encontrar'];
        $finRandom = ' ORDER BY RAND(15);';

        switch($_POST['como'])
        {
            case "localidad":
                $sql = 'select * from sitios where localidad LIKE "%'.utf8_decode($_POST['localidad']).'%"';
            break;
            case "calle":
                $sql = 'select * from sitios where direccion LIKE "%'.utf8_decode($_POST['quecalle']).'%"';
            break;
        }
        
        // Concateno el sql para saber que traigo.
        if($encontrar != "")
            $sql .= ' AND tipo = "'.$encontrar.'"';

        $sql .= $finRandom;

        // Ejecuto el SQL
        $res            = @mysql_query($sql);
        $i              = 0;
        $r['aviso']     = $sql;
        
        while($re = @mysql_fetch_array($res))
        {
            $r['aviso']             = "exito";
            $r[$i]['id']            = $re['id'];
            $r[$i]['banco']         = $re['banco'];
            $r[$i]['localidad']     = $re['localidad'];
            $r[$i]['ciudad']        = $re['ciudad'];
            $r[$i]['tipo']          = $re['tipo'];
            $r[$i]['direccion']     = $re['direccion'];
            $r[$i]['icono']         = $re['icono'];
            $r[$i]['telefono']      = $re['telefono'];

            $i++;
        }
        $r['vueltas'] = $i;

        echo json_encode($r);
    }
}
else
{
    $r['aviso'] = "no conecto a la base de datos";
    echo json_encode($r);
}
?>