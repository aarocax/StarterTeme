<?php

namespace METRIC\app\utils;


class Utils
{

	/**
   * Devuelve la IP del cliente,
   * 
   * @return string 	ip de cliente
   */
	public static function getClientIp()
  {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      $ip_address = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
    $ip_address = $_SERVER['REMOTE_ADDR'];
    }
    return $ip_address;
  }


  /**
   ************ Funciones de fecha y hora
   */

  /**
   * Comprueba si una cadena de texto es una hora valida
   * 
   * @param  string  $string La hora
   * @return boolean         Un booleano indicando si la hora es valida
   */
  public static function isValidHour($string)
  {
    return ( preg_match('/(2[0-3]|[01][0-9]):[0-5][0-9]/', $string) === 1 ) ? true : false;
  }

  /**
   * Comprueba si una cadena de texto es una fecha válida
   * 
   * @param  string  	$date 		La fecha 12/12/2020
   * @param  string  	$format 	formato de fecha de entrada que se quiere validar
   * 
   * @return boolean 						Un booleano indicando si la fecha es valida
   */
  public static function isValidDate($date, $format = 'Y-m-d H:i:s')
  {
  	$d = \DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
  }

  /**
   * Obtiene un objeto Datetime de una fecha en Español
   * 
   * @param  string $fecha  "31/12/2019" or "31/12/2019 12:20"
   * 
   * @return objet DateTime or false
   */
  public static function toDateTime($fecha)
  {
    
    $response = false;
    $hora = "00:00:00";
    $fecha = explode(" ", $fecha);
    if (isset($fecha[1])) {
      $hora = $fecha[1];
      if (count(explode(":", $hora)) < 3) {
        $hora = $hora.":00";
      }
    }
    $fecha = $fecha[0];
    if (self::isValidDate($fecha)) {
      $fecha_array = explode('/', $fecha);
      $f = $fecha_array[2]."-".$fecha_array[1]."-".$fecha_array[0]." ".$hora;
      $response = new \Datetime($f);
    } 
    return $response;
  }

  /**
   * Obtiene objeto DateTime Con el primer día de l semana de la fecha especificada
   * 
   * @param  string $fecha  "31/12/2019" or "31/12/2019 12:20"
   * 
   * @return objet DateTime or false
   */
  public static function firstDayOfWeek($date = null)
  {
  	if (!self::isValidDate($date))
  		return null;
    if ($date instanceof \DateTime) {
        $date = clone $date;
    } else if (!$date) {
        $date = new \DateTime();
    } else {
        $date = new \DateTime($date);
    }

    if ($date->format('N') != 1) {
      $date->modify('last monday');
    }
    $date->setTime(0, 0, 0);
    return $date;
  }

  /**
   * Obtiene objeto DateTime Con el último día de l semana de la fecha especificada
   * 
   * @param  string $fecha  "31/12/2019" or "31/12/2019 12:20"
   * 
   * @return objet 					DateTime or false
   */
  public static function lastDayOfWeek($date = null)
  {
  	
 		$d = false;
    if ($date instanceof \DateTime) {
      $d = clone $date;
      $d = new \DateTime($d);
      if ($d->format('N') != 7) {

	      $d->modify('Next Sunday');  
	    } 
	    $d->setTime(23,59,59);
    } else {
    
    }
    return $d;
  }

}