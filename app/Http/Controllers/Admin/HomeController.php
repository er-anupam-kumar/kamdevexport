<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Registration;
use App\Models\Client;
use App\Models\Order;

class HomeController extends Controller
{
	public function index()
	{
		return view('admin.dashboard.index');
	}
}
