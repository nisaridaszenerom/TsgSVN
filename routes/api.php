<?php

use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// GET ALL USERS DETAILS
Route::get('user',function(){
	$users = DB::table('member')->get();
	return $users;
		
});

// GET USER DATA WITH USER ID 
Route::post('getuser',function(){
	$data = $_POST; 
	try {
		$userdata = DB::table('member')->where('member_id','=',$data['member_id'])->select()->get();
		return array('status' => true,'data' => $userdata);
	}
	catch (\Exception $e) {
		return array('status' => false,'data' => $e->getMessage());
	}		
});

// LOGIN USER WITH USERNAME AND PASSWORD
Route::post('login',function(){
	$data = $_POST;
	try {
		$userdata = DB::table('member')->where('member_username','=',$data['username'])->where('member_password','=',MD5($data['password']))->select()->get();
		return array('status' => true,'data' => $userdata);
	}
	catch (\Exception $e) {
		return array('status' => false,'data' => $e->getMessage());
	}		
});

// ADD USER ABOUT DETAILS
Route::post('addabout',function(){
	$data = $_POST;
	try {
		$dataval = [
			'memberabout_member' 			=> $data['member_id'],
			'memberabout_wannameet'			=> $data['want_to_meet'],
			'memberabout_placeoforgin' 		=> $data['where_you_from'],
			'memberabout_placeliving' 		=> $data['where_do_you_live'],
			'memberabout_maritalstatus' 	=> $data['marital_status'],
			'memberabout_childrencount' 	=> $data['no_of_kids'],
			'memberabout_bio' 				=> $data['bio'],
			'memberabout_fewwords' 			=> $data['few_words'],
			'memberabout_interests'			=> $data['interest'],
			'memberabout_canbereachedby'	=> $data['canbereachedby'],
			'memberabout_dou'				=> NOW()
		];
		$lastInsertedID = DB::table('memberabout')->insert($dataval);
		$datareturn = DB::table('memberabout')->where('memberabout_member',$data['member_id'])->select()->get()->first();
		return array('status' => true,'data' => 'User abaout added','id' => $datareturn->memberabout_id);	
	}
	catch (\Exception $e) {
		return array('status' => false,'data' => $e->getMessage());
	}		
});

// EDIT USER ABOUT DETAILS
Route::post('editabout',function(){
	$data = $_POST;
	try {
		$dataval = [
			'memberabout_wannameet'			=> isset($data['want_to_meet'])? $data['want_to_meet']:'',
			'memberabout_placeoforgin' 		=> isset($data['where_you_from']) ? $data['where_you_from']: '',
			'memberabout_placeliving' 		=> isset($data['where_do_you_live']) ? $data['where_do_you_live']:'',
			'memberabout_maritalstatus' 	=> isset($data['marital_status']) ? $data['marital_status']:'',
			'memberabout_childrencount' 	=> isset($data['no_of_kids']) ? $data['no_of_kids']:'',
			'memberabout_bio' 				=> isset($data['bio']) ? $data['bio']:'',
			'memberabout_fewwords' 			=> isset($data['few_words']) ? $data['few_words']:'',
			'memberabout_interests'			=> isset($data['interest']) ? $data['interest']:'',
			'memberabout_canbereachedby'	=> isset($data['canbereachedby']) ? $data['canbereachedby']:'',
			'memberabout_dou'				=> NOW()
		];
		$updateData = DB::table('memberabout')->where('memberabout_member',$data['member_id'])->update($dataval);
		$datareturn = DB::table('memberabout')->where('memberabout_member',$data['member_id'])->select()->get()->first();
		return array('status' => true,'data' => 'User abaout updated','id' => $datareturn->memberabout_id);	
	}
	catch (\Exception $e) {
		return array('status' => false,'data' => $e->getMessage());
	}		
});

// GET USER ABOUT DETAILS 
Route::post('viewabout',function(){
	$data = $_POST;
	try{
	$datareturn = DB::table('memberabout')->where('memberabout_member',$data['member_id'])->select()->get()->first();
	return array('status' => true,'data' => $datareturn);	
	}
	catch (\Exception $e) {
		return array('status' => false,'data' => $e->getMessage());
	}		
});

// ADD USER LIKES
Route::post('addlike',function(){
	$data = $_POST;
	try {
		$dataval = [
			'ilike_member' 				=> $data['member_id'],
			'ilike_sport' 				=> $data['sport'],
			'ilike_travel' 				=> $data['travel'],
			'ilike_culture' 			=> $data['culture'],
			'ilike_learningnewthings' 	=> $data['learining_new'],
			'ilike_foodies' 			=> $data['foodies'],
			'ilike_networking' 			=> $data['networking'],
			'ilike_entrepreneurship'	=> $data['entrepreneurship'],
			'ilike_startup'				=> $data['startup'],
			'ilike_dou'					=> NOW()
		];
		$lastInsertedID = DB::table('ilike')->insert($dataval);
		$datareturn = DB::table('ilike')->where('ilike_member',$data['member_id'])->select()->get()->first();
		return array('status' => true,'data' => 'User like added','id' => $datareturn->ilike_id);	
	}
	catch (\Exception $e) {
		return array('status' => false,'data' => $e->getMessage());
	}		
});

// EDIT USER LIKES
Route::post('editlike',function(){
	$data = $_POST;
	try {
		$dataval = [
			'ilike_sport' 				=> isset($data['sport']) ? $data['sport']:'',
			'ilike_travel' 				=> isset($data['travel']) ? $data['travel']:'',
			'ilike_culture' 			=> isset($data['culture']) ? $data['culture']:'',
			'ilike_learningnewthings' 	=> isset($data['learining_new']) ? $data['learining_new']:'',
			'ilike_foodies' 			=> isset($data['foodies']) ? $data['foodies']:'',
			'ilike_networking' 			=> isset($data['networking']) ? $data['networking']:'',
			'ilike_entrepreneurship'	=> isset($data['entrepreneurship']) ? $data['entrepreneurship']:'',
			'ilike_startup'				=> isset($data['startup']) ? $data['startup']:'',
			'ilike_dou'					=> NOW()
		];
		$updateData = DB::table('ilike')->where('ilike_member',$data['member_id'])->update($dataval);
		$datareturn = DB::table('ilike')->where('ilike_member',$data['member_id'])->select()->get()->first();
		return array('status' => true,'data' => 'User like updated','id' => $datareturn->memberabout_id);	
	}
	catch (\Exception $e) {
		return array('status' => false,'data' => $e->getMessage());
	}		
});

// GET USER LIKE DETAILS
Route::post('viewlike',function(){
	$data = $_POST;
	try{
	$datareturn = DB::table('ilike')->where('ilike_member',$data['member_id'])->select()->get()->first();
	return array('status' => true,'data' => $datareturn);	
	}
	catch (\Exception $e) {
		return array('status' => false,'data' => $e->getMessage());
	}		
});

// RESET PASSWORD OF USER WITH USERNAME
Route::post('resetpassword',function(){
	$data = $_POST;
	try {
		$dataval = ['member_password' => MD5($data['password'])];
		//print_r($data);
		$updateData = DB::table('member')->where('member_id',$data['member_id'])->update($dataval);
		return array('status' => true,'member_id' => $data['member_id']);			
	}
	catch (\Exception $e) {
		return array('status' => false,'data' => $e->getMessage());
	}				
});


// ADD LOCATION
Route::post('addlocation',function(){
	$data = $_POST;
	try {
		//$places = explode(',',$data['places']);
		$dataval = [
			'destination_member'		=> $data['member_id'],
			'destination_name'			=> $data['name'],
			'destination_places' 		=> $data['places'],
		];		
		$insertData = DB::table('destination')->insert($dataval);
		$datareturn = DB::table('destination')->where('destination_member',$data['member_id'])->select()->get()->first();
		return array('status' => true,'data' => 'Location added','id' => $datareturn->destination_id);
	}
	catch (\Exception $e) {
		return array('status' => false,'data' => $e->getMessage());
	}		
});


// EDIT LOCATION
Route::post('editlocation',function(){
	$data = $_POST;
	try {
		//$places = explode(',',$data['places']);
		$dataval = [
			'destination_name'			=> $data['name'],
			'destination_places' 		=> $data['places'],
		];		
		$updateData = DB::table('destination')->where('destination_member',$data['member_id'])->update($dataval);
		$datareturn = DB::table('destination')->where('destination_member',$data['member_id'])->select()->get()->first();
		return array('status' => true,'data' => 'Location updated.','id' => $datareturn->destination_id);
	}
	catch (\Exception $e) {
		return array('status' => false,'data' => $e->getMessage());
	}		
});

// GET LOCATION
Route::post('viewlocation',function(){
	$data = $_POST;
	try{
	$datareturn = DB::table('destination')->where('destination_member',$data['member_id'])->select()->get()->first();
	return array('status' => true,'data' => $datareturn);	
	}
	catch (\Exception $e) {
		return array('status' => false,'data' => $e->getMessage());
	}		
});


