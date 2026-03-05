<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceTest extends Model
{
  protected $table = 'device_tests';
  protected $fillable = [
   'name',
  ];

}
