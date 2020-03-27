<?php

/**
 * Добавляет время к сообщениям, выводимым командой
 *
 */

namespace App\Traits;

use Illuminate\Console\Command;
use Log;

trait LoggableCommand
{
	/**
	 *
	 *
	 */

	public function line($string, $style = null, $verbosity = null)
	{
		switch ($style) {
			case 'error':
				Log::channel('commands')->error($string);
				break;

			default:
				Log::channel('commands')->info($string);
				break;
		}

		$string = now()->format('Y.m.d H:i:s') . ' ' . $string;

		parent::line($string, $style, $verbosity);
	}
}
