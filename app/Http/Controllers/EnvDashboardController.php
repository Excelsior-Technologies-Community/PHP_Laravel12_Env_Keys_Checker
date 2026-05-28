<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class EnvDashboardController extends Controller
{
    private function getEnvData()
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

        return [
            'total' => $example->count(),
            'present' => $example->count() - $missing->count(),
            'missingCount' => $missing->count(),
            'missingKeys' => $missing,
        ];
    }

    public function index(Request $request)
    {
        $data = $this->getEnvData();

        if ($request->search) {
            $data['missingKeys'] = $data['missingKeys']->filter(function ($key) use ($request) {
                return str_contains(
                    strtolower($key),
                    strtolower($request->search)
                );
            });

            $data['missingCount'] = $data['missingKeys']->count();
        }

        $data['scanTime'] = Carbon::now()
            ->format('d M Y h:i A');

        $data['healthPercentage'] =
            $data['total'] > 0
            ? round(($data['present'] / $data['total']) * 100)
            : 0;

        return view('env-dashboard', $data);
    }

    public function export()
    {
        $data = $this->getEnvData();

        $content =
            "================================\n" .
            "ENV MISSING KEYS REPORT\n" .
            "================================\n" .
            "Generated: " . now() . "\n" .
            "Total Missing: " . $data['missingCount'] . "\n" .
            "--------------------------------\n";

        foreach ($data['missingKeys'] as $key) {
            $content .= "• " . $key . "\n";
        }

        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header(
                'Content-Disposition',
                'attachment; filename=env-report.txt'
            );
    }

    public function autoAdd()
    {
        $example = collect(file(base_path('.env.example')))
            ->filter(function ($line) {
                return str_contains($line, '=')
                    && !str_starts_with(trim($line), '#');
            });

        $envPath = base_path('.env');

        $envContent = file_get_contents($envPath);

        foreach ($example as $line) {

            $key = trim(explode('=', $line)[0]);

            if (!str_contains($envContent, $key . '=')) {
                file_put_contents(
                    $envPath,
                    "\n" . $key . "=",
                    FILE_APPEND
                );
            }
        }

        return redirect('/env-dashboard')
            ->with('success', 'Missing keys auto added successfully.');
    }
}