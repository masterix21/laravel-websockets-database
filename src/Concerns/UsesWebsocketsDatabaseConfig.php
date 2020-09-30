<?php
namespace Masterix21\WebsocketsDatabase\Concerns;

trait UsesWebsocketsDatabaseConfig
{
    public function getAppsTable()
    {
        return config('websockets-database.tables.apps') ?: 'ws_apps';
    }
}
