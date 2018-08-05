<?php

/*
 * This file is part of the LOG-VIEWER package.
 *
 * (c) Jitendra Adhikari <jiten.adhikary@gmail.com>
 *     <https://github.com/adhocore>
 *
 * Licensed under MIT license.
 */

namespace App\Http\Controllers;

use Ahc\Log\Factory;

class LogController extends Controller
{
    /**
     * Show the default landing page to view logs.
     */
    public function showLanding()
    {
        return view('log/landing', [
            'title'   => 'Log Viewer',
            'logSize' => Factory::DEFAULT_BATCH_SIZE,
        ]);
    }

    public function fetchLog(string $type)
    {
        $logpath = app('request')->get('logpath', '');
        $offset  = app('request')->get('offset', 1);
        $reader  = Factory::createReader($type, $logpath);

        return response()->json([
            'data'   => $reader->read($offset, Factory::DEFAULT_BATCH_SIZE),
            'offset' => $reader->getOffset(),
            'next'   => $reader->hasNext(),
        ]);
    }
}
