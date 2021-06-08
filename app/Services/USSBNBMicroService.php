<?php

namespace App\Services;
use App\Traits\CallMicroService;

class USSBNBMicroService
{
	use CallMicroService ;
	public $baseUri;
	public $secret;

	public function __construct(){
		$this->baseUri = config('services.ussBnbMicroservice.base_uri');
		$this->secret = config('services.ussBnbMicroservice.secret');
	}
// ----------------------------------------------------------------------
    public function getAllCountries() {
        return $this->performRequest('GET', 'api/v1/countries');
    }

    function createCountry($data){
        return $this->performRequest('POST', '/api/v1/countries', $data);
    }

    function editCountry($id){
        return $this->performRequest('GET', "/api/v1/countries/$id");
    }

    function updateCountry($data, $id) {
        return $this->performRequest('PUT', "/api/v1/countries/$id", $data);
    }

    function deleteCountry($id) {
        return $this->performRequest('DELETE', "/api/v1/countries/$id");
    }

	// catalog services api call
//--------------------------- Building functions--------------------------
	function getAllBuilding(){
		//echo $this->baseUri;die;
		return $this->performRequest('GET', 'api/v1/catalog/building');
	}

	//-------------------------- location------------------------------------
	public function getAlllocations() {
        return $this->performRequest('GET', 'api/v1/locations');
    }
	public function createLocation($data){
        return $this->performRequest('POST', '/api/v1/locations', $data);
    }
    public function getLocationById($locationId) {
        return $this->performRequest('GET', "/api/v1/locations/$locationId");
    }
	public function updateLocation($data, $locationId) {
	    return $this->performRequest('PUT', "/api/v1/locations/$locationId", $data );
    }
	public function deleteLocation($locationId) {
        return $this->performRequest('DELETE', "/api/v1/locations/$locationId");
    }
	//-----------------------end location ---------------------------------


	//-------------------------- Building------------------------------------
	public function getAllBuildings() {
        return $this->performRequest('GET', 'api/v1/buildings');
    }

    public function getBuildingDetail($id){
		return $this->performRequest('GET', "/api/v1/buildings/$id");
	}

	public function createBuilding($data){
        return $this->performRequest('POST', '/api/v1/buildings', $data);
    }

	public function updateBuilding($data, $buildingId) {
	    return $this->performRequest('PUT', "/api/v1/buildings/$buildingId", $data );
    }
	public function deleteBuilding($buildingId) {
        return $this->performRequest('DELETE', "/api/v1/buildings/$buildingId");
    }

//    public function getBuildingById($buildingId) {
//        return $this->performRequest('GET', "/api/v1/building/$buildingId");
//    }
	//-----------------------end building ---------------------------------



//--------------------------- Rooms functions--------------------------
	function getAllRooms(){
		return $this->performRequest('GET', '/api/v1/rooms');
	}
	function getRoomDetail($id){
		return $this->performRequest('GET', "/api/v1/rooms/$id");
	}
	function getEditRoomDetail($id){
        return $this->performRequest('GET', "/api/v1/rooms/$id/edit");
	}
	function updateRoom($data, $id){
		return $this->performRequest('PUT', '/api/v1/rooms/{id}', $data);
	}
	function createRoom($data){
		//dd($data);
		return $this->performRequest('POST', '/api/v1/rooms', $data);
	}
	function deleteRoom($id){
		return $this->performRequest('DELETE', "/api/v1/rooms/$id");
	}
//------------------------------end Rooms---------------------------------




//--------------------------- Booking functions--------------------------
	function getAllBookings(){
		return $this->performRequest('GET', '/api/v1/bookings');
	}

    function createBooking($data){
        return $this->performRequest('POST', '/api/v1/bookings', $data);
    }

    function getBookingDetail($id){
        return $this->performRequest('GET', "/api/v1/bookings/$id");
    }

    function getEditBookingDetail($id) {
        return $this->performRequest('GET', "/api/v1/booking/edit/$id");
    }

    function updateBooking($data, $id) {
        return $this->performRequest('PUT', "/api/v1/bookings/$id", $data);
    }

    function updateBookingStatus($status, $id) {
        return $this->performRequest('GET', "/api/v1/booking/status/$status/$id");
    }

    function deleteBooking($id)
    {
        return $this->performRequest('DELETE', "/api/v1/booking/$id");
    }

//------------------------------end Booking---------------------------------




}
