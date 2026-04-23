<?php

class DriverAndVehiclesController extends RestController {

    public function restEvents() {
        $this->onRest('req.get.driverList.render', function () {
            $dQuery = '1=1';
            if(isset($_GET['q'])){
                $q = $_GET['q'];
                $dQuery = "driver_fullname like '%{$q}%'";
            }
            $driverArr = array();
            $drivers = NatcDriver::model()->findAll("$dQuery order by driver_id desc limit 12");
            foreach ($drivers as $key => $driver) {
                $driverArr[$key]['head'] = $driver->attributes;
                $assigned = NatcVehicleDriver::model()->find("driver_id = {$driver->driver_id} and status = 'Current'");
                if($assigned){
                    $driverArr[$key]['vehicle'] = $assigned->attributes;
                    $vehicle = NatcVehicles::model()->findByPk($assigned->vehicle_id);
                    $driverArr[$key]['vehicle']['details'] = $vehicle->attributes;
                }
            }
            echo $this->restJsonEncode($driverArr);
        });

        $this->onRest('req.get.vehiclesList.render', function () {
            $vQuery = '1=1';
            if(isset($_GET['q'])){
                $q = $_GET['q'];
                $vQuery = "unit_no like '%{$q}%' or plate_no like '%{$q}%' or brand like '%{$q}%'";
            }
            $vehicleArr = array();
            $vehicles = NatcVehicles::model()->findAll("$vQuery order by vehicle_id desc limit 12");
            foreach ($vehicles as $key => $vehicle) {
                $vehicleArr[$key] = $vehicle->attributes;
            }
            echo $this->restJsonEncode($vehicleArr);
        });
        $this->onRest('req.post.assignVehicle.render', function ($data) {
            $driverVehicle = new NatcVehicleDriver();
            $driverVehicle->vehicle_id = $data['vehicleId'];
            $driverVehicle->driver_id = $data['driverId'];
            $driverVehicle->date_assigned = date('Y-m-d');
            $driverVehicle->date_revoked = '0000-00-00';
            $driverVehicle->status = 'Current';
            if($driverVehicle->save()){
                $vehicle = NatcVehicles::model()->findByPk($driverVehicle->vehicle_id);
                $vehicle->assign_status = 'assigned';
                $vehicle->save();
                echo $this->restJsonEncode("success");
            }else{
                throw new CHttpException(500, 'Unable to Assign this Vehicle to Driver');
            }

        });
        $this->onRest('req.get.revokeVehicle.render', function () {
            $driverId = $_GET['driverId'];
            $assignment = NatcVehicleDriver::model()->find("driver_id = {$driverId} and status = 'Current'");
            if($assignment){
                $assignment->status = 'History';
                $assignment->date_revoked = date('Y-m-d');
                $assignment->save();
                $vehicle = NatcVehicles::model()->findByPk($assignment->vehicle_id);
                $vehicle->assign_status = 'free';
                $vehicle->save();
                echo $this->restJsonEncode("success");
                exit;
            }else{
                throw new CHttpException(500, 'Unable to Assign this Vehicle to Driver');
            }

        });
        $this->onRest('req.post.addVehicle.render', function ($data) {
            $vehicle = new NatcVehicles();
            $vehicle->model = $data['model'];
            $vehicle->unit_no = $data['unit_no'];
            $vehicle->plate_no = $data['plate_no'];
            $vehicle->color = $data['color'];
            $vehicle->brand = $data['brand'];
            $vehicle->type = $data['type'];
            $vehicle->body_number = $data['body_no'];
            $vehicle->status = 1;
            $vehicle->assign_status = 'free';
            if($vehicle->save()){
                echo $this->restJsonEncode("success");
                exit;
            }else{
                throw new CHttpException(500, 'Unable to Add Vehicle');
            }
        });
        $this->onRest('req.post.addDrivers.render', function ($data) {
            $driver = new NatcDriver();
            $driver->driver_fullname = $data['driver_fullname'];
            $driver->driver_license_no = $data['driver_license_no'];
            $driver->driver_license_type = $data['driver_license_type'];
            $driver->driver_age = $data['driver_age'];
            $driver->driver_bdate = $data['driver_bdate'];
            $driver->status = 1;
            if($driver->save()){
                echo $this->restJsonEncode("success");
                exit;
            }else{
                throw new CHttpException(500, 'Unable to Add Driver');
            }
        });
    }
}
