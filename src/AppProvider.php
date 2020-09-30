<?php
namespace Masterix21\WebsocketsDatabase;

use BeyondCode\LaravelWebSockets\Apps\App;
use BeyondCode\LaravelWebSockets\Apps\AppProvider as IAppProvider;

class AppProvider implements IAppProvider
{
    public function all(): array
    {
        return Models\App::query()
            ->where('active', true)
            ->get()
            ->map(function (Models\App $app) {
                return $this->instanciate($app->toArray());
            })
            ->toArray();
    }

    public function findById($appId): ?App
    {
        return $this->instanciate(
            Models\App::query()
                ->where('active', true)
                ->where('id', $appId)
                ->first()->toArray() ?? null
        );
    }

    public function findByKey(string $appKey): ?App
    {
        return $this->instanciate(
            Models\App::query()
                ->where('key', $appKey)
                ->where('active', true)
                ->first()->toArray() ?? null
        );
    }

    public function findBySecret(string $appSecret): ?App
    {
        return $this->instanciate(
            Models\App::query()
                ->where('secret', $appSecret)
                ->where('active', true)
                ->first()->toArray() ?? null
        );
    }

    protected function instanciate(?array $appAttributes): ?App
    {
        if (blank($appAttributes)) {
            return null;
        }

        $app = new App($appAttributes['id'], $appAttributes['key'], $appAttributes['secret']);

        if (isset($appAttributes['name'])) {
            $app->setName($appAttributes['name']);
        }

        if (isset($appAttributes['host'])) {
            $app->setHost($appAttributes['host']);
        }

        $app
            ->enableClientMessages($appAttributes['enable_client_messages'])
            ->enableStatistics($appAttributes['enable_statistics']);

        return $app;
    }
}
