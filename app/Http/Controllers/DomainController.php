<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use Exception;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function checkDomains(Request $request)
    {
       
        try {
            $domains = $request->input('domains');
            if (empty($domains)) {
                return response()->json(['error' => 'домены не переданы'], 400);
            }

            $domainsInputArr = array_filter(array_map('trim', array_unique($domains)));

            $dbDomains = Domain::whereIn('domain', $domainsInputArr)->get()->keyBy('domain');
            $result = [];

            foreach ($domainsInputArr as $domainName) {
                if (isset($dbDomains[$domainName])) {
                    $domain = $dbDomains[$domainName];
                    $result[$domainName] = $domain->isAvailable()
                        ? 'Домен доступен для регистрации'
                        : 'Домен занят, истекает: ' . $domain->expires_at;
                } else {
                    $result[$domainName] = 'Домен доступен для регистрации';
                }
            }

            return response()->json($result);
        } catch (Exception $th) {
            return response()->json([
                'error' => 'unexpected error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function checkDomainsWhois(Request $request)
    {
        try {
            $domains = $request->input('domains');
            if (empty($domains)) {
                return response()->json(['error' => 'домены не переданы'], 400);
            }

            $domains = array_unique(array_map('trim', $domains));

            $result = [];

            foreach ($domains as $domainName) {
                if (!$this->isValidDomain($domainName)) {
                    $result[$domainName] = "Некорректный формат домена";
                    continue;
                }

                $isTaken = rand(0, 1);
                if ($isTaken) {
                    $expiresAt = now()->addDays(rand(30, 365))->toDateString();
                    $result[$domainName] = "Домен занят, истекает: $expiresAt";
                } else {
                    $result[$domainName] = 'Домен доступен для регистрации';
                }
            }

            return response()->json($result);
        }catch (Exception $th) {
            return response()->json([
                'error' => 'unexpected error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    private function isValidDomain($domain)
    {
        return preg_match('/^(?!-)[a-zA-Z0-9-]{1,63}(?<!-)\.[a-zA-Z]{2,63}$/', $domain);
    }
}
