<?php

namespace App\AdminModels;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;


class Admin extends Authenticatable {

  use Notifiable;

  public function sendPasswordResetNotification($token) {
      $this->notify(new ResetPasswordNotification($token, $this->email));
  }
}
