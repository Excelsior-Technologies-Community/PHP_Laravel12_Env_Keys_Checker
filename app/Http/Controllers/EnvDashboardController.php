<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class EnvDashboardController extends Controller
{
    public function index()
    {
        $example = collect(file(base_path('.env.example')))
            ->filter(function ($line) {
                return str_contains($line, '=')
                    && !str_starts_with(trim($line), '#');
            })
            ->map(function ($line) {
                return trim(explode("=", $line)[0]);
            });

        $env = collect(file(base_path('.env')))
            ->filter(function ($line) {
                return str_contains($line, '=')
                    && !str_starts_with(trim($line), '#');
            })
            ->map(function ($line) {
                return trim(explode("=", $line)[0]);
            });

        $missing = $example->diff($env);

        return view('env-dashboard', [

            'total' => $example->count(),

            'present' => $example->count() - $missing->count(),

            'missingCount' => $missing->count(),

            'missingKeys' => $missing,

            'scanTime' => Carbon::now()
                ->format('d M Y h:i A')

        ]);
    }


    public function export()
    {
        $example = collect(file(base_path('.env.example')))
            ->filter(function ($line) {
                return str_contains($line, '=')
                    && !str_starts_with(trim($line), '#');
            })
            ->map(function ($line) {
                return trim(explode("=", $line)[0]);
            });

        $env = collect(file(base_path('.env')))
            ->filter(function ($line) {
                return str_contains($line, '=')
                    && !str_starts_with(trim($line), '#');
            })
            ->map(function ($line) {
                return trim(explode("=", $line)[0]);
            });

        $missing = $example->diff($env);

        $content =
            "================================

ENV MISSING KEYS REPORT

================================

Generated: " . now() . "

Total Missing: " . $missing->count() . "

--------------------------------

";

        foreach ($missing as $key) {
            $content .= "• " . $key . "\n";
        }

        return response($content)
            ->header(
                'Content-Type',
                'text/plain'
            )
            ->header(
                'Content-Disposition',
                'attachment; filename=env-report.txt'
            );
    }
}
