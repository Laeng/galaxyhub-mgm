<?php

namespace App\Services\SSH;

use App\Services\SSH\Contracts\SSHServiceContract;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Net\SSH2;

class SSHService implements SSHServiceContract
{
    const CACHE_SET_ACCOUNT_PASSWORD_LOCK = 'services.ssh.set.account_password_lock';

    private ?SSH2 $client = null;

    public function getClient(string $address, string $username, ?string $password, int $port = 22, int $timeout = 30): self
    {
        try {
            if (is_null($password))
            {
                $password = PublicKeyLoader::load($this->getPrivateKeyFile($username));
            }

            $client = new SSH2($address, $port, $timeout);

            if (!$client->login($username, $password)) {
                throw new \Exception('Login failed');
            }

            $this->client = $client;

        }
        catch (\Exception $e)
        {
            Log::error($e);
        }

        return $this;
    }

    public function setAccountPassword(string $username, $password): bool
    {
        try {
            if (is_null($this->client)) return false;

            $response = $this->client->exec("net user \"{$username}\" \"{$password}\"");
            if (str_contains($response, 'The command completed successfully.')) return true;
        }
        catch (\Exception $e)
        {
            Log::error($e);
        }

        return false;
    }

    private function getPrivateKeyFile(string $username): ?string
    {

        return Storage::disk('local')->get("/ssh/{$username}");
        //return file_get_contents( storage_path()."/app/ssh/".$username);
    }
}
