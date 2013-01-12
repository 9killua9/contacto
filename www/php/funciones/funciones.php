<?php
/*******
 *
 *@author: Leandro Salar - del funciones NO ajax.
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

function buscaDatosHotel($res)
{
    if(conectame())
    {

        /*falta armar de nuevo segun que estoy pidiendo */
        $dato = explode(",",$res);
        
        if( $dato[0] != "" && $dato[1] != "")
            $ok = "todos";
        else
        {
            if( $dato[0] != "" && $dato[1] == "" )
                $ok = "prov";
            elseif( $dato[1] != "" && $dato[0] == "")
                $ok = "pais";
            else
                $ok = "nop";
        }

        if($ok == "todos")
            $sql = 'select * from hoteles WHERE idPais LIKE "%'.trim(strtolower($dato[0])).'%" OR idProv LIKE "%'.trim(strtolower($dato[1])).'%"';
        elseif($ok == "prov")
            $sql = 'select * from hoteles WHERE idProv LIKE "%'.trim(strtolower($dato[1])).'%"';
        elseif($ok == "pais")
            $sql = 'select * from hoteles WHERE idPais LIKE "%'.trim(strtolower($dato[0])).'%"';

        if($ok != "nop")
            $res = @mysql_query($sql);
        else
            $r['aviso'] = "query no ejecutada";
        
        if($ok != "")
        {
            $i = 0;
            while( $re = @mysql_fetch_array($res) )
            {
                $r[$i]['id']                 = $re['id'];
                $r[$i]['idProv']             = $re['idProv'];
                $r[$i]['idPais']             = $re['idPais'];
                $r[$i]['nombre']             = $re['nombre'];
                $r[$i]['ubicacion']          = $re['ubicacion'];
                $r[$i]['wifi']               = $re['wifi'];
                $r[$i]['cocina']             = $re['cocina'];
                $r[$i]['compartidas']        = $re['compartidas'];
                $r[$i]['privadas']           = $re['privadas'];
                $r[$i]['lavanderia']         = $re['lavanderia'];
                $r[$i]['email']              = $re['email'];
                $r[$i]['telefono']           = $re['telefono'];
                $r[$i]['buenos']             = $re['a'];
                $r[$i]['malos']              = $re['b'];
                $r[$i]['c']              = $re['c'];
                
                $i++;
            }
        }

        $r['vueltas'] = $i;
        
        $fin = @mysql_close();

        return $r;
    }
}


function traeQueQueresEncontrar()
{
    if(conectame())
    {

        $sql = 'select distinct tipo from sitios';
        
        $res = @mysql_query($sql);
        
            $i = 0;
            
            while( $re = @mysql_fetch_array($res) )
            {
                $r[$i]['tipo'] = $re['tipo'];
                $i++;
            }

        $r['vueltas'] = $i;
        
        $fin = @mysql_close();

        return $r;
    }

}
?>