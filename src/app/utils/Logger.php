<?php

namespace METRIC\app\utils;


class Logger
{

	private static $active = true;

	/**
   * Registra un mensaje en un archivo de texto,
   * 
   * @param  string|array|object|nnumber $msg     Mensaje a registrar
   * @param  string $channel    									Nombre del archivo de log
   */
	public static function write($msg, $channel = null)
	{
		if (self::$active) {
			$logs_path = realpath(dirname(__FILE__) . "/../../var/logs");
			$channel = ($channel == null) ? "centrosupera.log" : $channel.".log";
			$log_path = $logs_path."/".$channel;

			try {
				$arch = fopen($log_path, "a+");
				if (!$arch) {
					throw new \Exception('File open failed.');
				}
		    fwrite($arch, "[". date("Y-m-d H:i:s.u") . "]" . var_export($msg, true) . "\n");
		    fclose($arch);
			} catch (Exception $e) {
				
			}
		}
	}

}