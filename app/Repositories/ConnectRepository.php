<?php

namespace App\Repositories;

use App\Models\Connect;

class ConnectRepository
{

    /**
     * Get connect by id
     * @param int $id
     * @return object | null
     */
    public function getConnectById(int $id)
    {
        return Connect::where('id', $id)->first();
    }

    /**
     * @param int $connectId
     * @param string $secretId
     * @param string $secretKey
     * @return bool
     */
    public function setSPConnectById(int $connectId, string $secretId, string $secretKey)
    {
        $connect = $this->getConnectById($connectId);
        if (empty($connect)) {
            return false;
        }

        $connect->secret_id = $secretId;
        $connect->secret_key = $secretKey;
        $connect->save();

        return true;
    }

    /**
     * Delete SendPulse SecretId and SecretKey
     * @param int $connectId
     * @return bool
     */
    public function deleteSPConnectById(int $connectId)
    {
        $connect = $this->getConnectById($connectId);
        if (empty($connect)) {
            return false;
        }
        $connect->secret_id = null;
        $connect->secret_key = null;
        $connect->save();

        return true;
    }

    public function getSpConnectById(int $connectId)
    {
        $res = [];
        $connect = $this->getConnectById($connectId);

        if (!empty($connect)) {
            $res['secret_id'] = $connect->secret_id;
            $res['secret_key'] = $connect->secret_key;
        }

        return $res;
    }
}
