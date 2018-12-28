<?php

namespace App\Http\Controllers;

class ScreenshotController extends Controller
{
    public function index()
    {
        return view('screenshot.index');
    }

    public function gif()
    {
        $dir = '/var/www/screenshots/gif';

        $files = array_filter(scandir($dir) ?: [], function ($file) {
            return strpos($file, '.gif');
        });
        $lastFile = last($files);

        // get whitch day has file
        $fileCalendar = $calendar = [];
        foreach ($files as $file) {
            list($year, $month, $day) = explode('-', $file);
            $fileCalendar[(int) $year][(int) $month][(int) $day] = true;
        }

        // genreate calendar
        foreach ($fileCalendar as $year => $months) {
            krsort($months);

            foreach ($months as $month => $days) {
                $dt = Carbon::createFromFormat('Y-m', $year . '-' . $month, 'Asia/Taipei');
                $rows = $row = [];

                for ($i = 1; $i <= $dt->daysInMonth; $i++) {
                    $day = $dt->copy()->day($i);
                    $weekNo = $day->dayOfWeek;
                    $filename = $day->format('Y-m-d') . '.gif';
                    $row[$weekNo] = [
                        'day'  => $i,
                        'file' => in_array($filename, $files) ? $filename : null,
                    ];

                    if ($weekNo == Carbon::SATURDAY) {
                        $rows[] = $row;
                        $row = [];
                    }
                }
                $rows[] = $row;

                $calendar[$year][$month] = $rows;
            }
        }

        return view('screenshot.gif', compact('calendar', 'lastFile'));
    }
}
