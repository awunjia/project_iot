<?php

namespace App\Repositories;

use App\Models\Sensor;

class SensorRepo
{
    public function createSensor(array $data): Sensor
    {
        return Sensor::create($data);
    }

    public function findSensorById(int $id): ? Sensor
    {
        return Sensor::find($id);
    }

    public function updateSensor(int $id, array $data): Sensor
    {
        $sensor = $this->findSensorById($id);
        $sensor->update($data);
        return $sensor;
    }

    public function deleteSensor(int $id): bool
    {
        $sensor = $this->findSensorById($id);
        return $sensor ? $sensor->delete() : false;
    }

    public function getAllSensors()
    {
        return Sensor::paginate(10);
    }
}